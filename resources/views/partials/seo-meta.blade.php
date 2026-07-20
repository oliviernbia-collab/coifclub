{{-- SEO: description, canonical, Open Graph, Twitter Card --}}
<meta name="description" content="@yield('meta_description', __('messages.seo_default_description'))">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="icon" href="{{ asset('favicon.ico') }}">

<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:site_name" content="{{ __('messages.brand_name') }}">
<meta property="og:title" content="@yield('title', __('messages.site_title'))">
<meta property="og:description" content="@yield('meta_description', __('messages.seo_default_description'))">
<meta property="og:image" content="@yield('og_image', asset('images/C34.jpg'))">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:locale" content="{{ app()->getLocale() }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', __('messages.site_title'))">
<meta name="twitter:description" content="@yield('meta_description', __('messages.seo_default_description'))">
<meta name="twitter:image" content="@yield('og_image', asset('images/C34.jpg'))">

{{-- Structured data: local business (drives Google Maps / local-pack visibility) --}}
@php($seoSalon = \App\Models\Salon::first())
@if($seoSalon)
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'HairSalon',
    'name' => $seoSalon->name,
    'image' => asset('images/C34.jpg'),
    'telephone' => $seoSalon->phone,
    'email' => $seoSalon->email,
    'url' => url('/'),
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $seoSalon->address,
        'addressLocality' => $seoSalon->city,
        'addressRegion' => 'IL',
        'addressCountry' => 'US',
    ],
    'openingHoursSpecification' => [[
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
        'opens' => '09:00',
        'closes' => '20:00',
    ]],
    'priceRange' => '$$',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
</script>
@endif
