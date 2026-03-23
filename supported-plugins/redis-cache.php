<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url( network_admin_url( add_query_arg(
    'action',
    'flush-cache',
    ( is_multisite() ? 'settings.php' : 'options-general.php' ).'?page=redis-cache',
)), 'flush-cache' );

return [
    'slug'  => 'redis-cache/redis-cache.php',
    'id'    => 'redis_cache',
    'name'  => 'Redis Object Cache',
    'links' => [
        'clear' => [
            'label' => 'Clear Object Cache',
            'url'   => $clear_url,
        ],
        'settings' => [
            'label' => '<span class="ab-icon"></span>',
            'url'   => menu_page_url( 'redis-cache', false ),
        ],
    ],
    'rn'    => [
        'redis-cache',
    ],
];

