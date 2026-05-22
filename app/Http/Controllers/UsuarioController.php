<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Enums\RoleEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function indexDiretores(): View
    {
        $this->authorize('viewAny', User::class);
        $usuarios = $this->userService->listarPorRole(RoleEnum::Diretor);
        $role     = RoleEnum::Diretor;
        return view('usuarios.index', compact('usuarios', 'role'));
    }

    public function indexSecretarios(): View
    {
        $this->authorize('viewAny', User::class);
        $usuarios = $this->userService->listarPorRole(RoleEnum::Secretario);
        $role     = RoleEnum::Secretario;
        return view('usuarios.index', compact('usuarios', 'role'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);
        $role = request('role') ? RoleEnum::from(request('role')) : null;
        return view('usuarios.create', compact('role'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);
        $dto = UserDTO::fromArray($request->validated());
        $this->userService->criar($dto);

        $redirect = match($dto->role) {
            RoleEnum::Secretario => 'usuarios.secretarios',
            default              => 'usuarios.diretores',
        };

        return redirect()->route($redirect)->with('success', 'Usuário criado com sucesso!');
    }

    public function show(User $usuario): View
    {
        $this->authorize('view', $usuario);
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario): View
    {
        $this->authorize('update', $usuario);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(UpdateUserRequest $request, User $usuario): RedirectResponse
    {
        $this->authorize('update', $usuario);
        $this->userService->atualizar($usuario, $request->validated());

        return redirect()->route('usuarios.show', $usuario)
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        $this->authorize('delete', $usuario);
        $this->userService->excluir($usuario);

        return back()->with('success', 'Usuário removido com sucesso!');
    }
}
