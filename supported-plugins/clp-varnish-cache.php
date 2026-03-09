<?php

defined( 'ABSPATH' ) || exit;

$url = add_query_arg([
    'page'   => 'clp-varnish-cache',
    'action' => 'purge-entire-cache',
], admin_url( 'options-general.php' ) );

return [
    'slug'  => 'clp-varnish-cache/clp-varnish-cache.php',
    'id'    => 'clp_varnish_cache',
    'name'  => 'CLP Varnish Cache',
    'label' => 'Clear Varnish Cache',
    'url'   => $url,
    'rn'    => [],
];

