<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Disponibilités hebdomadaires récurrentes
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->enum('day_of_week', ['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche']);
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('slot_duration')->default(30); // minutes par créneau
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['employee_id', 'day_of_week']);
        });

        // Indisponibilités ponctuelles (congés, absences)
        Schema::create('unavailabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('start_time')->nullable(); // null = toute la journée
            $table->time('end_time')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unavailabilities');
        Schema::dropIfExists('availabilities');
    }
};
