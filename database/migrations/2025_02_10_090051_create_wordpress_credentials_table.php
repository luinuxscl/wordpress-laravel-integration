<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wordpress_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('site_url'); // URL del sitio WordPress
            $table->string('username'); // Usuario de autenticación
            $table->string('password'); // Contraseña de autenticación
            $table->boolean('is_default')->default(false); // Indica si es la credencial predeterminada
            $table->string('site_name')->nullable(); // Nombre del sitio WordPress

            // Relación polimórfica
            $table->morphs('credentialable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wordpress_credentials');
    }
};
