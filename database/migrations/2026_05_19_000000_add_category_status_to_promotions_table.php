<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            if (! Schema::hasColumn('promotions', 'category')) {
                $table->string('category')->default('general')->after('type');
            }

            if (! Schema::hasColumn('promotions', 'status')) {
                $table->string('status')->default('active')->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            if (Schema::hasColumn('promotions', 'category')) {
                $table->dropColumn('category');
            }

            if (Schema::hasColumn('promotions', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
