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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); // Relación con proyectos
            $table->foreignId('phase_id')->nullable()->constrained('phases')->onDelete('set null'); // Relación opcional con fases
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('completed')->default(false); // Indica si la tarea está completada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
