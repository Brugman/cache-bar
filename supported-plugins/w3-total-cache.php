<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url( network_admin_url( 'admin.php?page=w3tc_dashboard&w3tc_flush_all' ), 'w3tc' );

return [
    'slug'  => 'w3-total-cache/w3-total-cache.php',
    'id'    => 'w3_total_cache',
    'name'  => 'W3 Total Cache',
    'rn'    => [
        'w3tc',
    ],
    'links' => [
        [
            'label'    => 'Clear Page Cache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'w3tc_dashboard', false ),
        ],
    ],
];

