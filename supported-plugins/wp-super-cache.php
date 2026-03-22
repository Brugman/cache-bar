<?php

defined( 'ABSPATH' ) || exit;

$path_to_home = trailingslashit( rtrim( (string) parse_url( get_option( 'home' ), PHP_URL_PATH ), '/' ) );

$clear_url = wp_nonce_url(
    admin_url( 'index.php?admin=1&action=delcachepage&path='.rawurlencode( $path_to_home ) ),
    'delete-cache-'.$path_to_home.'_1',
    'nonce'
);

return [
    'slug'  => 'wp-super-cache/wp-cache.php',
    'id'    => 'wp_super_cache',
    'name'  => 'WP Super Cache',
    'links' => [
        'clear' => [
            'label' => 'Clear Super Cache',
            'url'   => $clear_url,
        ],
        'settings' => [
            'label' => 'Settings',
            'url'   => menu_page_url( 'wpsupercache', false ),
        ],
    ],
    'rn'    => [
        'delete-cache',
    ],
];

