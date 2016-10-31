![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)
# WP Plugin: Same level subdomains for multisites
[![Latest Stable Version](https://poser.pugx.org/devgeniem/wp-multisite-same-level-subdomains/v/stable)](https://packagist.org/packages/devgeniem/wp-multisite-same-level-subdomains) [![Total Downloads](https://poser.pugx.org/devgeniem/wp-multisite-same-level-subdomains/downloads)](https://packagist.org/packages/devgeniem/wp-multisite-same-level-subdomains) [![Latest Unstable Version](https://poser.pugx.org/devgeniem/wp-multisite-same-level-subdomains/v/unstable)](https://packagist.org/packages/devgeniem/wp-multisite-same-level-subdomains) [![License](https://poser.pugx.org/devgeniem/wp-multisite-same-level-subdomains/license)](https://packagist.org/packages/devgeniem/wp-multisite-same-level-subdomains)

This WordPress multisite plugin allows you to create subsites under the same subdomain depth as the main site.

## Example use case

We needed to create subdomain multisite which uses only subdomains under `*.client.com` and nothing else.
In this case `client.com` domain was simultaneously used elsewhere for non-WordPress site so that couldn't be the domain of the main site.

We created this plugin in order to use `admin.client.com` as the main site and `site1.client.com`, `site2.client.com` for the subsites respectively.

## Installation
```bash
$ composer require devgeniem/wp-multisite-same-level-subdomains
```

## Configuration
We recommend installing this plugin with composer or dropping it the plugin directory into your mu-plugins directory.

Then create a wp-content/sunrise.php file with the following:

```php
<?php
// Default mu-plugins directory if you haven't set it
defined( 'WPMU_PLUGIN_DIR' ) or define( 'WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins' );

require WPMU_PLUGIN_DIR . '/wp-multisite-same-level-subdomains/wp-multisite-same-level-subdomains.php';
```

Additionally, in order for sunrise.php to be loaded, you must add the following to your wp-config.php:
```php
define( 'SUNRISE', true );
```

Finally add your preferred domain into your wp-config.php:
```php
define( 'MULTISITE_SAME_LEVEL_SUBDOMAINS', true );
```

## Variables
This forces all created sites to be in the same subdomain as the main site:
```php
define( 'MULTISITE_SAME_LEVEL_SUBDOMAINS', true );
```

## Maintainers
[Onni Hakala](https://github.com/onnimonni)

## License
MIT
