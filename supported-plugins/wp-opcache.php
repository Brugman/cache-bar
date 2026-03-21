<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url( add_query_arg([
    'flush_opcache_action' => 'flushopcacheall'
], remove_query_arg( 'settings-updated' ) ), 'flush_opcache_all' );

return [
    'slug'  => 'flush-opcache/flush-opcache.php',
    'id'    => 'wp_opcache',
    'name'  => 'WP OPcache',
    'links' => [
        'clear' => [
            'label' => 'Clear PHP OPcache',
            'url'   => $clear_url,
        ],
        // 'settings' => [
        //     'label' => 'X',
        //     'url'   => false,
        // ],
    ],
    'rn'    => [
        'flush_opcache_button',
    ],
];

