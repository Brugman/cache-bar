<?php

defined( 'ABSPATH' ) || exit;

$url = wp_nonce_url( network_admin_url( add_query_arg(
    'action',
    'flush-cache',
    ( is_multisite() ? 'settings.php' : 'options-general.php' ).'?page=redis-cache',
)), 'flush-cache' );

return [
    'slug'  => 'redis-cache/redis-cache.php',
    'id'    => 'redis_cache',
    'name'  => 'Redis Object Cache',
    'label' => 'Clear Redis Object Cache',
    'url'   => $url,
    'rn'    => [
        'redis-cache',
    ],
];

