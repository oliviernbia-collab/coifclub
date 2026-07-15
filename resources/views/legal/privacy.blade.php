@extends('layouts.home')

@section('title', 'Privacy Policy — Marol Hair Braiding')

@push('styles')
<style>
:root { --pink: #e83e8c; --pink-dark: #c91a78; }

.legal-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    padding: 80px 0 52px; text-align: center;
    position: relative; overflow: hidden;
}
.legal-hero::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 50% at 50% 0%, rgba(232,62,140,.12), transparent);
}
.legal-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(232,62,140,.1); border: 1px solid rgba(232,62,140,.2);
    color: #ff6ab4; font-size: .72rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    padding: 5px 14px; border-radius: 50px; margin-bottom: 16px;
    font-family: 'Inter', sans-serif;
}
.legal-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 900; color: #fff; margin-bottom: 10px;
}
.legal-hero h1 span { color: var(--pink); }
.legal-meta {
    color: rgba(255,255,255,.3); font-size: .82rem; font-family: 'Inter', sans-serif;
}

.legal-body { background: #0f0e2a; padding: 64px 0 100px; }
.legal-container { max-width: 780px; margin: 0 auto; padding: 0 24px; }

/* Table of contents */
.legal-toc {
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07);
    border-radius: 18px; padding: 24px 28px; margin-bottom: 48px;
}
.legal-toc-title {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .1em; color: var(--pink); margin-bottom: 14px;
    font-family: 'Inter', sans-serif;
}
.legal-toc ol {
    margin: 0; padding-left: 18px;
    display: flex; flex-direction: column; gap: 7px;
}
.legal-toc a {
    color: rgba(255,255,255,.45); font-size: .88rem;
    font-family: 'Inter', sans-serif; text-decoration: none; transition: color .18s;
}
.legal-toc a:hover { color: #ff6ab4; }

/* Sections */
.legal-section { margin-bottom: 44px; scroll-margin-top: 80px; }
.legal-section h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem; font-weight: 800; color: #fff;
    margin-bottom: 14px; padding-bottom: 10px;
    border-bottom: 1px solid rgba(232,62,140,.15);
    display: flex; align-items: center; gap: 10px;
}
.legal-section h2 i { color: var(--pink); font-size: 1rem; }
.legal-section p, .legal-section li {
    color: rgba(255,255,255,.5); font-size: .9rem; line-height: 1.85;
    font-family: 'Inter', sans-serif;
}
.legal-section ul { padding-left: 20px; margin: 10px 0; }
.legal-section ul li { margin-bottom: 6px; }
.legal-section a { color: #ff6ab4; text-decoration: underline; }
.legal-highlight {
    background: rgba(232,62,140,.07); border-left: 3px solid var(--pink);
    border-radius: 0 10px 10px 0; padding: 14px 18px; margin: 16px 0;
    color: rgba(255,255,255,.55); font-size: .88rem;
    font-family: 'Inter', sans-serif; line-height: 1.7;
}
.legal-contact-card {
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08);
    border-radius: 16px; padding: 22px 24px; margin-top: 16px;
}
.legal-contact-card p { margin: 4px 0; }
.legal-contact-card strong { color: rgba(255,255,255,.8); }

@media(max-width:600px) {
    .legal-hero { padding: 56px 0 40px; }
    .legal-body  { padding: 40px 0 64px; }
}
</style>
@endpush

@section('content')
<section class="legal-hero">
    <div class="container" style="position:relative;z-index:1;">
        <div class="legal-eyebrow"><i class="fa-solid fa-shield-halved"></i>
            {{ app()->getLocale() === 'fr' ? 'Juridique' : (app()->getLocale() === 'es' ? 'Legal' : 'Legal') }}
        </div>
        <h1>
            {{ app()->getLocale() === 'fr' ? 'Politique de' : (app()->getLocale() === 'es' ? 'Política de' : 'Privacy') }}
            <span>{{ app()->getLocale() === 'fr' ? 'Confidentialité' : (app()->getLocale() === 'es' ? 'Privacidad' : 'Policy') }}</span>
        </h1>
        <p class="legal-meta">
            {{ app()->getLocale() === 'fr' ? 'Dernière mise à jour : ' : (app()->getLocale() === 'es' ? 'Última actualización: ' : 'Last updated: ') }}
            {{ date('F j, Y') }}
        </p>
    </div>
</section>

