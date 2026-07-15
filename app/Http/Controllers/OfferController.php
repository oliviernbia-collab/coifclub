<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = [
            [
                'title' => 'Promo Tresses Africaines',
                'discount' => '-20%',
                'description' => 'Profitez de nos magnifiques tresses africaines à prix réduit.',
                'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e'
            ],
            [
                'title' => 'Soin Kératine Premium',
                'discount' => '-15%',
                'description' => 'Hydratez et réparez vos cheveux avec notre soin kératine.',
                'image' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f'
            ],
            [
                'title' => 'Pack Mariage',
                'discount' => '-30%',
                'description' => 'Coiffure + maquillage + soin pour votre grand jour.',
                'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552'
            ],
        ];

        return view('offers.index', compact('offers'));
    }
}