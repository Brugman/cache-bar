<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url(
    add_query_arg(
        [
            'page'   => 'nginx-cache',
            'action' => 'purge-cache',
        ],
        admin_url( 'tools.php' )
    ),
    'purge-cache'
);

return [
    'slug'  => 'nginx-cache/nginx-cache.php',
    'id'    => 'nginx_cache',
    'name'  => 'NGINX Cache',
    'rn'    => [
        'nginx-cache',
    ],
    'links' => [
        [
            'label'    => 'Clear Page Cache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'nginx-cache', false ),
        ],
    ],
];

