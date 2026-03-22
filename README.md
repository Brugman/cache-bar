# Cache Bar

> A WordPress plugin that streamlines your cache clearing.

## Supported Plugins

Plugin | Primary Cache Type
:--- |:---
[WP OPcache](https://wordpress.org/plugins/flush-opcache/) | PHP OPcache
[OPcache Manager](https://wordpress.org/plugins/opcache-manager/) | PHP OPcache
[LiteSpeed Cache](https://wordpress.org/plugins/litespeed-cache/) | Server-Side Page Cache
[CLP Varnish Cache](https://wordpress.org/plugins/clp-varnish-cache/) | Server-Side Page Cache
[WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) | Page Cache
[W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/) | Page Cache
[Cache Enabler](https://wordpress.org/plugins/cache-enabler/) | Page Cache
[WP Rocket](https://wp-rocket.me/) | Page Cache
[Redis Object Cache](https://wordpress.org/plugins/redis-cache/) | Object Cache

## Configurations

### Displaying the master toolbar

By default, the master toolbar is being shown to users with the Administrator role. It may make sense to lower this to include Editors but you have to make sure that your caching plugins also allow Editors to clear the cache. Here's a snippet to set the capability to Editor and above:

```php
add_filter( 'ccc_add_toolbar', function ( $capability ) {
    return 'edit_pages';
});
```

### Keep third party toolbars

By default, third party toolbars are hidden for everyone. You can set a high capability so they are still shown to some people, but this defeats the purpose of the plugin. Here's a snippet to set the capability to Administrator and above:

```php
add_filter( 'ccc_keep_third_party_toolbars', function ( $capability ) {
    return 'manage_options';
});
```

### Move toolbar to the right

```php
add_filter( 'ccc_toolbar_position_right', '__return_true' );
```

## Contributing

Found a bug? Anything you would like to ask, add or change? Please open an issue so we can talk about it.

Pull requests are welcome. Please try to match the current code formatting.

## Author

[Tim Brugman](https://github.com/Brugman)