<?php
/**
 * Plugin name: WP Multisite TLD Changer
 * Plugin URI: https://github.com/devgeniem/wp-multisite-tld-changer
 * Description: Plugin which allows your subdomain multisite main domain TLD to be different than subdomain TLD
 * Author: Onni Hakala / Geniem Oy
 * Author URI: https://github.com/onnimonni
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Version: 1.0
 */

namespace Geniem\Multisite;

// Useful library for parsing domains the right way
use LayerShifter\TLDExtract\Extract;

/**
 * This class hooks into new multisite creation process
 * and replaces the created blog with another domain
 */
class TLDChanger {
    /**
     * Adds hooks into WP and creates needed settings
     */
    static function init() {
        $current_tld = self::get_tld( $_SERVER['HTTP_HOST'] );
        $default_tld = self::get_tld( DOMAIN_CURRENT_SITE );

        // Override cookie domain for domains which are not under DOMAIN_CURRENT_SITE
        if ( $current_tld !=  $default_tld ) {
            define( 'COOKIE_DOMAIN', '.' . $current_tld );
        }

        // Hook into new blog creation
        add_action( 'wpmu_new_blog', [ __CLASS__, 'change_new_blog_domain_name' ], 10, 3 );

        add_action( 'network_site_new_form', [ __CLASS__, 'change_tld_with_javascript' ] );
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
        $slug = explode('.', $domain )[0];
        $new_domain = $slug . '.' . MULTISITE_CHANGE_SUBDOMAIN_TLD;

        // Replace the domain that was just created
        global $wpdb;
        $wpdb->update( $wpdb->blogs, array( 'domain' => $new_domain ), array( 'blog_id' => $blog_id ) );
    }

    /**
     * Insert javasript snippet which changes site-new.php form tld placeholder to our custom tld
     */
    static function change_tld_with_javascript() {
        ?>
        <script async defer>
            // Replace tld placeholder
            jQuery('.form-table .form-field td span').eq(0).html('.<?php echo MULTISITE_CHANGE_SUBDOMAIN_TLD; ?>');

            // Hack inside hack: Replace links to newly created site
            $link = jQuery('#message.updated a').eq(0);
            if ( $link.length > 0) {
                $link.attr("href", $link.attr("href").replace('<?php echo DOMAIN_CURRENT_SITE; ?>','<?php echo MULTISITE_CHANGE_SUBDOMAIN_TLD; ?>') )
            }
        </script>
        <?php
    }

    /**
     * Parse tld from $domain
     * This uses LayerShifter\TLDExtract\Extract library
     *
     * @param string $domain
     * @return string - Returns tld from current Host header
     */
    static function get_tld( string $domain ) : string {

        // Use layershifter/tld-extract installed with composer to parse top level domain
        $extract = new Extract();
        $result = $extract->parse( $domain );

        return $result->getRegistrableDomain();
    }
}

// Activate plugin only if this is subdomain multisite
// and if MULTISITE_CHANGE_SUBDOMAIN_TLD is defined
if ( defined('MULTISITE') and MULTISITE
     and defined('SUBDOMAIN_INSTALL') and SUBDOMAIN_INSTALL
     and defined('MULTISITE_CHANGE_SUBDOMAIN_TLD') and ! empty(MULTISITE_CHANGE_SUBDOMAIN_TLD) ) {
    TLDChanger::init();
}
