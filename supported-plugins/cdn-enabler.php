<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url( add_query_arg([
    '_cache'  => 'cdn',
    '_action' => 'purge',
]), 'cdn_enabler_purge_cache_nonce' );

return [
    'slug'  => 'cdn-enabler/cdn-enabler.php',
    'id'    => 'cdn_enabler',
    'name'  => 'CDN Enabler',
    'links' => [
        'clear' => [
            'label' => 'Clear CDN Cache',
            'url'   => $clear_url,
        ],
        'settings' => [
            'label' => '<span class="ab-icon"></span>',
            'url'   => menu_page_url( 'cdn-enabler', false ),
        ],
    ],
    'rn'    => [
        'cdn-enabler-purge-cache',
    ],
];

