![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)
# WP Plugin: Multisite TLD Changer
[![Latest Stable Version](https://poser.pugx.org/devgeniem/wp-multisite-tld-changer/v/stable)](https://packagist.org/packages/devgeniem/wp-multisite-tld-changer) [![Total Downloads](https://poser.pugx.org/devgeniem/wp-multisite-tld-changer/downloads)](https://packagist.org/packages/devgeniem/wp-multisite-tld-changer) [![Latest Unstable Version](https://poser.pugx.org/devgeniem/wp-multisite-tld-changer/v/unstable)](https://packagist.org/packages/devgeniem/wp-multisite-tld-changer) [![License](https://poser.pugx.org/devgeniem/wp-multisite-tld-changer/license)](https://packagist.org/packages/devgeniem/wp-multisite-tld-changer)

This WordPress multisite plugin allows you to create subsites under different domain than the mainsite.

**For example:**
You want to create subdomain multisite which creates sites under `client.com` domain. Site could be `example.client.com`.
But `client.com` domain is simultaneously used elsewhere for non-WordPress site.

This can lead to tricky situation which you can fix with mercator or domain mapping.

If you want to use `*.client.com` namespace by default this plugin can help you.

This plugin allows the mainsite of multisite to be in different domain like `client.your-cloud.com`.

## Installation
```bash
$ composer require devgeniem/wp-multisite-tld-changer
```

## Configuration
This forces the tld domain of all created sites to be `client.com` instead than the default domain:
```php
define('MULTISITE_CHANGE_SUBDOMAIN_TLD', 'client.com');
```

## Maintainers
[Onni Hakala](https://github.com/onnimonni)

## License
MIT
