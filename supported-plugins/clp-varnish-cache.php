<?php

defined( 'ABSPATH' ) || exit;

$clear_url = add_query_arg([
    'page'   => 'clp-varnish-cache',
    'action' => 'purge-entire-cache',
], admin_url( 'options-general.php' ) );

return [
    'slug'  => 'clp-varnish-cache/clp-varnish-cache.php',
    'id'    => 'clp_varnish_cache',
    'name'  => 'CLP Varnish Cache',
    'rn'    => [],
    'links' => [
        [
            'label'    => 'Clear Page Cache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'clp-varnish-cache', false ),
        ],
    ],
];

