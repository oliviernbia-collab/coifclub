@extends('layouts.home')

@section('title', 'Terms of Use — Marol Hair Braiding')

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

@media(max-width:600px) {
    .legal-hero { padding: 56px 0 40px; }
    .legal-body  { padding: 40px 0 64px; }
}
</style>
@endpush

@section('content')
<section class="legal-hero">
    <div class="container" style="position:relative;z-index:1;">
        <div class="legal-eyebrow"><i class="fa-solid fa-file-contract"></i>
            {{ app()->getLocale() === 'fr' ? 'Juridique' : (app()->getLocale() === 'es' ? 'Legal' : 'Legal') }}
        </div>
        <h1>
            {{ app()->getLocale() === 'fr' ? 'Conditions Générales' : (app()->getLocale() === 'es' ? 'Condiciones' : 'Terms') }}
            <span>{{ app()->getLocale() === 'fr' ? 'd\'Utilisation' : (app()->getLocale() === 'es' ? 'de Uso' : 'of Use') }}</span>
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
                <li><a href="#t1">{{ app()->getLocale() === 'fr' ? 'Objet' : (app()->getLocale() === 'es' ? 'Objeto' : 'Purpose') }}</a></li>
                <li><a href="#t2">{{ app()->getLocale() === 'fr' ? 'Accès au service' : (app()->getLocale() === 'es' ? 'Acceso al servicio' : 'Access to Service') }}</a></li>
                <li><a href="#t3">{{ app()->getLocale() === 'fr' ? 'Réservation & annulation' : (app()->getLocale() === 'es' ? 'Reservas & cancelación' : 'Booking & Cancellation') }}</a></li>
                <li><a href="#t4">{{ app()->getLocale() === 'fr' ? 'Tarifs & paiement' : (app()->getLocale() === 'es' ? 'Precios & pago' : 'Pricing & Payment') }}</a></li>
                <li><a href="#t5">{{ app()->getLocale() === 'fr' ? 'Obligations du client' : (app()->getLocale() === 'es' ? 'Obligaciones del cliente' : 'Client Obligations') }}</a></li>
                <li><a href="#t6">{{ app()->getLocale() === 'fr' ? 'Responsabilité' : (app()->getLocale() === 'es' ? 'Responsabilidad' : 'Liability') }}</a></li>
                <li><a href="#t7">{{ app()->getLocale() === 'fr' ? 'Propriété intellectuelle' : (app()->getLocale() === 'es' ? 'Propiedad intelectual' : 'Intellectual Property') }}</a></li>
                <li><a href="#t8">{{ app()->getLocale() === 'fr' ? 'Loi applicable' : (app()->getLocale() === 'es' ? 'Ley aplicable' : 'Governing Law') }}</a></li>
            </ol>
        </div>

        <div class="legal-section" id="t1">
            <h2><i class="fa-solid fa-circle-info"></i>
                {{ app()->getLocale() === 'fr' ? '1. Objet' : (app()->getLocale() === 'es' ? '1. Objeto' : '1. Purpose') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'Les présentes Conditions Générales d\'Utilisation (CGU) régissent l\'utilisation du site web et des services de réservation de Marol Hair Braiding. En accédant à notre site ou en effectuant une réservation, vous acceptez sans réserve les présentes conditions.' : (app()->getLocale() === 'es' ? 'Estas Condiciones Generales de Uso rigen el uso del sitio web y los servicios de reserva de Marol Hair Braiding. Al acceder a nuestro sitio o realizar una reserva, acepta sin reservas las presentes condiciones.' : 'These Terms of Use govern the use of the Marol Hair Braiding website and booking services. By accessing our site or making a booking, you unconditionally accept these terms.') }}</p>
        </div>

        <div class="legal-section" id="t2">
            <h2><i class="fa-solid fa-globe"></i>
                {{ app()->getLocale() === 'fr' ? '2. Accès au service' : (app()->getLocale() === 'es' ? '2. Acceso al servicio' : '2. Access to Service') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'L\'accès au site est gratuit. Pour bénéficier des fonctionnalités de réservation, la création d\'un compte client est requise. Vous êtes responsable de la confidentialité de vos identifiants de connexion.' : (app()->getLocale() === 'es' ? 'El acceso al sitio es gratuito. Para acceder a las funciones de reserva, se requiere crear una cuenta de cliente. Usted es responsable de la confidencialidad de sus credenciales de inicio de sesión.' : 'Access to the site is free of charge. To use the booking features, creating a client account is required. You are responsible for keeping your login credentials confidential.') }}</p>
            <p>{{ app()->getLocale() === 'fr' ? 'Marol Hair Braiding se réserve le droit de suspendre ou de supprimer tout compte en cas d\'utilisation abusive ou contraire aux présentes CGU.' : (app()->getLocale() === 'es' ? 'Marol Hair Braiding se reserva el derecho de suspender o eliminar cualquier cuenta en caso de uso indebido o contrario a estas Condiciones.' : 'Marol Hair Braiding reserves the right to suspend or delete any account in case of abusive or non-compliant use.') }}</p>
        </div>

        <div class="legal-section" id="t3">
            <h2><i class="fa-regular fa-calendar-check"></i>
                {{ app()->getLocale() === 'fr' ? '3. Réservation & annulation' : (app()->getLocale() === 'es' ? '3. Reservas & cancelación' : '3. Booking & Cancellation') }}
            </h2>
            <ul>
                <li>{{ app()->getLocale() === 'fr' ? 'Toute réservation effectuée en ligne est considérée comme ferme et définitive après confirmation par email.' : (app()->getLocale() === 'es' ? 'Toda reserva realizada en línea se considera firme y definitiva tras la confirmación por correo electrónico.' : 'Any booking made online is considered firm and final after email confirmation.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'L\'annulation gratuite est possible jusqu\'à 24 heures avant le rendez-vous.' : (app()->getLocale() === 'es' ? 'La cancelación gratuita es posible hasta 24 horas antes de la cita.' : 'Free cancellation is possible up to 24 hours before the appointment.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'En cas d\'annulation tardive (moins de 24h) ou d\'absence sans prévenir, des frais de 30% du montant de la prestation pourront être facturés.' : (app()->getLocale() === 'es' ? 'En caso de cancelación tardía (menos de 24h) o ausencia sin aviso, podrá facturarse un 30% del importe del servicio.' : 'For late cancellations (under 24h) or no-shows without notice, a fee of 30% of the service amount may be charged.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Le salon se réserve le droit d\'annuler ou de reporter un rendez-vous en cas de force majeure, avec remboursement intégral ou proposition d\'un nouveau créneau.' : (app()->getLocale() === 'es' ? 'El salón se reserva el derecho de cancelar o posponer una cita en caso de fuerza mayor, con reembolso completo o propuesta de nuevo horario.' : 'The salon reserves the right to cancel or reschedule an appointment in case of force majeure, with a full refund or alternative slot offer.') }}</li>
            </ul>
        </div>

        <div class="legal-section" id="t4">
            <h2><i class="fa-solid fa-tag"></i>
                {{ app()->getLocale() === 'fr' ? '4. Tarifs & paiement' : (app()->getLocale() === 'es' ? '4. Precios & pago' : '4. Pricing & Payment') }}
            </h2>
            <ul>
                <li>{{ app()->getLocale() === 'fr' ? 'Les prix affichés s\'entendent pour la prestation de coiffure uniquement, hors extensions capillaires.' : (app()->getLocale() === 'es' ? 'Los precios mostrados son solo por el servicio de peinado, sin incluir extensiones capilares.' : 'Listed prices are for the braiding service only, excluding hair extensions.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Les prix sont exprimés en dollars américains (USD) et peuvent être modifiés sans préavis.' : (app()->getLocale() === 'es' ? 'Los precios están expresados en dólares estadounidenses (USD) y pueden modificarse sin previo aviso.' : 'Prices are quoted in US dollars (USD) and may change without prior notice.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Le paiement est exigible à la fin de la prestation, ou selon les modalités définies lors de la réservation.' : (app()->getLocale() === 'es' ? 'El pago es exigible al final del servicio, o según las modalidades definidas al hacer la reserva.' : 'Payment is due at the end of the service, or as agreed upon during booking.') }}</li>
            </ul>
        </div>

        <div class="legal-section" id="t5">
            <h2><i class="fa-solid fa-user-check"></i>
                {{ app()->getLocale() === 'fr' ? '5. Obligations du client' : (app()->getLocale() === 'es' ? '5. Obligaciones del cliente' : '5. Client Obligations') }}
            </h2>
            <ul>
                <li>{{ app()->getLocale() === 'fr' ? 'Se présenter à l\'heure convenue. Tout retard de plus de 15 minutes pourra entraîner l\'annulation du rendez-vous.' : (app()->getLocale() === 'es' ? 'Presentarse a la hora acordada. Un retraso de más de 15 minutos puede conllevar la cancelación de la cita.' : 'Arrive at the agreed time. A delay of more than 15 minutes may result in cancellation of the appointment.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Informer le salon de toute allergie, sensibilité ou condition particulière avant le début de la prestation.' : (app()->getLocale() === 'es' ? 'Informar al salón de cualquier alergia, sensibilidad o condición especial antes del inicio del servicio.' : 'Inform the salon of any allergies, sensitivities, or special conditions before the service begins.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Adopter un comportement respectueux envers le personnel et les autres clients.' : (app()->getLocale() === 'es' ? 'Mantener un comportamiento respetuoso con el personal y los demás clientes.' : 'Maintain respectful behavior towards staff and other clients.') }}</li>
                <li>{{ app()->getLocale() === 'fr' ? 'Venir avec les cheveux propres et sans produits coiffants lourds.' : (app()->getLocale() === 'es' ? 'Venir con el cabello limpio y sin productos de peinado pesados.' : 'Arrive with clean hair and no heavy styling products.') }}</li>
            </ul>
        </div>

        <div class="legal-section" id="t6">
            <h2><i class="fa-solid fa-scale-balanced"></i>
                {{ app()->getLocale() === 'fr' ? '6. Responsabilité' : (app()->getLocale() === 'es' ? '6. Responsabilidad' : '6. Liability') }}
            </h2>
            <div class="legal-highlight">
                {{ app()->getLocale() === 'fr' ? 'Marol Hair Braiding met tout en œuvre pour offrir des prestations de qualité. Toutefois, les résultats peuvent varier selon la nature des cheveux et les conditions individuelles de chaque cliente.' : (app()->getLocale() === 'es' ? 'Marol Hair Braiding hace todo lo posible por ofrecer servicios de calidad. Sin embargo, los resultados pueden variar según la naturaleza del cabello y las condiciones individuales de cada clienta.' : 'Marol Hair Braiding does its best to deliver quality services. However, results may vary depending on hair type and individual conditions of each client.') }}
            </div>
            <p>{{ app()->getLocale() === 'fr' ? 'Nous ne saurions être tenus responsables des dommages indirects résultant de l\'utilisation de notre site ou de nos services, au-delà de ce que permet la loi applicable.' : (app()->getLocale() === 'es' ? 'No podemos ser responsables de los daños indirectos resultantes del uso de nuestro sitio o servicios, más allá de lo permitido por la ley aplicable.' : 'We cannot be held liable for indirect damages resulting from the use of our site or services, beyond what applicable law permits.') }}</p>
        </div>

        <div class="legal-section" id="t7">
            <h2><i class="fa-regular fa-copyright"></i>
                {{ app()->getLocale() === 'fr' ? '7. Propriété intellectuelle' : (app()->getLocale() === 'es' ? '7. Propiedad intelectual' : '7. Intellectual Property') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'L\'ensemble du contenu de ce site (textes, images, logo, design) est la propriété exclusive de Marol Hair Braiding et est protégé par le droit d\'auteur. Toute reproduction, même partielle, est interdite sans autorisation écrite préalable.' : (app()->getLocale() === 'es' ? 'Todo el contenido de este sitio (textos, imágenes, logotipo, diseño) es propiedad exclusiva de Marol Hair Braiding y está protegido por derechos de autor. Cualquier reproducción, incluso parcial, está prohibida sin autorización escrita previa.' : 'All content on this site (text, images, logo, design) is the exclusive property of Marol Hair Braiding and is protected by copyright. Any reproduction, even partial, is prohibited without prior written authorization.') }}</p>
        </div>

        <div class="legal-section" id="t8">
            <h2><i class="fa-solid fa-gavel"></i>
                {{ app()->getLocale() === 'fr' ? '8. Loi applicable' : (app()->getLocale() === 'es' ? '8. Ley aplicable' : '8. Governing Law') }}
            </h2>
            <p>{{ app()->getLocale() === 'fr' ? 'Les présentes CGU sont soumises au droit de l\'État de l\'Illinois (États-Unis). Tout litige relatif à leur interprétation ou exécution sera soumis aux tribunaux compétents de Chicago, IL.' : (app()->getLocale() === 'es' ? 'Estas Condiciones se rigen por la ley del Estado de Illinois (Estados Unidos). Cualquier disputa relativa a su interpretación o ejecución se someterá a los tribunales competentes de Chicago, IL.' : 'These Terms are governed by the laws of the State of Illinois (United States). Any dispute relating to their interpretation or execution shall be submitted to the competent courts of Chicago, IL.') }}</p>
            <p>{{ app()->getLocale() === 'fr' ? 'Pour toute question, contactez-nous via' : (app()->getLocale() === 'es' ? 'Para cualquier pregunta, contáctenos a través de' : 'For any questions, contact us via') }}
            <a href="{{ route('contact') }}">{{ app()->getLocale() === 'fr' ? 'notre formulaire de contact' : (app()->getLocale() === 'es' ? 'nuestro formulario de contacto' : 'our contact form') }}</a>.</p>
        </div>

    </div>
</section>

@endsection
