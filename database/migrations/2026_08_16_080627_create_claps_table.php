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
        Schema::create('claps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // En Medium, un mismo usuario puede aplaudir un post varias
            // veces (hasta 50). Guardamos el conteo en vez de crear
            // una fila por cada clap, es más eficiente.
            $table->unsignedInteger('count')->default(1);

            $table->timestamps();

            // Un usuario tiene UNA sola fila de claps por post
            // (se actualiza el "count", no se duplica la fila).
            $table->unique(['post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claps');
    }
};
