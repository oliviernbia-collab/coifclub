<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('transaction_id')->unique()->nullable(); // ID retourné par le gateway
            $table->unsignedInteger('amount'); // En FCFA
            $table->enum('method', ['orange_money','mtn_money','wave','stripe','cash'])
                  ->default('orange_money');
            $table->enum('status', ['pending','processing','completed','failed','refunded'])
                  ->default('pending');
            $table->string('phone_number')->nullable(); // Pour Mobile Money
            $table->json('gateway_response')->nullable(); // Réponse brute du gateway
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
