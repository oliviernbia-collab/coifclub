<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use App\Models\Like;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Reservation;
use App\Models\User;
use App\Policies\PaymentPolicy;
use App\Policies\ReservationPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ── Policies Eloquent ──────────────────────────────────────────────
        Gate::policy(Reservation::class, ReservationPolicy::class);
        Gate::policy(Payment::class, PaymentPolicy::class);

        // ── Gates de permission ────────────────────────────────────────────
        // Seul un super-admin peut modifier/supprimer un autre super-admin
        Gate::define('manage-user', function (User $auth, User $target) {
            if ($target->isSuperAdmin() && !$auth->isSuperAdmin()) {
                return false;
            }
            return $auth->isAdmin();
        });

        // Seul un admin peut accéder au panel d'administration
        Gate::define('access-admin', function (User $user) {
            return $user->isAdmin();
        });

        // Un utilisateur ne peut modifier que son propre profil (ou un admin)
        Gate::define('edit-profile', function (User $auth, User $target) {
            return $auth->id === $target->id || $auth->isAdmin();
        });

        // Un client ne peut voir que ses propres réservations
        Gate::define('view-reservation', function (User $auth, $reservation) {
            if ($auth->isAdmin() || $auth->isEmployee()) return true;
            return isset($reservation->client_id) && $auth->id === $reservation->client_id;
        });

        // Un employé ne peut gérer que ses propres plannings
        Gate::define('manage-planning', function (User $auth, $planning = null) {
            return $auth->isEmployee() || $auth->isAdmin();
        });

        if (app()->bound('session') && session()->has('locale')) {
            $locale = session('locale');
            $availableLocales = ['en', 'fr', 'es'];

            if (in_array($locale, $availableLocales)) {
                app()->setLocale($locale);
            }
        }

        // Partage de la promotion active avec toutes les vues
        View::composer('*', function ($view) {
            $promo = Promotion::where('is_active', true)
                ->where('status', 'active')
                ->where('valid_from', '<=', now())
                ->where('valid_until', '>=', now())
                ->orderBy('valid_from')
                ->first();

            $view->with('activePromotion', $promo);
        });

        // Partage du total des likes (tous utilisateurs) avec la navbar
        View::composer('partials.main-navbar', function ($view) {
            $view->with('totalLikes', Like::count());
        });
    }
}
