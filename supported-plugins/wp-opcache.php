<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url( add_query_arg([
    'flush_opcache_action' => 'flushopcacheall'
], remove_query_arg( 'settings-updated' ) ), 'flush_opcache_all' );

return [
    'slug'  => 'flush-opcache/flush-opcache.php',
    'id'    => 'wp_opcache',
    'name'  => 'WP OPcache',
    'rn'    => [
        'flush_opcache_button',
    ],
    'links' => [
        [
            'label'    => 'Clear OPcache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'flush-opcache', false ),
        ],
    ],
];

