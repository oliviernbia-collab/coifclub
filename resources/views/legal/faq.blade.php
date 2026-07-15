@extends('layouts.home')

@section('title', 'FAQ — Marol Hair Braiding')

@push('styles')
<style>
:root {
    --pink: #e83e8c;
    --pink-dark: #c91a78;
    --dark: #1a1a2e;
}

/* ── Hero ── */
.faq-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f0e2a 100%);
    padding: 88px 0 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.faq-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(232,62,140,.14), transparent);
    pointer-events: none;
}
.faq-hero-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(232,62,140,.1); border: 1px solid rgba(232,62,140,.2);
    color: #ff6ab4; font-size: .75rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    padding: 6px 16px; border-radius: 50px; margin-bottom: 18px;
    font-family: 'Inter', sans-serif;
}
.faq-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 900; color: #fff; margin-bottom: 14px; line-height: 1.15;
}
.faq-hero h1 span { color: var(--pink); }
.faq-hero-sub {
    color: rgba(255,255,255,.45); font-size: .95rem; max-width: 520px;
    margin: 0 auto; font-family: 'Inter', sans-serif; line-height: 1.7;
}

/* ── Search ── */
.faq-search-wrap {
    max-width: 540px; margin: 32px auto 0;
    position: relative;
}
.faq-search-wrap i {
    position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
    color: rgba(255,255,255,.25); font-size: .9rem; pointer-events: none;
}
.faq-search {
    width: 100%; background: rgba(255,255,255,.06);
    border: 1.5px solid rgba(255,255,255,.1); border-radius: 50px;
    padding: 13px 18px 13px 42px;
    color: #fff; font-size: .9rem; font-family: 'Inter', sans-serif;
    outline: none; transition: .2s;
}
.faq-search:focus { border-color: rgba(232,62,140,.4); background: rgba(255,255,255,.08); }
.faq-search::placeholder { color: rgba(255,255,255,.25); }

/* ── Layout ── */
.faq-body {
    background: #0f0e2a;
    padding: 72px 0 96px;
}
.faq-container {
    max-width: 860px; margin: 0 auto; padding: 0 24px;
}

/* ── Category tabs ── */
.faq-tabs {
    display: flex; flex-wrap: wrap; gap: 8px;
    justify-content: center; margin-bottom: 48px;
}
.faq-tab {
    padding: 8px 20px; border-radius: 50px;
    background: rgba(255,255,255,.05);
    border: 1.5px solid rgba(255,255,255,.09);
    color: rgba(255,255,255,.5); font-size: .82rem; font-weight: 600;
    cursor: pointer; transition: .2s; font-family: 'Inter', sans-serif;
}
.faq-tab:hover { border-color: rgba(232,62,140,.3); color: rgba(255,255,255,.8); }
.faq-tab.active {
    background: var(--pink); border-color: var(--pink);
    color: #fff; box-shadow: 0 4px 16px rgba(232,62,140,.3);
}

/* ── Section ── */
.faq-section { margin-bottom: 48px; }
.faq-section-title {
    display: flex; align-items: center; gap: 10px;
    font-family: 'Inter', sans-serif; font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--pink); margin-bottom: 16px;
}
.faq-section-title::after {
    content: ''; flex: 1; height: 1px;
    background: rgba(232,62,140,.15);
}

