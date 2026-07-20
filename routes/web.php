<?php

/*
|=============================================================================
| APPLICATION ROUTES — SALON DE COIFFURE
|=============================================================================
|
| Organisation :
|   1. Imports des contrôleurs
|   2. Authentification  (guest)
|   3. Pages publiques
|   4. Réservation intelligente (wizard)
|   5. Espace authentifié  (tous rôles)
|   6. Espace Admin
|   7. Espace Employé (Prestataire)
|   8. Espace Client
|   9. Profil utilisateur
|  10. Divers / Légal
|
*/

use Illuminate\Support\Facades\Route;

/*
|─────────────────────────────────────────────────────────────────────────────
| CONTRÔLEURS
|─────────────────────────────────────────────────────────────────────────────
*/

// — Auth & Profil
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// — Pages principales
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PublicController;

// — Catalogue
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BlogController;

// — Réservation & Paiement
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

// — Espace utilisateur
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LikeController;

// — Admin
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;

use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\VipController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\RevenuController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\Prestataire\PlanningController as PrestatairePlanningController;
use App\Http\Controllers\Prestataire\RevenuController as PrestataireRevenuController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\SeoController;

/*
|─────────────────────────────────────────────────────────────────────────────
| 0. SEO (robots.txt, sitemap.xml)
|─────────────────────────────────────────────────────────────────────────────
*/

