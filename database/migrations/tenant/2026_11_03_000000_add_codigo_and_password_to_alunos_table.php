<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasCodigo = Schema::hasColumn('alunos', 'codigo');
        $hasPassword = Schema::hasColumn('alunos', 'password');

        if ($hasCodigo && $hasPassword) {
            return;
        }

        Schema::table('alunos', function (Blueprint $table) use ($hasCodigo, $hasPassword) {
            if (!$hasCodigo) {
                $table->string('codigo', 5)->nullable()->unique();
            }

            if (!$hasPassword) {
                $table->string('password')->nullable();
            }
        });
    }

    public function down(): void
    {
        $hasCodigo = Schema::hasColumn('alunos', 'codigo');
        $hasPassword = Schema::hasColumn('alunos', 'password');

        if (!$hasCodigo && !$hasPassword) {
            return;
        }

        Schema::table('alunos', function (Blueprint $table) use ($hasCodigo, $hasPassword) {
            $columns = [];

            if ($hasCodigo) {
                $columns[] = 'codigo';
            }

            if ($hasPassword) {
                $columns[] = 'password';
            }

            $table->dropColumn($columns);
        });
    }
};
