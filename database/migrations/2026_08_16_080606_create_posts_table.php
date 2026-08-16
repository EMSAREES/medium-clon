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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Autor del artículo. constrained() asume que apunta a users.id
            // por convención (user_id -> tabla "users", columna "id").
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Categoría del artículo. nullable() porque un post podría
            // quedar sin categoría asignada (borrador, por ejemplo).
            // nullOnDelete(): si se borra la categoría, el post NO se
            // borra, solo su category_id queda en null.
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            // Resumen corto para las tarjetas de listado (opcional).
            $table->string('excerpt')->nullable();

            // Contenido completo del artículo (HTML/markdown renderizado).
            $table->longText('content');

            // Imagen de portada, opcional.
            $table->string('cover_image')->nullable();

            // Si es null, el post es un borrador (no publicado aún).
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
