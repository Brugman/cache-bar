<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url( add_query_arg([
    '_cache'  => 'cache-enabler',
    '_action' => 'clear',
]), 'cache_enabler_clear_cache_nonce' );

return [
    'slug'  => 'cache-enabler/cache-enabler.php',
    'id'    => 'cache_enabler',
    'name'  => 'Cache Enabler',
    'links' => [
        'clear' => [
            'label' => 'Clear Page Cache',
            'url'   => $clear_url,
        ],
        'settings' => [
            'label' => '<span class="ab-icon"></span>',
            'url'   => menu_page_url( 'cache-enabler', false ),
        ],
    ],
    'rn'    => [
        'cache_enabler_clear_cache',
        'cache_enabler_clear_page_cache',
    ],
];