Route::get('/robots.txt',  [SeoController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');

/*
|─────────────────────────────────────────────────────────────────────────────
| 1. AUTHENTIFICATION  (invités uniquement)
|─────────────────────────────────────────────────────────────────────────────
*/

Route::middleware('localize')->group(function () {

    Route::middleware('guest')->group(function () {

    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('throttle:10,1');

    Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email')->middleware('throttle:5,1');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('throttle:5,1');

    });
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|─────────────────────────────────────────────────────────────────────────────
| 2. PAGES PUBLIQUES
|─────────────────────────────────────────────────────────────────────────────
*/

Route::get('/',            [LandingController::class, 'home'])->name('home');
Route::get('/prestations',           [PublicController::class, 'services'])->name('services.index');
Route::get('/prestations/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::redirect('/services',         '/prestations', 301);
Route::redirect('/services/{service}', '/prestations/{service}', 301);
Route::get('/salons',      [SalonController::class,    'index'])->name('salons.index');
Route::get('/galerie',     [PublicController::class,   'gallery'])->name('gallery');
Route::get('/contact',     [PublicController::class,   'contact'])->name('contact');
Route::post('/contact',    [PublicController::class,   'submitContact'])->name('contact.send')->middleware('throttle:5,1');
Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe')->middleware('throttle:3,1');
Route::get('/coiffeurs',   [StylistController::class,  'index'])->name('stylists.index');
Route::get('/coiffeurs/{id}', [StylistController::class, 'show'])->name('stylists.show');
Route::get('/offers',      [OfferController::class,    'index'])->name('offers.index');
Route::get('/gallery',     [GalleryController::class,  'index'])->name('gallery.index');

//A propos
Route::get('/about', function () {
    return view('about');
})->name('about');


Route::middleware(['auth', 'role:admin,employee'])
    ->get('/team', [TeamController::class, 'index'])
    ->name('team.index');
Route::get('/blog',        [BlogController::class,     'index'])->name('blog.index');

Route::get('/checkout/pay/{payment}', [PaymentController::class, 'initiateStripe'])
    ->name('payment.stripe');

Route::get('/payment/mobile/{payment}', [PaymentController::class, 'initiateMobile'])
    ->name('payment.mobile');
Route::post('/payment/mobile/{payment}', [PaymentController::class, 'processMobile'])
    ->name('payment.mobile.process');

Route::get('/payment/paypal/{payment}', [PaymentController::class, 'showPayPal'])
    ->name('payment.paypal');
Route::get('/payment/paypal/{payment}/capture', [PaymentController::class, 'processPayPal'])
    ->name('payment.paypal.capture');

Route::get('/payment/success/{payment}', [PaymentController::class, 'success'])
    ->name('payment.success');
Route::get('/payment/cancel/{payment}', [PaymentController::class, 'cancel'])
    ->name('payment.cancel');
Route::post('/payment/webhook/{payment}', [PaymentController::class, 'webhook'])
    ->name('payment.webhook');

/*
|─────────────────────────────────────────────────────────────────────────────
| 3. RÉSERVATION INTELLIGENTE (Wizard multi-étapes)
|─────────────────────────────────────────────────────────────────────────────
*/

// Wizard publique jusqu'au paiement (authentification requise à partir de selectDateTime)
Route::prefix('booking')->name('booking.')->group(function () {

    Route::get('/',                         [BookingController::class, 'startBooking'])->name('start');
    Route::post('/service',                 [BookingController::class, 'selectService'])->name('service');
    Route::post('/employee',                [BookingController::class, 'selectEmployee'])->name('employee');

    // Réservation rapide (vue combinée service + date + créneau)
    Route::get('/quick',                    [BookingController::class, 'quickBooking'])->name('quick');

    // Les étapes suivantes nécessitent l'authentification
    Route::middleware(['auth', 'role:client'])->group(function () {
        Route::post('/quick',                   [BookingController::class, 'quickStore'])->name('quick.store');
        Route::post('/datetime',                [BookingController::class, 'selectDateTime'])->name('datetime');
        Route::get('/payment/{reservation}',    [BookingController::class, 'showPayment'])->name('payment');
        Route::get('/confirmation/{reservation}', [BookingController::class, 'showConfirmation'])->name('confirmation');
        Route::post('/confirm',                 [BookingController::class, 'confirmBooking'])->name('confirm');
    });

});

// AJAX : créneaux et coiffeuses disponibles (utilisés par booking/quick)
Route::post('/api/booking/employees', [ReservationController::class, 'availableEmployees'])->name('api.booking.employees');
Route::post('/api/booking/slots',     [ReservationController::class, 'availableSlots'])->name('api.booking.slots');

// AJAX publics : utilisés par le formulaire de réservation unique (single-step)
Route::post('/api/booking/employees-by-service', [BookingController::class, 'employeesByService'])->name('api.booking.employees-by-service');
Route::post('/api/booking/available-slots',      [BookingController::class, 'availableSlotsPublic'])->name('api.booking.available-slots');

// Réservation simplifiée : calendrier + créneau uniquement (sans service ni coiffeuse)
Route::get('/booking/appointment',               [BookingController::class, 'appointmentView'])->name('booking.appointment');
Route::post('/api/booking/appointment-slots',    [BookingController::class, 'appointmentSlotsForDate'])->name('api.booking.appointment-slots');
Route::middleware(['auth', 'role:client,admin'])->group(function () {
    Route::post('/booking/appointment',                          [BookingController::class, 'appointmentStore'])->name('booking.appointment.store');
    Route::get('/booking/appointment/confirmation/{reservation}',[BookingController::class, 'appointmentConfirmation'])->name('booking.appointment.confirmation');
});

/*
|─────────────────────────────────────────────────────────────────────────────
| 4. ESPACE AUTHENTIFIÉ  (tous rôles confondus)
|─────────────────────────────────────────────────────────────────────────────
*/

Route::middleware('auth')->group(function () {

    // Tableau de bord global (redirige selon le rôle)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Réservations
    Route::resource('reservations', BookingController::class);
    Route::get('/reservations/{id}/facture', [BookingController::class, 'facture'])->name('reservations.facture');
    Route::get('/reservation/create',        [BookingController::class, 'create'])->name('client.book');

    // Services & Salons (CRUD sauf index/show publics)
    Route::resource('services', ServiceController::class)->except(['index', 'show']);
    Route::resource('salons',   SalonController::class)->except(['index', 'show']);

    // Likes (services & produits)
    Route::post('/likes/toggle', [LikeController::class, 'toggle'])->name('likes.toggle');

    // Favoris
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/',                       [FavoriteController::class, 'index'])->name('index');
        Route::post('/{service}',             [FavoriteController::class, 'store'])->name('store');
        Route::delete('/{service}',           [FavoriteController::class, 'destroy'])->name('destroy');
        Route::post('/{service}/toggle',      [FavoriteController::class, 'toggle'])->name('toggle');
    });

});

/*
|─────────────────────────────────────────────────────────────────────────────
| 5. ESPACE ADMIN
|─────────────────────────────────────────────────────────────────────────────
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Vue d'ensemble
        Route::get('/dashboard',         [AdminController::class, 'dashboard'])->name('dashboard');

        // Notifications admin
        Route::get('/notifications',                [AdminController::class, 'adminNotifications'])->name('notifications');
        Route::post('/notifications/mark-all-read', [AdminController::class, 'markAllAdminNotificationsRead'])->name('notifications.markAllRead');

        // Gestion des utilisateurs & structures
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    //  categories
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories');

    Route::get('/categories/create', [CategoryController::class, 'create'])
        ->name('categories.create');

    Route::post('/categories/store', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit');

    Route::put('/categories/{id}', [CategoryController::class, 'update'])
        ->name('categories.update');

    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');

        Route::get('/clients',           [AdminController::class, 'clients'])->name('clients');
        Route::get('/contacts',          [AdminController::class, 'contacts'])->name('contacts');
        Route::get('/contacts/{contact}', [AdminController::class, 'showContact'])->name('contacts.show');
        Route::post('/contacts/{contact}/reply', [AdminController::class, 'replyContact'])->name('contacts.reply');
        Route::get('/salons',            [AdminController::class, 'salons'])->name('salons');
        Route::patch('/salons/{salon}/status', [AdminController::class, 'updateSalonStatus'])->name('salons.status');
        Route::get('/salons/create', [AdminController::class, 'createSalon'])->name('salons.create');
        Route::post('/salons', [AdminController::class, 'storeSalon'])->name('salons.store');

        // Services
        Route::get('/services',          [AdminController::class, 'services'])->name('services');
        Route::get('/services/create',   [AdminController::class, 'createService'])->name('services.create');
        Route::post('/services',         [AdminController::class, 'storeService'])->name('services.store');
        Route::get('/services/{service}', [AdminController::class, 'showService'])->name('services.show');
        Route::get('/services/{service}/edit', [AdminController::class, 'editService'])->name('services.edit');
        Route::patch('/services/{service}',  [AdminController::class, 'updateService'])->name('services.update');
        Route::delete('/services/{service}', [AdminController::class, 'destroyService'])->name('services.destroy');
        // LISTE DES SERVICES (INDEX)
        Route::get('/services', [AdminController::class, 'servicesIndex'])
            ->name('services.index');

        // UPDATE SERVICE
        Route::patch('/services/{service}', [AdminController::class, 'updateService'])
            ->name('services.update');

        //  Gestion des promotions
        Route::resource('promotions', PromotionController::class);
        
        // Categories
        // Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        // Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
        // Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        
        // salons
        Route::get('/salons/{id}/edit', [AdminController::class, 'editSalon'])
            ->name('salons.edit');

        Route::put('/salons/{id}', [AdminController::class, 'updateSalon'])
            ->name('salons.update');

        Route::delete('/salons/{id}', [AdminController::class, 'destroySalon'])
            ->name('salons.destroy');
            
        // Réservations
        Route::get('/reservations',                          [AdminController::class, 'reservations'])->name('reservations');
        Route::post('/reservations/{reservation}/confirm',   [AdminController::class, 'confirmReservation'])->name('reservations.confirm');
        Route::post('/reservations/{reservation}/cancel',    [AdminController::class, 'cancelReservation'])->name('reservations.cancel');

        // Finance & opérations
        Route::get('/payments',          [AdminController::class, 'payments'])->name('payments');
        Route::patch('/payments/{payment}/validate', [AdminController::class, 'validatePayment'])->name('payments.validate');
        Route::get('/rapports',          [AdminController::class, 'reports'])->name('rapports');
        Route::get('/inventaire',        [AdminController::class, 'inventory'])->name('inventaire');

        // Paramètres du salon
        Route::get('/activity-logs',     [AdminController::class, 'activityLogs'])->name('logs');
        Route::get('/calendar',          [AdminController::class, 'calendar'])->name('calendar');
        Route::get('/heures-ouverture',  [AdminController::class, 'openingHours'])->name('heuresOuverture');
        Route::put('/heures-ouverture',  [AdminController::class, 'updateOpeningHours'])->name('heuresOuverture.update');
        Route::get('/parametres',        [AdminController::class, 'settings'])->name('settings');
        Route::put('/personnalisation/logo', [AdminController::class, 'updateBranding'])->name('personnalisation.update');
        Route::put('/personnalisation/branding', [AdminController::class, 'updateBranding'])->name('personnalisation.branding');

        Route::put('/contact-settings', [AdminController::class, 'updateContactSettings'])->name('contact-settings.update');


    // Clients
        Route::get('/clients', [AdminController::class, 'clients'])
            ->name('clients');

        Route::get('/clients/{id}/edit', [AdminController::class, 'editClient'])
            ->name('clients.edit');

        Route::put('/clients/{id}', [AdminController::class, 'updateClient'])
            ->name('clients.update');

        Route::delete('/clients/{id}', [AdminController::class, 'destroyClient'])
            ->name('clients.destroy');

        Route::get('/clients/{id}/print', [AdminController::class, 'printClient'])
            ->name('clients.print');

            // adimin/Employee
        
        // 📌 LISTE
        Route::get('/employees', [EmployeeController::class, 'index'])
            ->name('employees.index');

        // 📌 CREATE
        Route::get('/employees/create', [EmployeeController::class, 'create'])
            ->name('employees.create');

        // 📌 STORE
        Route::post('/employees', [EmployeeController::class, 'store'])
            ->name('employees.store');

        // 📌 EDIT
        Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])
            ->name('employees.edit');

        // 📌 UPDATE
        Route::put('/employees/{id}', [EmployeeController::class, 'update'])
            ->name('employees.update');

        // 📌 DELETE
        Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])
            ->name('employees.destroy');

            Route::get('/reservations/show',        [ReservationController::class, 'show'])   ->name('reservations.show');
            Route::get('/reservations/edit',   [ReservationController::class, 'edit'])   ->name('reservations.edit');
            Route::put('/reservations/{reservation}',        [ReservationController::class, 'update']) ->name('reservations.update');
            Route::delete('/reservations/{reservation}',     [ReservationController::class, 'destroy'])->name('reservations.destroy');
});


/*
|─────────────────────────────────────────────────────────────────────────────
| 6. ESPACE EMPLOYÉ (Prestataire)
|─────────────────────────────────────────────────────────────────────────────
*/

Route::prefix('employee')
    ->name('employee.')
    ->middleware(['auth', 'role:employee'])
    ->group(function () {

        Route::get('/dashboard',   [EmployeeController::class, 'dashboard'])->name('dashboard');
        Route::get('/availability', [EmployeeController::class, 'availability'])->name('availability');
        Route::post('/availability', [EmployeeController::class, 'saveAvailability'])->name('availability.save');
        Route::post('/reservations/{reservation}/done', [EmployeeController::class, 'completeReservation'])->name('reservation.done');
        Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile');
        Route::put('/profile', [EmployeeController::class, 'updateProfile'])->name('profile.update');

        // Catalogue personnel
        Route::get('/salons',      [SalonController::class,   'mySalons'])->name('salons');

        // Catalogue du prestataire
        Route::get('/services',    [ServiceController::class, 'myServices'])->name('services');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services',       [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}',          [ServiceController::class, 'serviceBookings'])->name('services.show');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}',      [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}',   [ServiceController::class, 'destroy'])->name('services.destroy');

        // Réservations & planning
        Route::get('/reservations', [BookingController::class,  'employeeBookings'])->name('reservations');
        Route::get('/planning',     [PlanningController::class, 'index'])->name('planning');
        Route::get('/revenus',      [RevenuController::class,   'index'])->name('revenus');

    });

