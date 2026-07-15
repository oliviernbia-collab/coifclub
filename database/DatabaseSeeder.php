<?php

namespace Database\Seeders;

use App\Models\{User, Salon, Service, Employee, Availability, Reservation, Payment};
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Admin / Propriétaire ────────────────────
        $admin = User::create([
            'name'     => 'Nadia Coulibaly',
            'email'    => 'admin@glamsalon.ci',
            'phone'    => '+225 07 00 00 01',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // ── 2. Salon ────────────────────────────────
        $salon = Salon::create([
            'owner_id'      => $admin->id,
            'name'          => 'GlamSalon Abidjan',
            'description'   => 'Votre salon de coiffure premium au cœur d\'Abidjan.',
            'address'       => 'Cocody Angré, 7ème tranche',
            'city'          => 'Abidjan',
            'phone'         => '+225 07 00 00 00',
            'email'         => 'contact@glamsalon.ci',
            'opening_hours' => [
                'lundi'    => '08:00-18:00',
                'mardi'    => '08:00-18:00',
                'mercredi' => '08:00-18:00',
                'jeudi'    => '08:00-18:00',
                'vendredi' => '08:00-18:00',
                'samedi'   => '09:00-16:00',
            ],
        ]);

        // ── 3. Prestations ─────────────────────────
        $services = [
            ['name'=>'Tresse classique',  'cat'=>'Tresses',    'price'=>15000,'dur'=>120,'emoji'=>'💆‍♀️','desc'=>'Tresses africaines traditionnelles, soignées et durables.'],
            ['name'=>'Tresse cornrows',   'cat'=>'Tresses',    'price'=>18000,'dur'=>150,'emoji'=>'✨','desc'=>'Cornrows plats avec motifs personnalisés.'],
            ['name'=>'Pose perruque',     'cat'=>'Perruques',  'price'=>20000,'dur'=>90,'emoji'=>'👑','desc'=>'Pose et coiffage de perruque HD ou lace front.'],
            ['name'=>'Coupe & brushing',  'cat'=>'Soins',      'price'=>8000,'dur'=>60,'emoji'=>'✂️','desc'=>'Coupe personnalisée et brushing brillant.'],
            ['name'=>'Manucure complète', 'cat'=>'Beauté',     'price'=>5000,'dur'=>45,'emoji'=>'💅','desc'=>'Manucure complète avec vernis au choix.'],
            ['name'=>'Soin kératine',     'cat'=>'Soins',      'price'=>35000,'dur'=>180,'emoji'=>'💎','desc'=>'Lissage protéiné longue durée.'],
            ['name'=>'Coloration',        'cat'=>'Couleur',    'price'=>25000,'dur'=>120,'emoji'=>'🎨','desc'=>'Coloration complète avec soins capillaires.'],
            ['name'=>'Extensions',        'cat'=>'Extensions', 'price'=>40000,'dur'=>240,'emoji'=>'🌟','desc'=>'Pose d\'extensions naturelles ou synthétiques.'],
        ];

        $serviceModels = [];
        foreach ($services as $i => $s) {
            $serviceModels[] = Service::create([
                'salon_id'    => $salon->id,
                'name'        => $s['name'],
                'category'    => $s['cat'],
                'price'       => $s['price'],
                'duration'    => $s['dur'],
                'emoji'       => $s['emoji'],
                'description' => $s['desc'],
                'sort_order'  => $i,
            ]);
        }

        // ── 4. Employées ─────────────────────────────
        $employeeData = [
            ['name'=>'Aminata Koné',     'email'=>'aminata@glamsalon.ci',    'specialty'=>'Tresses & Extensions'],
            ['name'=>'Fatoumata Diallo', 'email'=>'fatoumata@glamsalon.ci',  'specialty'=>'Couleur & Soins'],
            ['name'=>'Mariama Touré',    'email'=>'mariama@glamsalon.ci',    'specialty'=>'Coupe & Brushing'],
        ];

        $employeeModels = [];
        foreach ($employeeData as $ed) {
            $user = User::create([
                'name'     => $ed['name'],
                'email'    => $ed['email'],
                'phone'    => '+225 07 00 00 0' . count($employeeModels),
                'password' => bcrypt('password'),
                'role'     => 'employee',
            ]);
            $emp = Employee::create([
                'user_id'   => $user->id,
                'salon_id'  => $salon->id,
                'specialty' => $ed['specialty'],
            ]);
            $emp->services()->attach(collect($serviceModels)->take(4)->pluck('id'));

            // Disponibilités
            $days = [
                ['lundi','08:00','18:00'],
                ['mardi','09:00','17:00'],
                ['mercredi','08:00','18:00'],
                ['jeudi','09:00','17:00'],
                ['vendredi','08:00','16:00'],
            ];
            foreach ($days as [$day,$start,$end]) {
                Availability::create([
                    'employee_id'   => $emp->id,
                    'day_of_week'   => $day,
                    'start_time'    => $start,
                    'end_time'      => $end,
                    'slot_duration' => 30,
                ]);
            }
            $employeeModels[] = $emp;
        }

        // ── 5. Clientes ─────────────────────────────
        $clients = [
            ['name'=>'Marie-Claire Konan', 'email'=>'client@glamsalon.ci'],
            ['name'=>'Chantal Osei',       'email'=>'chantal@example.com'],
            ['name'=>'Binta Sawadogo',     'email'=>'binta@example.com'],
            ['name'=>'Yvette Kouamé',      'email'=>'yvette@example.com'],
        ];

        $clientModels = [];
        foreach ($clients as $c) {
            $clientModels[] = User::create([
                'name'     => $c['name'],
                'email'    => $c['email'],
                'phone'    => '+225 07 00 00 0' . count($clientModels),
                'password' => bcrypt('password'),
                'role'     => 'client',
            ]);
        }

        // ── 6. Réservations exemples ─────────────────
        $statuses = ['pending','confirmed','done','cancelled'];
        $methods  = ['orange_money','mtn_money','wave','stripe'];

        for ($i = 0; $i < 12; $i++) {
            $service  = $serviceModels[array_rand($serviceModels)];
            $employee = $employeeModels[array_rand($employeeModels)];
            $client   = $clientModels[array_rand($clientModels)];
            $date     = Carbon::now()->subDays(rand(0, 14));
            $status   = $statuses[array_rand($statuses)];
            $method   = $methods[array_rand($methods)];

            $reservation = Reservation::create([
                'client_id'   => $client->id,
                'service_id'  => $service->id,
                'employee_id' => $employee->id,
                'salon_id'    => $salon->id,
                'date'        => $date->toDateString(),
                'start_time'  => '09:00',
                'end_time'    => Carbon::parse('09:00')->addMinutes($service->duration)->format('H:i'),
                'amount'      => $service->price,
                'status'      => $status,
                'confirmed_at'=> $status !== 'pending' ? now() : null,
            ]);

            Payment::create([
                'reservation_id' => $reservation->id,
                'client_id'      => $client->id,
                'amount'         => $service->price,
                'method'         => $method,
                'status'         => $status === 'done' ? 'completed' : ($status === 'cancelled' ? 'failed' : 'pending'),
                'paid_at'        => $status === 'done' ? now() : null,
            ]);
        }

        $this->call(ProductSeeder::class);

        $this->command->info('✅ Base de données peuplée avec succès !');
        $this->command->table(
            ['Rôle', 'Email', 'Mot de passe'],
            [
                ['Admin',    'admin@glamsalon.ci',     'password'],
                ['Employée', 'aminata@glamsalon.ci',   'password'],
                ['Cliente',  'client@glamsalon.ci',    'password'],
            ]
        );
    }
}