<section class="legal-body">
    <div class="legal-container">

        {{-- Table of contents --}}
        <div class="legal-toc">
            <div class="legal-toc-title">
                <i class="fa-solid fa-list me-1"></i>
                {{ app()->getLocale() === 'fr' ? 'Sommaire' : (app()->getLocale() === 'es' ? 'Índice' : 'Table of Contents') }}
            </div>
            <ol>
                <li><a href="#s1">{{ app()->getLocale() === 'fr' ? 'Informations collectées' : (app()->getLocale() === 'es' ? 'Información recopilada' : 'Information We Collect') }}</a></li>
                <li><a href="#s2">{{ app()->getLocale() === 'fr' ? 'Utilisation des données' : (app()->getLocale() === 'es' ? 'Uso de los datos' : 'How We Use Your Data') }}</a></li>
                <li><a href="#s3">{{ app()->getLocale() === 'fr' ? 'Partage des informations' : (app()->getLocale() === 'es' ? 'Compartir información' : 'Sharing of Information') }}</a></li>
                <li><a href="#s4">{{ app()->getLocale() === 'fr' ? 'Cookies' : (app()->getLocale() === 'es' ? 'Cookies' : 'Cookies') }}</a></li>
                <li><a href="#s5">{{ app()->getLocale() === 'fr' ? 'Conservation des données' : (app()->getLocale() === 'es' ? 'Retención de datos' : 'Data Retention') }}</a></li>
                <li><a href="#s6">{{ app()->getLocale() === 'fr' ? 'Vos droits' : (app()->getLocale() === 'es' ? 'Sus derechos' : 'Your Rights') }}</a></li>
                <li><a href="#s7">{{ app()->getLocale() === 'fr' ? 'Sécurité' : (app()->getLocale() === 'es' ? 'Seguridad' : 'Security') }}</a></li>
                <li><a href="#s8">{{ app()->getLocale() === 'fr' ? 'Contact' : (app()->getLocale() === 'es' ? 'Contacto' : 'Contact') }}</a></li>
            </ol>
        </div>

        <div class="legal-section" id="s1">
            <h2><i class="fa-solid fa-database"></i>
                {{ app()->getLocale() === 'fr' ? '1. Informations collectées' : (app()->getLocale() === 'es' ? '1. Información recopilada' : '1. Information We Collect') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'Lors de l\'utilisation de nos services, nous collectons les types d\'informations suivants :' : (app()->getLocale() === 'es' ? 'Al usar nuestros servicios, recopilamos los siguientes tipos de información:' : 'When using our services, we collect the following types of information:') }}</p>
            <ul>
                <li>{{ app()->getLocale() === 'fr' ? 'Informations d\'identification : nom, prénom, adresse email, numéro de téléphone.' : (app()->getLocale() === 'es' ? 'Información de identificación: nombre, apellido, correo electrónico, número de teléfono.' : 'Identification information: first name, last name, email address, phone number.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Données de réservation : date, heure, service choisi, coiffeuse sélectionnée, notes de style.' : (app()->getLocale() === 'es' ? 'Datos de reserva: fecha, hora, servicio elegido, estilista seleccionada, notas de estilo.' : 'Booking data: date, time, chosen service, selected stylist, style notes.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Données de paiement : ces données sont traitées par nos prestataires de paiement sécurisés et ne sont pas stockées sur nos serveurs.' : (app()->getLocale() === 'es' ? 'Datos de pago: procesados por nuestros proveedores de pago seguros, no almacenados en nuestros servidores.' : 'Payment data: processed by our secure payment providers and not stored on our servers.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Données de navigation : adresse IP, type de navigateur, pages visitées (via cookies analytiques).' : (app()->getLocale() === 'es' ? 'Datos de navegación: dirección IP, tipo de navegador, páginas visitadas (mediante cookies analíticas).' : 'Browsing data: IP address, browser type, pages visited (via analytics cookies).') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Données d\'abonnement : adresse email si vous vous abonnez à notre newsletter.' : (app()->getLocale() === 'es' ? 'Datos de suscripción: correo electrónico si se suscribe a nuestro boletín.' : 'Subscription data: email address if you subscribe to our newsletter.') }}</li>
            </ul>
        </div>

        <div class="legal-section" id="s2">
            <h2><i class="fa-solid fa-gears"></i>
                {{ app()->getLocale() === 'fr' ? '2. Utilisation des données' : (app()->getLocale() === 'es' ? '2. Uso de los datos' : '2. How We Use Your Data') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'Vos données personnelles sont utilisées exclusivement pour :' : (app()->getLocale() === 'es' ? 'Sus datos personales se utilizan exclusivamente para:' : 'Your personal data is used exclusively for:') }}</p>
            <ul>
                <li>{{ app()->getLocale() === 'fr' ? 'Gérer et confirmer vos réservations de rendez-vous.' : (app()->getLocale() === 'es' ? 'Gestionar y confirmar sus reservas de citas.' : 'Managing and confirming your appointment bookings.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Vous envoyer des rappels et confirmations par email ou SMS.' : (app()->getLocale() === 'es' ? 'Enviarle recordatorios y confirmaciones por correo electrónico o SMS.' : 'Sending you reminders and confirmations by email or SMS.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Améliorer la qualité de nos services en analysant les retours clients.' : (app()->getLocale() === 'es' ? 'Mejorar la calidad de nuestros servicios analizando los comentarios de los clientes.' : 'Improving the quality of our services by analyzing client feedback.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Vous informer de nos promotions et nouveautés si vous y avez consenti.' : (app()->getLocale() === 'es' ? 'Informarle sobre promociones y novedades si ha dado su consentimiento.' : 'Informing you about promotions and news if you have consented.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Respecter nos obligations légales et comptables.' : (app()->getLocale() === 'es' ? 'Cumplir con nuestras obligaciones legales y contables.' : 'Complying with our legal and accounting obligations.') }}</li>
            </ul>
        </div>

        <div class="legal-section" id="s3">
            <h2><i class="fa-solid fa-share-nodes"></i>
                {{ app()->getLocale() === 'fr' ? '3. Partage des informations' : (app()->getLocale() === 'es' ? '3. Compartir información' : '3. Sharing of Information') }}
            </h2>
            <div class="legal-highlight">
                {{ app()->getLocale() === 'fr' ? 'Nous ne vendons, louons ni partageons jamais vos données personnelles avec des tiers à des fins commerciales.' : (app()->getLocale() === 'es' ? 'Nunca vendemos, alquilamos ni compartimos sus datos personales con terceros con fines comerciales.' : 'We never sell, rent, or share your personal data with third parties for commercial purposes.') }}
            </div>
            <p>{{ app()->getLocale() === 'fr' ? 'Vos données peuvent être partagées uniquement avec :' : (app()->getLocale() === 'es' ? 'Sus datos pueden compartirse únicamente con:' : 'Your data may only be shared with:') }}</p>
            <ul>
                <li>{{ app()->getLocale() === 'fr' ? 'Nos prestataires de services techniques (hébergement, emails transactionnels, paiement sécurisé) dans le strict cadre de leur mission.' : (app()->getLocale() === 'es' ? 'Nuestros proveedores de servicios técnicos (alojamiento, correos transaccionales, pago seguro) en el estricto marco de su misión.' : 'Our technical service providers (hosting, transactional emails, secure payment) strictly within their service scope.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Les autorités compétentes en cas d\'obligation légale.' : (app()->getLocale() === 'es' ? 'Las autoridades competentes en caso de obligación legal.' : 'Competent authorities in case of legal obligation.') }}</li>
            </ul>
        </div>

        <div class="legal-section" id="s4">
            <h2><i class="fa-solid fa-cookie-bite"></i>Cookies</h2>
            <p>{{ app()->getLocale() === 'fr' ? 'Notre site utilise des cookies pour améliorer votre expérience de navigation. Les types de cookies utilisés sont :' : (app()->getLocale() === 'es' ? 'Nuestro sitio utiliza cookies para mejorar su experiencia de navegación. Los tipos de cookies utilizados son:' : 'Our site uses cookies to improve your browsing experience. The types of cookies used are:') }}</p>
            <ul>
                <li><strong>{{ app()->getLocale() === 'fr' ? 'Cookies essentiels' : (app()->getLocale() === 'es' ? 'Cookies esenciales' : 'Essential cookies') }}</strong> — {{ app()->getLocale() === 'fr' ? 'nécessaires au fonctionnement du site (session, CSRF, langue).' : (app()->getLocale() === 'es' ? 'necesarios para el funcionamiento del sitio (sesión, CSRF, idioma).' : 'required for site functionality (session, CSRF, language).') }}</li>
                <li><strong>{{ app()->getLocale() === 'fr' ? 'Cookies analytiques' : (app()->getLocale() === 'es' ? 'Cookies analíticas' : 'Analytics cookies') }}</strong> — {{ app()->getLocale() === 'fr' ? 'nous permettent d\'améliorer le contenu et les performances du site.' : (app()->getLocale() === 'es' ? 'nos permiten mejorar el contenido y el rendimiento del sitio.' : 'help us improve site content and performance.') }}</li>
            </ul>
            <p>{{ app()->getLocale() === 'fr' ? 'Vous pouvez désactiver les cookies dans les paramètres de votre navigateur à tout moment.' : (app()->getLocale() === 'es' ? 'Puede desactivar las cookies en la configuración de su navegador en cualquier momento.' : 'You can disable cookies in your browser settings at any time.') }}</p>
        </div>

        <div class="legal-section" id="s5">
            <h2><i class="fa-regular fa-clock"></i>
                {{ app()->getLocale() === 'fr' ? '5. Conservation des données' : (app()->getLocale() === 'es' ? '5. Retención de datos' : '5. Data Retention') }}
            </h2>
            <ul>
                <li>{{ app()->getLocale() === 'fr' ? 'Données de compte client : conservées pendant la durée de votre relation commerciale + 3 ans.' : (app()->getLocale() === 'es' ? 'Datos de cuenta de cliente: conservados durante la relación comercial + 3 años.' : 'Client account data: retained for the duration of your commercial relationship + 3 years.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Données de réservation : 5 ans à compter de la date de prestation (obligation légale).' : (app()->getLocale() === 'es' ? 'Datos de reserva: 5 años desde la fecha del servicio (obligación legal).' : 'Booking data: 5 years from the service date (legal obligation).') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Newsletter : jusqu\'au désabonnement.' : (app()->getLocale() === 'es' ? 'Boletín: hasta la cancelación de la suscripción.' : 'Newsletter: until unsubscription.') }}</li>
            </ul>
        </div>

        <div class="legal-section" id="s6">
            <h2><i class="fa-solid fa-user-shield"></i>
                {{ app()->getLocale() === 'fr' ? '6. Vos droits' : (app()->getLocale() === 'es' ? '6. Sus derechos' : '6. Your Rights') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'Conformément à la réglementation en vigueur, vous disposez des droits suivants :' : (app()->getLocale() === 'es' ? 'De conformidad con la normativa vigente, usted tiene los siguientes derechos:' : 'In accordance with applicable regulations, you have the following rights:') }}</p>
            <ul>
                <li>{{ app()->getLocale() === 'fr' ? 'Droit d\'accès à vos données personnelles.' : (app()->getLocale() === 'es' ? 'Derecho de acceso a sus datos personales.' : 'Right to access your personal data.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Droit de rectification des données inexactes.' : (app()->getLocale() === 'es' ? 'Derecho de rectificación de datos inexactos.' : 'Right to rectify inaccurate data.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Droit à l\'effacement (« droit à l\'oubli »).' : (app()->getLocale() === 'es' ? 'Derecho al borrado («derecho al olvido»).' : 'Right to erasure ("right to be forgotten").') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Droit à la portabilité de vos données.' : (app()->getLocale() === 'es' ? 'Derecho a la portabilidad de sus datos.' : 'Right to data portability.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Droit d\'opposition au traitement de vos données.' : (app()->getLocale() === 'es' ? 'Derecho de oposición al tratamiento de sus datos.' : 'Right to object to the processing of your data.') }}</li>
            </ul>
            <p>{{ app()->getLocale() === 'fr' ? 'Pour exercer ces droits, contactez-nous à l\'adresse indiquée ci-dessous.' : (app()->getLocale() === 'es' ? 'Para ejercer estos derechos, contáctenos en la dirección indicada a continuación.' : 'To exercise these rights, contact us at the address below.') }}</p>
        </div>

        <div class="legal-section" id="s7">
            <h2><i class="fa-solid fa-lock"></i>
                {{ app()->getLocale() === 'fr' ? '7. Sécurité' : (app()->getLocale() === 'es' ? '7. Seguridad' : '7. Security') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données contre tout accès non autorisé, perte, altération ou divulgation. Notre site utilise le protocole HTTPS pour sécuriser toutes les communications.' : (app()->getLocale() === 'es' ? 'Implementamos medidas técnicas y organizativas apropiadas para proteger sus datos contra el acceso no autorizado, la pérdida, la alteración o la divulgación. Nuestro sitio usa el protocolo HTTPS para asegurar todas las comunicaciones.' : 'We implement appropriate technical and organizational measures to protect your data against unauthorized access, loss, alteration, or disclosure. Our site uses HTTPS to secure all communications.') }}</p>
        </div>

        <div class="legal-section" id="s8">
            <h2><i class="fa-regular fa-envelope"></i>
                {{ app()->getLocale() === 'fr' ? '8. Contact' : (app()->getLocale() === 'es' ? '8. Contacto' : '8. Contact') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'Pour toute question relative à cette politique ou pour exercer vos droits :' : (app()->getLocale() === 'es' ? 'Para cualquier pregunta relacionada con esta política o para ejercer sus derechos:' : 'For any questions about this policy or to exercise your rights:') }}</p>
            <div class="legal-contact-card">
                <p><strong>Marol Hair Braiding</strong></p>
                <p>Chicago, IL — United States</p>
                <p>
                    <strong>{{ app()->getLocale() === 'fr' ? 'Email' : 'Email' }}:</strong>
                    <a href="{{ route('contact') }}">{{ app()->getLocale() === 'fr' ? 'Via notre formulaire de contact' : (app()->getLocale() === 'es' ? 'A través de nuestro formulario de contacto' : 'Via our contact form') }}</a>
                </p>
            </div>
        </div>

    </div>
</section>

@endsection
