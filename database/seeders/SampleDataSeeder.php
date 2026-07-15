<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Salon;
use App\Models\User;
use App\Models\Availability;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create owner user
        $owner = User::firstOrCreate([
            'email' => 'owner@marolhair.com'
        ], [
            'name' => 'Propriétaire Marol',
            'password' => bcrypt('password'),
            'phone' => '+221 33 123 45 67',
        ]);

        // Create salon
        $salon = Salon::firstOrCreate([
            'name' => 'Marol Hair Brainding'
        ], [
            'owner_id' => $owner->id,
            'address' => '123 Avenue des Coiffures, Dakar',
            'city' => 'Dakar',
            'phone' => '+221 33 123 45 67',
            'email' => 'contact@marolhair.com',
            'description' => 'Salon de coiffure premium spécialisé dans les tresses africaines',
            'is_active' => true
        ]);

        // Create categories
        $categories = [
            ['nom' => 'Tresses', 'description' => 'Tresses africaines traditionnelles'],
            ['nom' => 'Beauté', 'description' => 'Soins de beauté et esthétiques'],
            ['nom' => 'Couleur', 'description' => 'Coloration et décoloration'],
            ['nom' => 'Soins', 'description' => 'Soins capillaires et traitements'],
        ];

        foreach ($categories as $cat) {
            Categorie::firstOrCreate(['nom' => $cat['nom']], $cat);
        }

        // Create services
        $services = [
            [
                'name' => 'Tresses Traditionnelles',
                'description' => 'Tresses africaines réalisées avec soin par nos expertes',
                'price' => 25000,
                'duration' => 180,
                'emoji' => '✨',
                'categorie_id' => 1
            ],
            [
                'name' => 'Tresses Sans Nœuds',
                'description' => 'Technique moderne pour un confort absolu',
                'price' => 35000,
                'duration' => 240,
                'emoji' => '💫',
                'categorie_id' => 1
            ],
            [
                'name' => 'Tresses Jumbo',
                'description' => 'Tresses épaisses pour un look audacieux',
                'price' => 30000,
                'duration' => 210,
                'emoji' => '🌟',
                'categorie_id' => 1
            ],
            [
                'name' => 'Soins Capillaires',
                'description' => 'Traitement complet pour cheveux abîmés',
                'price' => 15000,
                'duration' => 90,
                'emoji' => '💆‍♀️',
                'categorie_id' => 4
            ],
            [
                'name' => 'Coloration Cheveux',
                'description' => 'Coloration professionnelle de qualité',
                'price' => 20000,
                'duration' => 120,
                'emoji' => '🎨',
                'categorie_id' => 3
            ],
        ];

        foreach ($services as $serviceData) {
            Service::firstOrCreate(
                ['name' => $serviceData['name']],
                array_merge($serviceData, ['salon_id' => $salon->id, 'is_active' => true])
            );
        }

        // Create employees
        $employees = [
            [
                'user_name' => 'Fatou Diop',
                'user_email' => 'fatou@marolhair.com',
                'specialty' => 'Tresses Traditionnelles',
                'experience_years' => 8,
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=200',
                'bio' => 'Spécialiste des tresses africaines avec 8 ans d\'expérience'
            ],
            [
                'user_name' => 'Aminata Sow',
                'user_email' => 'aminata@marolhair.com',
                'specialty' => 'Tresses Modernes',
                'experience_years' => 6,
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1594824804732-ca8db723f8fa?q=80&w=200',
                'bio' => 'Experte en techniques modernes de tressage'
            ],
            [
                'user_name' => 'Marie Ndiaye',
                'user_email' => 'marie@marolhair.com',
                'specialty' => 'Soins Capillaires',
                'experience_years' => 10,
                'rating' => 5.0,
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200',
                'bio' => 'Spécialiste des soins et traitements capillaires'
            ],
        ];

        foreach ($employees as $emp) {
            $user = User::firstOrCreate([
                'email' => $emp['user_email']
            ], [
                'name' => $emp['user_name'],
                'password' => bcrypt('password'),
                'phone' => '+221 33 123 45 67',
            ]);

            Employee::firstOrCreate([
                'user_id' => $user->id,
                'salon_id' => $salon->id
            ], [
                'specialty' => $emp['specialty'],
                'bio' => $emp['bio'],
                'photo' => $emp['image'],
                'is_available' => true,
                'working_days' => ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi']
            ]);
        }

        // Create default availabilities for all employees
        $employees = Employee::where('salon_id', $salon->id)->get();
        $workingDays = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

        foreach ($employees as $employee) {
            foreach ($workingDays as $day) {
                Availability::firstOrCreate([
                    'employee_id' => $employee->id,
                    'day_of_week' => $day
                ], [
                    'start_time' => '09:00:00',
                    'end_time' => '18:00:00',
                    'slot_duration' => 60,
                    'is_active' => true
                ]);
            }
        }

        // Assign services to employees
        $allServices = Service::where('salon_id', $salon->id)->get();
        foreach ($employees as $employee) {
            $employee->services()->attach($allServices->pluck('id')->toArray());
        }
    }
}
