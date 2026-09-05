<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url(
    add_query_arg(
        [
            'page'                => 'nginx',
            'nginx_helper_action' => 'purge',
            'nginx_helper_urls'   => 'all',
        ],
        admin_url( 'options-general.php' )
    ),
    'nginx_helper-purge_all'
);

return [
    'slug'  => 'nginx-helper/nginx-helper.php',
    'id'    => 'nginx_helper',
    'name'  => 'NGINX Helper',
    'rn'    => [
        'nginx-helper-purge-all',
    ],
    'links' => [
        [
            'label'    => 'Clear Page Cache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'nginx', false ),
        ],
    ],
];

