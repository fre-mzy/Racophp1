
<?php

function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// Shows the photo if the file exists in assets/img.
// Otherwise, displays a visible placeholder showing which photo to add.
function photo($f, $alt, $c = '') {
    if (file_exists(__DIR__ . '/../assets/img/' . $f)) {
        return '<img class="' . h($c) . '" src="assets/img/' . h($f) . '" alt="' . h($alt) . '" loading="lazy">';
    }

    return '<div class="ph ' . h($c) . '"><span>PHOTO TAG<br><b>'
        . h($f) . '</b><br>' . h($alt) . '</span></div>';
}

$S = [

    // Core identity
    'n' => 'RACO Commission',
    's' => 'Umbrella Body of RACO Entities',
    'since' => 2003,

    // Official organisational description
    'description' => 'RACO Child Orphanage is the care and rehabilitation arm of RACO Child and Rural Care Initiative, a non-governmental agency providing shelter, free education, feeding, medication and welfare support to orphans, vulnerable, displaced and poor children, and empowerment to widows in rural communities every day.',

    'mission' => 'Providing shelter, free education, feeding, medication and welfare support to orphans, vulnerable, displaced and poor children, and empowerment to widows in rural communities every day.',

    'orphanage_role' => 'RACO Child Orphanage is the care and rehabilitation arm of RACO Child and Rural Care Initiative.',

    // The six entities under RACO Commission
    'entities' => [
        'RACO Child and Rural Care Initiative',
        'RACO Child Orphanage',
        'RACO Child Orphanage Nursery and Primary Schools',
        'RACO Life Center',
        'RACO Integrated Service',
        'RACO Broadcasting Network (RBN)',
    ],

    // Add a Google Analytics ID (G-XXXX) here to enable analytics after consent.
    'ga' => '',

    // Official contact details
    'wa' => '2347080004902',
    'mail' => 'info@racochildinitiative.org',

    'ph' => [
        ['0802 262 8461', 'Hotline 1 (ES)'],
        ['0906 056 2048', 'Hotline 2 (Divine)'],
        ['0802 699 4164', 'Hotline 3'],
        ['0708 000 4902', 'Official WhatsApp'],
    ],

    // Locations
    'loc' => [
        [
            'Lagos: RACO Light House',
            '33 Taiwo Adebambo Street, Araromi, Ibeju Agbe, Ibeju Lekki LGA, Lagos State',
            'Our official take-off centre for fully executing the RACO mandate.'
        ],
        [
            'Ogun: Topaz Gardens, Light City',
            'Itawo, Itamapako, off Ijebu Ode-Epe Expressway, by GUTS FM Toll Gate, off Oduagboju Bus Stop, Ijebu Ode LGA, Ogun State',
            ''
        ],
        [
            'Corporate headquarters: Mission Control Tower',
            'Light City, Itawo, Itamapako, off Ijebu Ode-Epe Expressway, by GUTS FM Toll Gate, Ijebu Ode LGA, Ogun State',
            ''
        ],
    ],

    // Programmes
    'prog' => [
        [
            'Free nursery and primary school',
            'Free tuition, textbooks, writing materials, notebooks, uniforms and clothing, plus a nutritious lunch every school day, for orphans and vulnerable children in rural areas. Over 400 children today; we aim to reach 3,000.',
            'school-classroom.jpg'
        ],
        [
            'Orphanage care and protection',
            'A faith-based home for orphaned, vulnerable and displaced poor children: meals, shelter, welfare, education and emotional support, with the goal of reintegrating every child into society.',
            'children-courtyard.jpg'
        ],
        [
            'Rural women empowerment',
            'Vocational training and starter tools for rural widows: tailoring, catering, small-scale farming, food vending, and pepper and cassava grinding businesses.',
            'widows-empowerment.jpg'
        ],
        [
            'Youth skills training',
            'Hands-on training in motorbike repair, shoe and bag making, electrical works, plumbing, carpentry, aluminium work, farming and agribusiness.',
            'youth-skills.jpg'
        ],
        [
            'Support for the aged',
            'Daily meals, essential medications and general welfare, so that no elderly person is left behind or forgotten.',
            'aged-support.jpg'
        ],
        [
            'Free medical outreach',
            'Free outreaches across rural communities, and the RACO Life Centre clinic, which offers free medical services to those in need.',
            'medical-outreach.jpg'
        ],
    ],

    // Team: replace verified names/roles and add photos to assets/img.
    'team' => [
        ['The Visionary', 'Founder and Visionary Leader', 'trustee-visionary.jpg', 'Trustees'],
        ['Deacon Osas', 'Trustee, Governance and Operations', 'trustee-osas.jpg', 'Trustees'],
        ['Deacon Obong', 'Trustee, Welfare and Stewardship', 'trustee-obong.jpg', 'Trustees'],
        ['Sister Ekeng', 'Trustee, Child Protection and Care', 'trustee-ekeng.jpg', 'Trustees'],
        ['Otunba', 'Trustee, Community Relations', 'trustee-otunba.jpg', 'Trustees'],
        ['Oluwaseunfunmi', 'Trustee, Youth and Development', 'trustee-oluwaseunfunmi.jpg', 'Trustees'],
        ['Pastor Peter', 'Trustee, Spiritual Guidance and Welfare', 'trustee-pastor-peter.jpg', 'Trustees'],
        ['Mrs. Elizabeth Daniel', 'Trustee, Widows Empowerment', 'trustee-elizabeth-daniel.jpg', 'Trustees'],

        // Replace placeholder ambassadors with verified names and photos.
        ['[Full name]', '[Ambassador]', 'ambassador-1.jpg', 'Ambassadors'],
        ['[Full name]', '[Ambassador]', 'ambassador-2.jpg', 'Ambassadors'],
        ['[Full name]', '[Ambassador]', 'ambassador-3.jpg', 'Ambassadors'],
    ],

    // Annual events
    'ev' => [
        ['May 1', 'Light City Foundational Laying Day'],
        ['Jul 26', 'RACO Schools Combined Graduation and Thanksgiving'],
        ['Sep 18', 'RACO Schools Founding Day (since 2007)'],
        ['Oct 17', 'RACO Commission Annual Thanksgiving (since 2003)'],
        ['Dec 19-23', 'Annual RACO Christmas Grace Fun Fair and Rural Widows Empowerment Ceremony'],
    ],

];
