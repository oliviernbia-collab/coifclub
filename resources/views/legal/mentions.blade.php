@extends('layouts.home')

@section('title', app()->getLocale() === 'fr' ? 'Mentions légales' : (app()->getLocale() === 'es' ? 'Avisos legales' : 'Legal Notice'))

@section('content')

<style>
body { background: #0e0a1c; color: rgba(255,255,255,.85); }
.legal-wrap { max-width: 800px; margin: 0 auto; padding: 4rem 1.5rem; }
.legal-wrap h1 { font-size: 2rem; font-weight: 800; color: rgba(255,255,255,.9); margin-bottom: 1.5rem; font-family: 'Playfair Display', serif; }
.legal-wrap h2 { font-size: 1.2rem; font-weight: 700; color: #ff6ab4; margin: 2rem 0 .75rem; }
.legal-wrap p, .legal-wrap li { color: rgba(255,255,255,.6); line-height: 1.8; margin-bottom: .5rem; }
.legal-wrap ul { padding-left: 1.5rem; }
</style>

<div class="legal-wrap">
    <h1>
        {{ app()->getLocale() === 'fr' ? 'Mentions légales' : (app()->getLocale() === 'es' ? 'Avisos legales' : 'Legal Notice') }}
    </h1>

    <h2>{{ app()->getLocale() === 'fr' ? 'Éditeur du site' : (app()->getLocale() === 'es' ? 'Editor del sitio' : 'Site publisher') }}</h2>
    <p>{{ app()->getLocale() === 'fr' ? 'Le site Marol Hair Braiding est édité par Marol Hair Braiding, salon de coiffure professionnel.' : (app()->getLocale() === 'es' ? 'El sitio Marol Hair Braiding es editado por Marol Hair Braiding, salón de peluquería profesional.' : 'The Marol Hair Braiding website is published by Marol Hair Braiding, a professional hair braiding salon.') }}</p>

    <h2>{{ app()->getLocale() === 'fr' ? 'Hébergement' : (app()->getLocale() === 'es' ? 'Alojamiento' : 'Hosting') }}</h2>
    <p>{{ app()->getLocale() === 'fr' ? 'Le site est hébergé par un prestataire tiers. Pour toute demande relative à l\'hébergement, veuillez nous contacter.' : (app()->getLocale() === 'es' ? 'El sitio está alojado por un proveedor externo. Para cualquier consulta relacionada con el alojamiento, póngase en contacto con nosotros.' : 'The site is hosted by a third-party provider. For any hosting-related requests, please contact us.') }}</p>

    <h2>{{ app()->getLocale() === 'fr' ? 'Propriété intellectuelle' : (app()->getLocale() === 'es' ? 'Propiedad intelectual' : 'Intellectual property') }}</h2>
    <p>{{ app()->getLocale() === 'fr' ? 'L\'ensemble du contenu de ce site (textes, images, graphismes, logo) est protégé par le droit d\'auteur. Toute reproduction est interdite sans autorisation préalable.' : (app()->getLocale() === 'es' ? 'Todos los contenidos de este sitio (textos, imágenes, gráficos, logotipo) están protegidos por los derechos de autor. Se prohíbe cualquier reproducción sin autorización previa.' : 'All content on this site (text, images, graphics, logo) is protected by copyright. Any reproduction is prohibited without prior authorisation.') }}</p>

    <h2>{{ app()->getLocale() === 'fr' ? 'Contact' : (app()->getLocale() === 'es' ? 'Contacto' : 'Contact') }}</h2>
    <p>{{ app()->getLocale() === 'fr' ? 'Pour toute question, vous pouvez nous contacter via la page de contact de notre site.' : (app()->getLocale() === 'es' ? 'Para cualquier pregunta, puede contactarnos a través de la página de contacto de nuestro sitio.' : 'For any questions, you can reach us through the contact page on our website.') }}</p>
</div>

@endsection
