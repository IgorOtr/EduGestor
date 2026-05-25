<?php

namespace App\Services;

use App\DTOs\PedidoDTO;
use App\Enums\ItemPedidoStatusEnum;
use App\Enums\PedidoStatusEnum;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Repositories\PedidoRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PedidoService
{
    public function __construct(private readonly PedidoRepository $pedidoRepository) {}

    public function listar(int $perPage = 15): LengthAwarePaginator
    {
        $user   = auth()->user();
        $userId = $user->isDiretor() ? $user->id : null;
        return $this->pedidoRepository->paginate($perPage, [], $userId);
    }

    public function criar(PedidoDTO $dto): Pedido
    {
        return DB::transaction(function () use ($dto) {
            $pedido = $this->pedidoRepository->create([
                'escola_id' => $dto->escola_id,
                'user_id'   => $dto->user_id,
                'status'    => PedidoStatusEnum::Pendente,
            ]);

            foreach ($dto->itens as $item) {
                ItemPedido::create([
                    'pedido_id'   => $pedido->id,
                    'produto_id'  => $item['produto_id'],
                    'qnt_solicit' => $item['qnt_solicit'],
                    'status'      => ItemPedidoStatusEnum::Pendente,
                ]);
            }

            return $pedido->load(['itens.produto', 'escola']);
        });
    }

    public function aprovar(Pedido $pedido, array $itens, ?string $obs = null): Pedido
    {
        return DB::transaction(function () use ($pedido, $itens, $obs) {
            foreach ($itens as $itemData) {
                $item = ItemPedido::find($itemData['id']);
                if (!$item) continue;

                $qntAprov = (int) $itemData['qnt_aprov'];

                if ($qntAprov <= 0) {
                    $item->update(['qnt_aprov' => 0, 'status' => ItemPedidoStatusEnum::Recusado]);
                } elseif ($qntAprov >= $item->qnt_solicit) {
                    $item->update(['qnt_aprov' => $item->qnt_solicit, 'status' => ItemPedidoStatusEnum::Aprovado]);
                } else {
                    $item->update(['qnt_aprov' => $qntAprov, 'status' => ItemPedidoStatusEnum::Parcial]);
                }
            }

            $status = $this->calcularStatusPedido($pedido->fresh(['itens.produto']));

            // Calcula custo total com base nos itens aprovados e no custo unitário de cada produto
            $totalCust = $pedido->fresh(['itens.produto'])->itens->sum(function ($item) {
                $qnt  = $item->qnt_aprov ?? 0;
                $cust = $item->produto?->unt_cust ?? 0;
                return $qnt * $cust;
            });

            $pedido->update([
                'status'         => $status,
                'obs_secretario' => $obs,
                'aprovado_em'    => now(),
                'total_cust'     => $totalCust > 0 ? $totalCust : null,
            ]);

            return $pedido->fresh(['itens.produto', 'escola', 'diretor']);
        });
    }

    public function recusar(Pedido $pedido, ?string $obs = null): Pedido
    {
        return DB::transaction(function () use ($pedido, $obs) {
            $pedido->itens()->update(['status' => ItemPedidoStatusEnum::Recusado, 'qnt_aprov' => 0]);
            $pedido->update([
                'status'         => PedidoStatusEnum::Recusado,
                'obs_secretario' => $obs,
                'aprovado_em'    => now(),
            ]);
            return $pedido->fresh();
        });
    }

    private function calcularStatusPedido(Pedido $pedido): PedidoStatusEnum
    {
        $itens     = $pedido->itens;
        $aprovados = $itens->where('status', ItemPedidoStatusEnum::Aprovado)->count();
        $recusados = $itens->where('status', ItemPedidoStatusEnum::Recusado)->count();
        $total     = $itens->count();

        if ($recusados === $total) {
            return PedidoStatusEnum::Recusado;
        }

        if ($aprovados === $total) {
            return PedidoStatusEnum::Aprovado;
        }

        return PedidoStatusEnum::ParcialmenteAprovado;
    }

    public function buscarPorId(string $id): Pedido
    {
        return $this->pedidoRepository->findOrFail($id, ['itens.produto', 'escola', 'diretor']);
    }

    public function pendentes(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->pedidoRepository->pendentes();
    }

    public function porEscola(string $escolaId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->pedidoRepository->porEscola($escolaId);
    }
}