Route::prefix('prestataire')
    ->name('prestataire.')
    ->middleware(['auth', 'role:prestataire'])
    ->group(function () {

        Route::get('/dashboard',   [DashboardController::class, 'prestataire'])->name('dashboard');

        // Catalogue du prestataire
        Route::get('/services',    [ServiceController::class, 'myServices'])->name('services');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services',       [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}',          [ServiceController::class, 'serviceBookings'])->name('services.show');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}',      [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}',   [ServiceController::class, 'destroy'])->name('services.destroy');

        // Réservations & planning
        Route::get('/reservations', [BookingController::class, 'prestataireBookings'])->name('reservations');
        Route::get('/planning',     [PrestatairePlanningController::class, 'index'])->name('planning');
        Route::get('/revenus',      [PrestataireRevenuController::class, 'index'])->name('revenus');

    });

/*
|─────────────────────────────────────────────────────────────────────────────
| 7. ESPACE CLIENT
|─────────────────────────────────────────────────────────────────────────────
*/

Route::prefix('client')
    ->name('client.')
    ->middleware(['auth', 'role:client'])
    ->group(function () {

        Route::get('/dashboard',    [DashboardController::class,  'client'])->name('dashboard');
        Route::get('/reservations', [BookingController::class,    'myBookings'])->name('reservations');
        Route::get('/favorites',    [FavoriteController::class,   'index'])->name('favorites');

        // 🎁 Fidélité & VIP
        Route::get('/loyalty',      [LoyaltyController::class,    'index'])->name('loyalty');
        Route::post('/loyalty/redeem', [LoyaltyController::class, 'redeem'])->name('loyalty.redeem');
        
        // 👑 VIP
        Route::get('/vip/plans',    [VipController::class,        'plans'])->name('vip.plans');
        Route::post('/vip/subscribe', [VipController::class,      'subscribe'])->name('vip.subscribe');
        Route::post('/vip/cancel',  [VipController::class,        'cancel'])->name('vip.cancel');

        // ❌ Annulation
        Route::get('/cancellations', [CancellationController::class, 'myRequests'])->name('cancellations');
        Route::post('/reservations/{reservation}/cancel', [CancellationController::class, 'requestCancel'])->name('cancel-request');
        Route::post('/reservations/{reservation}/review', [ReservationController::class, 'review'])->name('reservations.review');

        // Liste d'attente
        Route::get('/waiting-list/create', [WaitingListController::class, 'create'])->name('waiting-list.create');
        Route::post('/waiting-list', [WaitingListController::class, 'store'])->name('waiting-list.store');

        // Nouvelles pages sidebar
        Route::get('/addresses',                       [DashboardController::class, 'addresses'])->name('addresses');
        Route::post('/addresses',                      [DashboardController::class, 'storeAddress'])->name('addresses.store');
        Route::put('/addresses/{address}',             [DashboardController::class, 'updateAddress'])->name('addresses.update');
        Route::delete('/addresses/{address}',          [DashboardController::class, 'deleteAddress'])->name('addresses.delete');
        Route::post('/addresses/{address}/set-primary',[DashboardController::class, 'setPrimaryAddress'])->name('addresses.setPrimary');

        Route::get('/payments',                     [DashboardController::class, 'clientPayments'])->name('payments');
        Route::get('/notifications',                [DashboardController::class, 'clientNotifications'])->name('notifications');
        Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllNotificationsRead'])->name('notifications.markAllRead');
        Route::post('/notifications/preferences',   [DashboardController::class, 'updateNotificationPreferences'])->name('notifications.preferences');

    });

