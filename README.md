![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)
# WP Plugin: Multisite TLD Changer
[![Latest Stable Version](https://poser.pugx.org/devgeniem/wp-multisite-tld-changer/v/stable)](https://packagist.org/packages/devgeniem/wp-multisite-tld-changer) [![Total Downloads](https://poser.pugx.org/devgeniem/wp-multisite-tld-changer/downloads)](https://packagist.org/packages/devgeniem/wp-multisite-tld-changer) [![Latest Unstable Version](https://poser.pugx.org/devgeniem/wp-multisite-tld-changer/v/unstable)](https://packagist.org/packages/devgeniem/wp-multisite-tld-changer) [![License](https://poser.pugx.org/devgeniem/wp-multisite-tld-changer/license)](https://packagist.org/packages/devgeniem/wp-multisite-tld-changer)

This WordPress multisite plugin allows you to create subsites under different domain than the mainsite.

This plugin allows the mainsite of multisite to be like `client.your-domain.com` and subsites to be under a different domain like `site.client.com`.

## Example use case

We needed to create subdomain multisite which uses subdomains under `client.com` domain for example `site.client.com`.
In this case `client.com` domain was simultaneously used elsewhere for non-WordPress site so that couldn't be the domain of the main site.

We created this plugin in order to use custom domain for the main site and to allow client to automatically create new sites into `*.client.com` namespace.

## Installation
```bash
$ composer require devgeniem/wp-multisite-tld-changer
```

## Configuration
We recommend installing this plugin with composer or dropping it the plugin directory into your mu-plugins directory.

Then create a wp-content/sunrise.php file with the following:

```php
<?php
// Default mu-plugins directory if you haven't set it
defined( 'WPMU_PLUGIN_DIR' ) or define( 'WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins' );

require WPMU_PLUGIN_DIR . '/wp-multisite-tld-changer/wp-multisite-tld-changer.php';
```

Additionally, in order for sunrise.php to be loaded, you must add the following to your wp-config.php:
```php
define('SUNRISE', true);
```

Finally add your preferred domain into your wp-config.php:
```php
define('MULTISITE_CHANGE_SUBDOMAIN_TLD', 'client.com');
```

## Variables
This forces the tld domain of all created sites to be `client.com` instead than the default domain:
```php
define('MULTISITE_CHANGE_SUBDOMAIN_TLD', 'client.com');
```

## Requirements
This uses [layershifter/tld-extract](https://github.com/layershifter/TLDExtract) which needs [PHP intl extension](http://php.net/manual/en/book.intl.php).

## Maintainers
[Onni Hakala](https://github.com/onnimonni)

## License
MIT
