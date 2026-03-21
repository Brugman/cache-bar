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
    'links' => [
        'clear' => [
            'label' => 'Clear LiteSpeed Page Cache',
            'url'   => $clear_url,
        ],
        'settings' => [
            'label' => 'Settings',
            'url'   => menu_page_url( 'litespeed-cache', false ),
        ],
    ],
    'rn'    => [
        'litespeed-menu',
    ],
];

