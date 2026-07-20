<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /employee',
            'Disallow: /prestataire',
            'Disallow: /client',
            'Disallow: /booking',
            'Disallow: /favorites',
            'Disallow: /payment',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /forgot-password',
            'Disallow: /reset-password',
            'Disallow: /logout',
            '',
            'Sitemap: ' . url('/sitemap.xml'),
        ];

        return response(implode("\n", $lines), 200)
            ->header('Content-Type', 'text/plain');
    }

    public function sitemap(): Response
    {
        $staticUrls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('services.index'), 'priority' => '0.9'],
            ['loc' => route('salons.index'), 'priority' => '0.6'],
            ['loc' => route('gallery'), 'priority' => '0.6'],
            ['loc' => route('contact'), 'priority' => '0.8'],
            ['loc' => route('stylists.index'), 'priority' => '0.7'],
            ['loc' => route('offers.index'), 'priority' => '0.6'],
            ['loc' => route('about'), 'priority' => '0.7'],
            ['loc' => route('blog.index'), 'priority' => '0.5'],
            ['loc' => route('promotions.index'), 'priority' => '0.5'],
            ['loc' => route('faq'), 'priority' => '0.4'],
            ['loc' => route('cancellation-policies'), 'priority' => '0.3'],
            ['loc' => route('legal.mentions'), 'priority' => '0.2'],
            ['loc' => route('legal.privacy'), 'priority' => '0.2'],
            ['loc' => route('legal.cgu'), 'priority' => '0.2'],
            ['loc' => route('legal.cookies'), 'priority' => '0.2'],
        ];

        $services = Service::where('is_active', true)->get()->map(fn ($service) => [
            'loc' => route('services.show', $service),
            'lastmod' => optional($service->updated_at)->toAtomString(),
            'priority' => '0.7',
        ]);

        $stylists = Employee::where('is_available', true)->get()->map(fn ($employee) => [
            'loc' => route('stylists.show', $employee->id),
            'lastmod' => optional($employee->updated_at)->toAtomString(),
            'priority' => '0.6',
        ]);

        $urls = collect($staticUrls)->concat($services)->concat($stylists);

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
