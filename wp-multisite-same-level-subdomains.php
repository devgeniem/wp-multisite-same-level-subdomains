<?php
/**
 * Plugin name: WP Same Level Subdomain Multisite
 * Plugin URI: https://github.com/devgeniem/wp-multisite-same-level-subdomains
 * Description: Plugin which allows your DOMAIN_CURRENT_SITE to be in the same subdomain depth as other sites
 * Author: Onni Hakala / Geniem Oy
 * Author URI: https://github.com/onnimonni
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Version: 2.2
 */

namespace Geniem\Multisite;

/**
 * This class hooks into new multisite creation process
 * and replaces the created blog with another domain
 */
class SameLevelSubdomain {

    // Only init this plugin once
    static $started = false;

    /**
     * Adds hooks into WP and creates needed settings
     */
    static function init() {

        # Only run these hooks once
        if (! self::$started) {

            // Hook into new blog creation
            add_action( 'wpmu_new_blog', [ __CLASS__, 'change_new_blog_domain_name' ], 10, 3 );

            add_action( 'network_site_new_form', [ __CLASS__, 'change_tld_with_javascript' ] );

            // Init is ready
            self::$started = true;

            // Set multisite cookies into upper level domain if this site is under the same tld
            if ( ! defined( 'COOKIE_DOMAIN' ) && self::get_multisite_tld() === self::get_upper_level_domain( $_SERVER['HTTP_HOST'] ) ) {
                define( 'COOKIE_DOMAIN', '.' . self::get_multisite_tld() );
            }
        }
    }

    /**
     * Hook into wpmu_new_blog which is run after site has been created
     *
     * @param int    $blog_id Blog ID.
     * @param int    $user_id User ID.
     * @param string $domain  Site domain.
     */
    static function change_new_blog_domain_name( int $blog_id, int $user_id, string $domain ) {

        // Parse site slug from full domain
        $slug = strtok($domain, '.');
        $new_domain = $slug . '.' . self::get_multisite_tld();

        // Replace the domain that was just created
        global $wpdb;
        $wpdb->update( $wpdb->blogs, array( 'domain' => $new_domain ), array( 'blog_id' => $blog_id ) );

        // Replace blog home & siteurl
        update_blog_option ( $blog_id, 'siteurl', 'http://' . $new_domain );
        update_blog_option ( $blog_id, 'home', 'http://' . $new_domain );
    }

    /**
     * Insert javasript snippet which changes site-new.php form tld placeholder to our custom tld
     */
    static function change_tld_with_javascript() {
        ?>
        <script async defer>
            // Replace tld placeholder
            jQuery('.form-table .form-field td span').eq(0).html('.<?php echo self::get_multisite_tld(); ?>');

            // Hack inside hack: Replace links to newly created site
            $link = jQuery('#message.updated a').eq(0);
            if ( $link.length > 0) {
                $link.attr("href", $link.attr("href").replace('<?php echo DOMAIN_CURRENT_SITE; ?>','<?php echo self::get_multisite_tld(); ?>') )
            }
        </script>
        <?php
    }

    /**
     * Parse upper level domain from DOMAIN_CURRENT_SITE
     *
     * @return string - Returns tld from multisite main site
     */
    static function get_multisite_tld() : string {

        $upper_level_domain = self::get_upper_level_domain( DOMAIN_CURRENT_SITE );

        if( DOMAIN_CURRENT_SITE !== $upper_level_domain ) {
           return $upper_level_domain;
        } else {
            // This is something like localhost and it can't be used
            throw new Exception("Error: DOMAIN_CURRENT_SITE:{$DOMAIN_CURRENT_SITE} is not valid for same level subdomain");
        }
    }

    /**
     * Returns upper level domain from subdomain
     * @param string $domain - Valid domain name
     *
     * @return - upper level domain or original domain
     */
    static private function get_upper_level_domain(string $domain) : string {
        if ( ( $pos = strpos( $domain, '.' ) ) !== false ) {
            return substr( $domain, $pos + 1 );
        } else {
            return $domain;
        }
    }
}

// Activate plugin only if this is subdomain multisite
// and if MULTISITE_CHANGE_SUBDOMAIN_TLD is defined
if ( defined('MULTISITE') and MULTISITE
     and defined('SUBDOMAIN_INSTALL') and SUBDOMAIN_INSTALL
     and defined('MULTISITE_SAME_LEVEL_SUBDOMAINS') and MULTISITE_SAME_LEVEL_SUBDOMAINS ) {
    SameLevelSubdomain::init();
}