/*
|─────────────────────────────────────────────────────────────────────────────
| ESPACE CLIENT SUPPLÉMENTAIRE
|─────────────────────────────────────────────────────────────────────────────
*/

// Promotions publiques
Route::get('/promotions',       [PromotionController::class, 'index'])->name('promotions.index');
Route::post('/promotions/validate', [PromotionController::class, 'validateCode'])->name('promotions.validate');

Route::get('/lang/{locale}', function ($locale) {
    $available = ['en', 'fr', 'es'];
    if (! in_array($locale, $available)) {
        abort(404);
    }

    session()->put('locale', $locale);
    session()->save();

    $back = url()->previous();
    if (empty($back) || str_contains($back, '/lang/')) {
        $back = route('home');
    }

    return redirect()->to($back);
})->name('locale.switch');

// Politiques d'annulation
Route::get('/cancellation-policies', [CancellationController::class, 'policies'])->name('cancellation-policies');

/*
|─────────────────────────────────────────────────────────────────────────────
| ESPACE ADMIN - NOUVELLES ROUTES
|─────────────────────────────────────────────────────────────────────────────
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // 🎁 Gestion Fidélité
        Route::get('/loyalty',              [LoyaltyController::class, 'adminIndex'])->name('loyalty.index');
        Route::post('/loyalty/{user}/bonus', [LoyaltyController::class, 'adminAddBonus'])->name('loyalty.bonus');

        // 👑 Gestion VIP
        Route::get('/vip',                   [VipController::class, 'adminIndex'])->name('vip.index');
        Route::post('/vip/{subscription}/cancel', [VipController::class, 'adminCancel'])->name('vip.cancel');

        // 🎟️ Gestion Promotions
        Route::get('/promotions',           [PromotionController::class, 'adminIndex'])->name('promotions.index');
        Route::post('/promotions',          [PromotionController::class, 'store'])->name('promotions.store');
        Route::put('/promotions/{promotion}', [PromotionController::class, 'update'])->name('promotions.update');
        Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('promotions.destroy');

        // ❌ Gestion Annulations
        Route::get('/cancellations',        [CancellationController::class, 'adminIndex'])->name('cancellations.index');
        Route::post('/cancellations/{cancellation}/approve', [CancellationController::class, 'approve'])->name('cancellations.approve');
        Route::post('/cancellations/{cancellation}/reject', [CancellationController::class, 'reject'])->name('cancellations.reject');
        Route::get('/cancellation-policies', [CancellationController::class, 'managePolicies'])->name('cancellation-policies.manage');
        Route::post('/cancellation-policies', [CancellationController::class, 'storePolicy'])->name('cancellation-policies.store');
        Route::put('/cancellation-policies/{policy}', [CancellationController::class, 'updatePolicy'])->name('cancellation-policies.update');

    });

/*
|─────────────────────────────────────────────────────────────────────────────
| 8. PROFIL UTILISATEUR
|─────────────────────────────────────────────────────────────────────────────
*/

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {

    Route::get('/',         [ProfileController::class, 'show'])->name('show');
    Route::put('/update',   [ProfileController::class, 'update'])->name('update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');

});

/*
|─────────────────────────────────────────────────────────────────────────────
| 9. PAGES LÉGALES
|─────────────────────────────────────────────────────────────────────────────
*/

Route::prefix('legal')->name('legal.')->group(function () {

    Route::get('/mentions', [LegalController::class, 'mentions'])->name('mentions');
    Route::get('/privacy',  [LegalController::class, 'privacy'])->name('privacy');
    Route::get('/cgu',      [LegalController::class, 'cgu'])->name('cgu');
    Route::get('/cookies',  [LegalController::class, 'cookies'])->name('cookies');
    Route::get('/policies', [LegalController::class, 'policies'])->name('policies');

});

Route::get('/faq', [LegalController::class, 'faq'])->name('faq');

 Route::get('/salons/{salon}', [SalonController::class, 'show'])->name('salons.show');


 // 🖨️ impression
    Route::get('/users-print', [UserController::class, 'print'])->name('users.print');

});

    