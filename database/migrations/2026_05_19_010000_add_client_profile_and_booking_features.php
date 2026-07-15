<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('avatar');
            $table->text('habits')->nullable()->after('birth_date');
            $table->text('preferences')->nullable()->after('habits');
            $table->text('allergies')->nullable()->after('preferences');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->string('current_hair_image')->nullable()->after('client_notes');
            $table->string('desired_style_image')->nullable()->after('current_hair_image');
            $table->boolean('terms_conditions')->default(false)->after('status');
            $table->boolean('terms_delays')->default(false)->after('terms_conditions');
            $table->boolean('terms_refunds')->default(false)->after('terms_delays');
            $table->timestamp('terms_signed_at')->nullable()->after('terms_refunds');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'current_hair_image',
                'desired_style_image',
                'terms_conditions',
                'terms_delays',
                'terms_refunds',
                'terms_signed_at',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birth_date', 'habits', 'preferences', 'allergies']);
        });
    }
};
