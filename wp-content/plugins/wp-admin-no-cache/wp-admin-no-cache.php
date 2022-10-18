<?php
/*
Plugin Name: WP Admin no cache
Plugin URI: http://sominus.net/wp-admin-no-cache/
Description: The plugin disables browser caching in an updated version of WordPress 4.6.*
Version: 1.0.0
Author: Vladimir Yakovlev
Author URI: http://sominus.net
*/

$WPAdminNoCache = new WPAdminNoCache();
$WPAdminNoCache->init();

class WPAdminNoCache {    
    public function init() {
        add_filter('nocache_headers', array($this, 'addHeader'));
    }
    
    public function addHeader($headers) {
        $headers['Pragma'] = 'no-cache';
        return $headers;
    }
}