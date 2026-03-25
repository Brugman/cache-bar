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
    'rn'    => [
        'wp-rocket',
    ],
    'links' => [
        [
            'label'    => 'Clear Page Cache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'wprocket', false ),
        ],
    ],
];