/* ── Accordion ── */
.faq-list { display: flex; flex-direction: column; gap: 10px; }
.faq-item {
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 16px; overflow: hidden; transition: border-color .25s;
}
.faq-item.open { border-color: rgba(232,62,140,.22); }
.faq-item-q {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px; cursor: pointer; gap: 14px;
    color: rgba(255,255,255,.82); font-size: .93rem; font-weight: 600;
    font-family: 'Inter', sans-serif; user-select: none;
}
.faq-item-q:hover { color: #fff; }
.faq-item-icon {
    width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
    background: rgba(232,62,140,.1); border: 1px solid rgba(232,62,140,.18);
    color: #ff6ab4; font-size: .68rem;
    display: flex; align-items: center; justify-content: center; transition: .25s;
}
.faq-item.open .faq-item-icon {
    background: var(--pink); border-color: transparent;
    color: #fff; transform: rotate(45deg);
}
.faq-item-a {
    max-height: 0; overflow: hidden;
    transition: max-height .35s ease, padding .25s;
    padding: 0 22px;
    color: rgba(255,255,255,.48); font-size: .88rem;
    line-height: 1.8; font-family: 'Inter', sans-serif;
}
.faq-item.open .faq-item-a { max-height: 400px; padding: 0 22px 20px; }
.faq-item-a a { color: #ff6ab4; text-decoration: underline; }

/* ── CTA ── */
.faq-cta {
    margin-top: 64px; text-align: center;
    background: rgba(232,62,140,.07);
    border: 1px solid rgba(232,62,140,.15);
    border-radius: 24px; padding: 48px 32px;
}
.faq-cta h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 10px;
}
.faq-cta p { color: rgba(255,255,255,.45); font-family: 'Inter', sans-serif; margin-bottom: 24px; }
.faq-cta-btns { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; }
.faq-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--pink); color: #fff; padding: 12px 26px;
    border-radius: 10px; font-size: .9rem; font-weight: 700;
    text-decoration: none; transition: .2s; font-family: 'Inter', sans-serif;
    box-shadow: 0 6px 20px rgba(232,62,140,.35);
}
.faq-btn:hover { background: var(--pink-dark); transform: translateY(-2px); color: #fff; }
.faq-btn-ghost {
    display: inline-flex; align-items: center; gap: 8px;
    color: rgba(255,255,255,.6); padding: 12px 26px;
    border-radius: 10px; font-size: .9rem; font-weight: 600;
    text-decoration: none; border: 1.5px solid rgba(255,255,255,.12);
    transition: .2s; font-family: 'Inter', sans-serif;
}
.faq-btn-ghost:hover { color: #fff; border-color: rgba(255,255,255,.3); }

/* ── No-results ── */
.faq-empty {
    text-align: center; padding: 48px 24px;
    color: rgba(255,255,255,.3); font-family: 'Inter', sans-serif;
    display: none;
}
.faq-empty i { font-size: 2rem; display: block; margin-bottom: 10px; color: rgba(232,62,140,.2); }

@media(max-width:600px) {
    .faq-hero { padding: 60px 0 44px; }
    .faq-body  { padding: 44px 0 64px; }
    .faq-cta   { padding: 32px 20px; }
}
</style>
@endpush

@section('content')
{{-- ── HERO ── --}}
<section class="faq-hero">
    <div class="container">
        <div class="faq-hero-eyebrow">
            <i class="fa-regular fa-circle-question"></i>
            FAQ
        </div>
        <h1>{{ __('messages.faq_title') }}<br><span>Marol Hair Braiding</span></h1>
        <p class="faq-hero-sub">{{ __('messages.faq_sub') }}</p>
        <div class="faq-search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="faq-search" id="faqSearch"
                   placeholder="{{ app()->getLocale() === 'fr' ? 'Rechercher une question…' : (app()->getLocale() === 'es' ? 'Buscar una pregunta…' : 'Search a question…') }}">
        </div>
    </div>
</section>

{{-- ── BODY ── --}}
<section class="faq-body">
    <div class="faq-container">

        {{-- Tabs --}}
        <div class="faq-tabs">
            <button class="faq-tab active" onclick="filterCat('all', this)">
                {{ app()->getLocale() === 'fr' ? 'Tout' : (app()->getLocale() === 'es' ? 'Todo' : 'All') }}
            </button>
            <button class="faq-tab" onclick="filterCat('booking', this)">
                {{ app()->getLocale() === 'fr' ? 'Réservation' : (app()->getLocale() === 'es' ? 'Reservas' : 'Booking') }}
            </button>
            <button class="faq-tab" onclick="filterCat('services', this)">
                Services
            </button>
            <button class="faq-tab" onclick="filterCat('payment', this)">
                {{ app()->getLocale() === 'fr' ? 'Paiement' : (app()->getLocale() === 'es' ? 'Pago' : 'Payment') }}
            </button>
            <button class="faq-tab" onclick="filterCat('care', this)">
                {{ app()->getLocale() === 'fr' ? 'Soin capillaire' : (app()->getLocale() === 'es' ? 'Cuidado' : 'Hair Care') }}
            </button>
        </div>

        {{-- Section: Booking --}}
        <div class="faq-section" data-cat="booking">
            <div class="faq-section-title">
                <i class="fa-regular fa-calendar-check"></i>
                {{ app()->getLocale() === 'fr' ? 'Réservation & Rendez-vous' : (app()->getLocale() === 'es' ? 'Reservas & Citas' : 'Booking & Appointments') }}
            </div>
            <div class="faq-list">
                @foreach([
                    ['q' => __('messages.faq_q4'), 'a' => __('messages.faq_a4')],
                    ['q' => __('messages.faq_q5'), 'a' => __('messages.faq_a5')],
                    ['q' => __('messages.faq_q6'), 'a' => __('messages.faq_a6')],
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Puis-je modifier mon rendez-vous après confirmation ?' : (app()->getLocale() === 'es' ? '¿Puedo modificar mi cita después de confirmarla?' : 'Can I change my appointment after confirming?'),
                        'a' => app()->getLocale() === 'fr' ? 'Oui, vous pouvez modifier ou reporter votre rendez-vous depuis votre espace client jusqu\'à 24 heures avant la date prévue. Passé ce délai, veuillez nous contacter directement par téléphone ou WhatsApp.' : (app()->getLocale() === 'es' ? 'Sí, puedes modificar o reprogramar tu cita desde tu perfil hasta 24 horas antes. Pasado ese tiempo, contáctanos directamente por teléfono o WhatsApp.' : 'Yes, you can modify or reschedule your appointment from your client dashboard up to 24 hours in advance. After that, please contact us directly by phone or WhatsApp.'),
                    ],
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Puis-je réserver pour quelqu\'un d\'autre ?' : (app()->getLocale() === 'es' ? '¿Puedo reservar para otra persona?' : 'Can I book on behalf of someone else?'),
                        'a' => app()->getLocale() === 'fr' ? 'Oui, vous pouvez réserver un rendez-vous pour un proche. Il vous suffit d\'indiquer ses informations dans le champ "Message au salon" lors de la réservation.' : (app()->getLocale() === 'es' ? 'Sí, puedes reservar una cita para otra persona. Solo menciona sus datos en el campo de notas al hacer la reserva.' : 'Yes, you can book an appointment for someone else. Simply mention their information in the notes field when booking.'),
                    ],
                ] as $item)
                <div class="faq-item">
                    <div class="faq-item-q" onclick="toggleItem(this)">
                        <span>{{ $item['q'] }}</span>
                        <span class="faq-item-icon"><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <div class="faq-item-a">{{ $item['a'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Section: Services --}}
        <div class="faq-section" data-cat="services">
            <div class="faq-section-title">
                <i class="fa-solid fa-scissors"></i>
                {{ app()->getLocale() === 'fr' ? 'Services & Styles' : (app()->getLocale() === 'es' ? 'Servicios & Estilos' : 'Services & Styles') }}
            </div>
            <div class="faq-list">
                @foreach([
                    ['q' => __('messages.faq_q1'), 'a' => __('messages.faq_a1')],
                    ['q' => __('messages.faq_q2'), 'a' => __('messages.faq_a2')],
                    ['q' => __('messages.faq_q3'), 'a' => __('messages.faq_a3')],
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Proposez-vous des styles pour enfants ?' : (app()->getLocale() === 'es' ? '¿Ofrecen estilos para niños?' : 'Do you offer styles for children?'),
                        'a' => app()->getLocale() === 'fr' ? 'Oui, nous proposons des coiffures adaptées aux enfants. Les durées et tarifs sont différents selon l\'âge et le style choisi. Contactez-nous pour plus d\'informations.' : (app()->getLocale() === 'es' ? 'Sí, ofrecemos peinados adaptados para niños. Los tiempos y precios varían según la edad y el estilo. Contáctenos para más información.' : 'Yes, we offer styles suitable for children. Times and prices vary by age and style. Contact us for more details.'),
                    ],
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Mes cheveux naturels sont-ils requis ?' : (app()->getLocale() === 'es' ? '¿Se requiere cabello natural?' : 'Is natural hair required?'),
                        'a' => app()->getLocale() === 'fr' ? 'La plupart de nos styles peuvent être réalisés sur tous types de cheveux. Pour certains styles comme les locs ou le crochet, un minimum de longueur peut être requis. Notre équipe vous guidera lors de votre consultation.' : (app()->getLocale() === 'es' ? 'La mayoría de nuestros estilos se pueden hacer en todo tipo de cabello. Para algunos estilos como locs o crochet, puede requerirse una longitud mínima. Nuestro equipo te orientará.' : 'Most of our styles work on all hair types. For some styles like locs or crochet, a minimum length may be required. Our team will guide you during your consultation.'),
                    ],
                ] as $item)
                <div class="faq-item">
                    <div class="faq-item-q" onclick="toggleItem(this)">
                        <span>{{ $item['q'] }}</span>
                        <span class="faq-item-icon"><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <div class="faq-item-a">{{ $item['a'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Section: Payment --}}
        <div class="faq-section" data-cat="payment">
            <div class="faq-section-title">
                <i class="fa-regular fa-credit-card"></i>
                {{ app()->getLocale() === 'fr' ? 'Paiement & Tarifs' : (app()->getLocale() === 'es' ? 'Pago & Precios' : 'Payment & Pricing') }}
            </div>
            <div class="faq-list">
                @foreach([
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Quels modes de paiement acceptez-vous ?' : (app()->getLocale() === 'es' ? '¿Qué métodos de pago aceptan?' : 'What payment methods do you accept?'),
                        'a' => app()->getLocale() === 'fr' ? 'Nous acceptons les espèces, les cartes bancaires (Visa, Mastercard), les virements et le paiement mobile. Un acompte peut être demandé lors de la réservation en ligne.' : (app()->getLocale() === 'es' ? 'Aceptamos efectivo, tarjetas bancarias (Visa, Mastercard), transferencias y pago móvil. Puede requerirse un depósito al reservar en línea.' : 'We accept cash, credit/debit cards (Visa, Mastercard), bank transfers, and mobile payments. A deposit may be required when booking online.'),
                    ],
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Les prix affichés incluent-ils les extensions ?' : (app()->getLocale() === 'es' ? '¿Los precios incluyen extensiones?' : 'Do prices include hair extensions?'),
                        'a' => app()->getLocale() === 'fr' ? 'Non, les prix affichés correspondent uniquement à la prestation de coiffure. Les extensions sont facturées en supplément selon le type et la quantité requis. Vous pouvez apporter vos propres extensions.' : (app()->getLocale() === 'es' ? 'No, los precios mostrados son solo por el servicio de peinado. Las extensiones se cobran aparte según el tipo y cantidad. Puedes traer tus propias extensiones.' : 'No, listed prices are for the braiding service only. Extensions are charged separately based on type and quantity needed. You are welcome to bring your own.'),
                    ],
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Proposez-vous des promotions ou des forfaits ?' : (app()->getLocale() === 'es' ? '¿Ofrecen promociones o paquetes?' : 'Do you offer promotions or packages?'),
                        'a' => app()->getLocale() === 'fr' ? 'Oui, nous proposons régulièrement des promotions saisonnières et des offres spéciales pour nos clients VIP. Abonnez-vous à notre newsletter pour être informé(e) en premier.' : (app()->getLocale() === 'es' ? 'Sí, ofrecemos promociones de temporada y ofertas especiales para clientes VIP. Suscríbete a nuestro boletín para enterarte primero.' : 'Yes, we regularly offer seasonal promotions and special deals for VIP clients. Subscribe to our newsletter to be the first to know.'),
                    ],
                ] as $item)
                <div class="faq-item">
                    <div class="faq-item-q" onclick="toggleItem(this)">
                        <span>{{ $item['q'] }}</span>
                        <span class="faq-item-icon"><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <div class="faq-item-a">{{ $item['a'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Section: Care --}}
        <div class="faq-section" data-cat="care">
            <div class="faq-section-title">
                <i class="fa-solid fa-spa"></i>
                {{ app()->getLocale() === 'fr' ? 'Entretien & Soin' : (app()->getLocale() === 'es' ? 'Mantenimiento & Cuidado' : 'Maintenance & Care') }}
            </div>
            <div class="faq-list">
                @foreach([
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Comment entretenir mes tresses ?' : (app()->getLocale() === 'es' ? '¿Cómo mantengo mis trenzas?' : 'How do I maintain my braids?'),
                        'a' => app()->getLocale() === 'fr' ? 'Hydratez votre cuir chevelu régulièrement avec une huile légère, dormez avec un bonnet en satin et évitez de mouiller trop fréquemment vos tresses. Notre équipe vous donnera des conseils personnalisés après chaque prestation.' : (app()->getLocale() === 'es' ? 'Hidrata tu cuero cabelludo regularmente con un aceite ligero, duerme con una cofia de satén y evita mojar las trenzas con frecuencia. Nuestro equipo te dará consejos personalizados después de cada servicio.' : 'Moisturize your scalp regularly with a light oil, sleep with a satin bonnet, and avoid over-wetting your braids. Our team will give you personalized care tips after each service.'),
                    ],
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Combien de temps les tresses peuvent-elles tenir ?' : (app()->getLocale() === 'es' ? '¿Cuánto tiempo duran las trenzas?' : 'How long do braids last?'),
                        'a' => app()->getLocale() === 'fr' ? 'Avec un entretien approprié, la plupart des styles tressés durent entre 4 et 8 semaines. Les knotless braids et box braids tiennent généralement 6 à 8 semaines, tandis que les cornrows peuvent nécessiter un retouche après 3 à 4 semaines.' : (app()->getLocale() === 'es' ? 'Con el cuidado adecuado, la mayoría de los estilos de trenzas duran entre 4 y 8 semanas. Las knotless braids y box braids suelen durar 6-8 semanas, mientras que los cornrows pueden necesitar retoque a las 3-4 semanas.' : 'With proper care, most braided styles last 4 to 8 weeks. Knotless and box braids typically last 6–8 weeks, while cornrows may need a touch-up after 3–4 weeks.'),
                    ],
                    [
                        'q' => app()->getLocale() === 'fr' ? 'Dois-je venir avec les cheveux lavés ?' : (app()->getLocale() === 'es' ? '¿Debo llegar con el cabello lavado?' : 'Should I arrive with clean hair?'),
                        'a' => app()->getLocale() === 'fr' ? 'Oui, nous recommandons de venir avec des cheveux propres, légèrement hydratés et sans produits coiffants lourds. Cela permet d\'obtenir un meilleur résultat et de préserver la santé de vos cheveux.' : (app()->getLocale() === 'es' ? 'Sí, recomendamos llegar con el cabello limpio, ligeramente hidratado y sin productos de peinado pesados. Esto permite obtener un mejor resultado y preservar la salud capilar.' : 'Yes, we recommend arriving with clean, lightly moisturized hair and no heavy styling products. This ensures the best result and protects your hair health.'),
                    ],
                ] as $item)
                <div class="faq-item">
                    <div class="faq-item-q" onclick="toggleItem(this)">
                        <span>{{ $item['q'] }}</span>
                        <span class="faq-item-icon"><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <div class="faq-item-a">{{ $item['a'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Empty state --}}
        <div class="faq-empty" id="faqEmpty">
            <i class="fa-solid fa-magnifying-glass"></i>
            {{ app()->getLocale() === 'fr' ? 'Aucune question trouvée.' : (app()->getLocale() === 'es' ? 'No se encontraron preguntas.' : 'No questions found.') }}
        </div>

        {{-- CTA --}}
        <div class="faq-cta">
            <h3>
                {{ app()->getLocale() === 'fr' ? 'Votre question n\'est pas listée ?' : (app()->getLocale() === 'es' ? '¿Tu pregunta no está aquí?' : 'Didn\'t find your answer?') }}
            </h3>
            <p>
                {{ app()->getLocale() === 'fr' ? 'Notre équipe est disponible pour répondre à toutes vos questions.' : (app()->getLocale() === 'es' ? 'Nuestro equipo está disponible para responder todas tus preguntas.' : 'Our team is available to answer all your questions.') }}
            </p>
            <div class="faq-cta-btns">
                <a href="{{ route('contact') }}" class="faq-btn">
                    <i class="fa-solid fa-envelope"></i>
                    {{ app()->getLocale() === 'fr' ? 'Nous contacter' : (app()->getLocale() === 'es' ? 'Contáctanos' : 'Contact Us') }}
                </a>
                <a href="{{ route('booking.start') }}" class="faq-btn-ghost">
                    <i class="fa-regular fa-calendar-check"></i>
                    {{ app()->getLocale() === 'fr' ? 'Prendre rendez-vous' : (app()->getLocale() === 'es' ? 'Reservar cita' : 'Book an Appointment') }}
                </a>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
function toggleItem(btn) {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
}

function filterCat(cat, btn) {
    document.querySelectorAll('.faq-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.faq-section').forEach(s => {
        s.style.display = (cat === 'all' || s.dataset.cat === cat) ? '' : 'none';
    });
}

document.getElementById('faqSearch').addEventListener('input', function() {
    const q = this.value.trim().toLowerCase();
    let anyVisible = false;

    document.querySelectorAll('.faq-item').forEach(item => {
        const text = item.querySelector('.faq-item-q span').textContent.toLowerCase()
                   + item.querySelector('.faq-item-a').textContent.toLowerCase();
        const match = !q || text.includes(q);
        item.style.display = match ? '' : 'none';
        if (match) anyVisible = true;
    });

    // Show/hide sections based on remaining visible items
    document.querySelectorAll('.faq-section').forEach(sec => {
        const hasVisible = [...sec.querySelectorAll('.faq-item')].some(i => i.style.display !== 'none');
        sec.style.display = hasVisible ? '' : 'none';
    });

    document.getElementById('faqEmpty').style.display = anyVisible ? 'none' : 'block';

    // Reset tabs
    if (q) {
        document.querySelectorAll('.faq-tab').forEach(t => t.classList.remove('active'));
    }
});
</script>
@endpush

@endsection
