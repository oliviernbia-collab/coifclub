<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE payments DROP FOREIGN KEY payments_reservation_id_foreign');
        DB::statement('ALTER TABLE payments MODIFY reservation_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE payments ADD CONSTRAINT payments_reservation_id_foreign FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE');
        DB::statement("ALTER TABLE payments MODIFY method ENUM('orange_money','mtn_money','wave','stripe','apple_pay','google_pay','cash') NOT NULL DEFAULT 'orange_money'");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE payments DROP FOREIGN KEY payments_reservation_id_foreign');
        DB::statement('ALTER TABLE payments MODIFY reservation_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE payments ADD CONSTRAINT payments_reservation_id_foreign FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE');
        DB::statement("ALTER TABLE payments MODIFY method ENUM('orange_money','mtn_money','wave','stripe','cash') NOT NULL DEFAULT 'orange_money'");
    }
};
