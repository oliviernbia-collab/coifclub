<?php

namespace Database\Seeders;

use App\Models\CancellationPolicy;
use Illuminate\Database\Seeder;

class CancellationPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $policies = [
            [
                'name' => '48h+',
                'hours_before' => 48,
                'refund_percentage' => 100,
                'description' => 'Annulation 48h+ avant le rendez-vous : remboursement 100%',
                'is_default' => true,
            ],
            [
                'name' => '24h-48h',
                'hours_before' => 24,
                'refund_percentage' => 70,
                'description' => 'Annulation 24h-48h avant : remboursement 70%',
                'is_default' => false,
            ],
            [
                'name' => 'Moins de 24h',
                'hours_before' => 0,
                'refund_percentage' => 0,
                'description' => 'Annulation moins de 24h ou absence : pas de remboursement',
                'is_default' => false,
            ],
        ];

        foreach ($policies as $policy) {
            CancellationPolicy::create($policy);
        }
    }
}
