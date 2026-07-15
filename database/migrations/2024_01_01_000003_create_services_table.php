<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
     Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->foreignId('salon_id')->constrained()->onDelete('cascade');

        $table->foreignId('categorie_id')
            ->constrained('categories')
            ->onDelete('cascade');

        $table->string('name');
        $table->text('description')->nullable();
        $table->unsignedInteger('price');
        $table->unsignedInteger('duration');

        $table->string('image')->nullable();
        $table->string('emoji')->default('✨');

        $table->boolean('is_active')->default(true);
        $table->unsignedInteger('sort_order')->default(0);

        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
