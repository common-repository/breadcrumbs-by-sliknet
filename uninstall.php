<?
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option(BREADCRUMBS_SN__DOMAIN);

// for site options in Multisite
delete_site_option(BREADCRUMBS_SN__DOMAIN);