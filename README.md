# Cache Bar

> A WordPress plugin that streamlines your cache clearing.

## Supported Plugins

- [WP OPcache](https://wordpress.org/plugins/flush-opcache/)
- [CLP Varnish Cache](https://wordpress.org/plugins/clp-varnish-cache/)
- [Cache Enabler](https://wordpress.org/plugins/cache-enabler/)

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

## Contributing

Found a bug? Anything you would like to ask, add or change? Please open an issue so we can talk about it.

Pull requests are welcome. Please try to match the current code formatting.

## Author

[Tim Brugman](https://github.com/Brugman)