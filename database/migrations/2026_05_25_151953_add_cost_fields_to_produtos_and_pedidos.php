<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->decimal('unt_cust', 10, 2)->nullable()->after('qnt_max');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->decimal('total_cust', 12, 2)->nullable()->after('obs_secretario');
        });
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('unt_cust');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('total_cust');
        });
    }
};
