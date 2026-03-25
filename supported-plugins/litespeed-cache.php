<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url( add_query_arg([
    'LSCWP_CTRL'     => 'purge',
    'litespeed_type' => 'purge_all',
]), 'purge', 'LSCWP_NONCE' );

return [
    'slug'  => 'litespeed-cache/litespeed-cache.php',
    'id'    => 'litespeed_cache',
    'name'  => 'LiteSpeed Cache',
    'rn'    => [
        'litespeed-menu',
    ],
    'links' => [
        [
            'label'    => 'Clear Page Cache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'litespeed-cache', false ),
        ],
    ],
];

