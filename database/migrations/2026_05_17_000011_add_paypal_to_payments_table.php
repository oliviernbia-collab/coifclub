<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE payments MODIFY method ENUM('orange_money','mtn_money','wave','stripe','paypal','apple_pay','google_pay','cash') NOT NULL DEFAULT 'orange_money'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY method ENUM('orange_money','mtn_money','wave','stripe','apple_pay','google_pay','cash') NOT NULL DEFAULT 'orange_money'");
    }
};
