<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['salon_id']);

            $table->unsignedBigInteger('service_id')->nullable()->change();
            $table->unsignedBigInteger('employee_id')->nullable()->change();
            $table->unsignedBigInteger('salon_id')->nullable()->change();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('salon_id')->references('id')->on('salons')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['salon_id']);

            $table->unsignedBigInteger('service_id')->nullable(false)->change();
            $table->unsignedBigInteger('employee_id')->nullable(false)->change();
            $table->unsignedBigInteger('salon_id')->nullable(false)->change();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('salon_id')->references('id')->on('salons')->onDelete('cascade');
        });
    }
};
