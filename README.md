![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)
# WP Plugin: Multisite TLD Changer

This plugin allows you to create subsites under different domain than the mainsite.

**For example:**
You want to create subdomain multisite which creates sites under `client.com` domain. Site could be `example.client.com`.
But `client.com` domain is simultaneously used elsewhere for non-WordPress site.

This can lead to tricky situation which you can fix with mercator or domain mapping. But if you only want to use `*.client.com` namespace this plugin can help you.

This plugin allows the mainsite of multisite to be in different domain like `client.your-cloud.com`.

## Installation
```
$ composer require devgeniem/wp-multisite-tld-changer
```

## Configuration
This forces the tld domain of new site to be different than the default domain:
```
define('MULTISITE_CHANGE_SUBDOMAIN_TLD', 'client.com');
```

## License
MIT