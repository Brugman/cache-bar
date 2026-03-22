<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url(
    admin_url( 'admin-post.php?action=purge_cache&type=all' ),
    'purge_cache_all'
);

return [
    'slug'  => 'wp-rocket/wp-rocket.php',
    'id'    => 'wp_rocket',
    'name'  => 'WP Rocket',
    'links' => [
        'clear' => [
            'label' => 'Clear Rocket Cache',
            'url'   => $clear_url,
        ],
        'settings' => [
            'label' => '<span class="ab-icon"></span>',
            'url'   => menu_page_url( 'wprocket', false ),
        ],
    ],
    'rn'    => [
        'wp-rocket',
    ],
];

