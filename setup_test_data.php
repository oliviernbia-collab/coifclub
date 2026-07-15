<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('role', 'admin')->first();
if(!$user) {
    $user = App\Models\User::create([
        'name' => 'Admin Salon',
        'email' => 'admin@coifclub.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
    echo 'Utilisateur admin créé' . PHP_EOL;
}

$salon = App\Models\Salon::create([
    'owner_id' => $user->id,
    'name' => 'Salon Principal',
    'description' => 'Salon de coiffure professionnel',
    'address' => '123 Rue de la Coiffure',
    'city' => 'Paris',
    'phone' => '0123456789',
    'email' => 'contact@coifclub.com',
    'is_active' => true
]);
echo 'Salon créé avec ID: ' . $salon->id . PHP_EOL;

$services = [
    ['name' => 'Coupe femme', 'description' => 'Coupe stylisée pour femme', 'price' => 15000, 'duration' => 60, 'category' => 'Coupe'],
    ['name' => 'Coupe homme', 'description' => 'Coupe moderne pour homme', 'price' => 10000, 'duration' => 45, 'category' => 'Coupe'],
    ['name' => 'Coloration', 'description' => 'Coloration professionnelle', 'price' => 25000, 'duration' => 120, 'category' => 'Coloration']
];

foreach($services as $serviceData) {
    App\Models\Service::create(array_merge($serviceData, [
        'is_active' => true,
        'salon_id' => $salon->id
    ]));
}
echo 'Services créés' . PHP_EOL;

// Créer un employé
$employeeUser = App\Models\User::where('email', 'marie@coifclub.com')->first();
if(!$employeeUser) {
    $employeeUser = App\Models\User::create([
        'name' => 'Marie Dupont',
        'email' => 'marie@coifclub.com',
        'password' => bcrypt('password'),
        'role' => 'employee'
    ]);
    echo 'Utilisateur employé créé' . PHP_EOL;
} else {
    echo 'Utilisateur employé existe déjà' . PHP_EOL;
}

$employee = App\Models\Employee::where('user_id', $employeeUser->id)->first();
if(!$employee) {
    $employee = App\Models\Employee::create([
        'user_id' => $employeeUser->id,
        'salon_id' => $salon->id,
        'specialty' => 'Coupe, Coloration',
        'bio' => 'Coiffeuse professionnelle avec 5 ans d\'expérience',
        'is_available' => true
    ]);
    echo 'Employé créé' . PHP_EOL;
} else {
    echo 'Employé existe déjà' . PHP_EOL;
}

// Créer des disponibilités pour l'employé
$days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
foreach($days as $day) {
    App\Models\Availability::create([
        'employee_id' => $employee->id,
        'day_of_week' => $day,
        'start_time' => '09:00:00',
        'end_time' => '18:00:00',
        'is_active' => true
    ]);
}
echo 'Disponibilités créées' . PHP_EOL;

// Lier l'employé aux services
$serviceIds = App\Models\Service::where('salon_id', $salon->id)->pluck('id')->toArray();
$employee->services()->attach($serviceIds);
echo 'Services liés à l\'employé' . PHP_EOL;

echo 'Données de test créées avec succès !' . PHP_EOL;