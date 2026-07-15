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
        // TABLE: LOYALTY PROGRAM (Programme de fidélité)
        if (! Schema::hasTable('loyalty_points')) {
            Schema::create('loyalty_points', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->integer('balance')->default(0); // Solde des points
                $table->integer('lifetime_points')->default(0); // Points cumulés à vie
                $table->integer('tier')->default(1); // 1=Bronze, 2=Silver, 3=Gold, 4=Platinum
                $table->timestamp('tier_updated_at')->nullable();
                $table->timestamps();
            });
        }

        // TABLE: LOYALTY TRANSACTIONS (Historique des points)
        if (! Schema::hasTable('loyalty_transactions')) {
            Schema::create('loyalty_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('set null');
                $table->integer('points_earned')->default(0);
                $table->integer('points_spent')->default(0);
                $table->string('reason'); // 'reservation', 'redemption', 'bonus', 'expiration'
                $table->string('status')->default('completed'); // 'pending', 'completed', 'expired'
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // TABLE: VIP SUBSCRIPTIONS (Abonnements VIP)
        if (! Schema::hasTable('vip_subscriptions')) {
            Schema::create('vip_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('plan'); // 'monthly', 'quarterly', 'annual'
                $table->decimal('price', 8, 2);
                $table->string('status')->default('active'); // 'active', 'paused', 'cancelled'
                $table->timestamp('started_at')->nullable();
                $table->timestamp('ends_at')->nullable();
                $table->timestamp('renewal_at')->nullable();
                $table->integer('reservation_count_included')->default(0); // Nombre de rdv inclus
                $table->integer('discount_percentage')->default(15); // Réduction %
                $table->boolean('priority_booking')->default(true);
                $table->boolean('free_service_monthly')->default(false);
                $table->timestamps();
            });
        }

        // TABLE: PROMOTIONS (Codes promo, offres)
        if (! Schema::hasTable('promotions')) {
            Schema::create('promotions', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->text('description');
                $table->string('type'); // 'percentage', 'fixed_amount', 'free_service'
                $table->decimal('value', 8, 2); // Valeur de la réduction
                $table->integer('usage_limit')->nullable();
                $table->integer('usage_count')->default(0);
                $table->timestamp('valid_from')->nullable();
                $table->timestamp('valid_until')->nullable();
                $table->boolean('is_active')->default(true);
                $table->decimal('minimum_amount')->nullable(); // Montant minimum
                $table->timestamps();
            });
        }

        // TABLE: CANCELLATION POLICIES (Politiques d'annulation)
        if (! Schema::hasTable('cancellation_policies')) {
            Schema::create('cancellation_policies', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // '48h', '24h', 'last_minute'
                $table->integer('hours_before'); // Nombre d'heures avant le rdv
                $table->integer('refund_percentage')->default(100); // % de remboursement
                $table->string('description');
                $table->boolean('is_default')->default(false);
                $table->timestamps();
            });
        }

        // TABLE: CANCELLATIONS (Historique des annulations)
        if (! Schema::hasTable('cancellations')) {
            Schema::create('cancellations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
                $table->string('reason')->nullable();
                $table->integer('refund_percentage');
                $table->decimal('refund_amount', 8, 2);
                $table->string('status')->default('pending'); // 'pending', 'approved', 'rejected'
                $table->text('admin_notes')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_points');
        Schema::dropIfExists('loyalty_transactions');
        Schema::dropIfExists('vip_subscriptions');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('cancellation_policies');
        Schema::dropIfExists('cancellations');
    }
};
