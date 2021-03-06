<?php
/**
 * Purge Site Cache.
 *
 * @since      1.0.0
 * @package    Migrate WP Cron to Action Scheduler
 * @subpackage Mwpcac\Base
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Mwpcac\Core;

use Mwpcac\Helpers\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Site cache class.
 */
class SiteCache
{
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'mwpcac/after_plugin_activate', 'purge_site_cache', 20 );
		$this->action( 'mwpcac/after_plugin_deactivate', 'purge_site_cache', 20 );
	}

	/**
	 * Purge site cache.
	 */
	public function purge_site_cache()
	{
		# WordPress default cache
		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}
			
		# Purge all W3 Total Cache
		if ( function_exists( 'w3tc_pgcache_flush' ) ) {
			w3tc_pgcache_flush();
		}
		
		# Purge WP Super Cache
		if ( function_exists( 'wp_cache_clear_cache' ) ) {
			wp_cache_clear_cache();
		}
		
		# Purge WP Rocket
		if ( function_exists( 'rocket_clean_domain' ) ) {
			rocket_clean_domain();
		}
		
		# Purge Wp Fastest Cache
		if( function_exists( 'wpfc_clear_all_cache' ) ) {
			wpfc_clear_all_cache( true );
		}
		
		# Purge Cachify
		if ( function_exists( 'cachify_flush_cache' ) ) {
			cachify_flush_cache();
		}
		
		# Purge Comet Cache
		if ( class_exists( 'comet_cache' ) && method_exists( 'comet_cache', 'clearPost' ) ) {
			\comet_cache::clear();
		}
		
		# Purge Zen Cache
		if ( class_exists( 'zencache' ) && method_exists( 'zencache', 'clearPost' ) ) {
			\zencache::clear();
		}
		
		# Purge LiteSpeed Cache 
		if( class_exists( 'LiteSpeed_Cache_API' ) && method_exists( 'LiteSpeed_Cache_API', 'purge_all' ) ) {
			\LiteSpeed_Cache_API::purge_all();
		}
		
		# Purge Cache Enabler
		if ( has_action( 'ce_clear_cache' ) ) {
			\do_action( 'ce_clear_cache' );
		}

		# Purge Hyper Cache
		if ( class_exists( 'HyperCache' ) ) {
			$hC = new \HyperCache;
			if ( method_exists( $hC, 'clean' ) ) {
			    $hC->clean();
			}
		}

		# Purge Autoptimize Cache
		if ( class_exists( 'autoptimizeCache' ) && method_exists( 'autoptimizeCache', 'clearall' ) ) {
			\autoptimizeCache::clearall();
		}	
		
		# Purge SG Optimizer
	    if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
	    	sg_cachepress_purge_cache();
	    }
	    
	    # Purge Breeze Cache
	    if ( class_exists( 'Breeze_PurgeCache' ) && method_exists( 'Breeze_PurgeCache', 'breeze_cache_flush' ) ) {
	    	\Breeze_PurgeCache::breeze_cache_flush();
	    }
	
		# Purge Swift Cache
	    if ( class_exists( 'Swift_Performance_Cache' ) && method_exists( 'Swift_Performance_Cache', 'clear_all_cache' ) ) {
	    	\Swift_Performance_Cache::clear_all_cache();
	    }
	}
}