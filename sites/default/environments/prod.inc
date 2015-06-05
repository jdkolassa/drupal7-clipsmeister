<?php
$conf['page_cache_invoke_hooks'] = FALSE;
$conf['reverse_proxy'] = TRUE;
$conf['omit_vary_cookie'] = TRUE;
$conf['cache'] = 1;
$conf['cache_lifetime'] = 0;
$conf['page_cache_maximum_age'] = 3600;
$conf['reverse_proxy_addresses'] = array('10.223.176.204');

$conf['redis_client_interface'] = 'PhpRedis'; // Can be "Predis".
$conf['redis_client_host']      = '10.223.176.122';  // Your Redis instance hostname.
$conf['lock_inc']               = 'sites/all/modules/redis/redis.lock.inc';
$conf['cache_backends'][]       = 'sites/all/modules/redis/redis.autoload.inc';
$conf['cache_default_class']    = 'Redis_Cache';
$conf['cache_prefix'] = 'www.cato.org_';

# Keep forms in persistent storage, as per discussed at the beginning
$conf['cache_class_cache_form'] = 'DrupalDatabaseCache';
# I don't see any point in keeping the module update information in Memcached
$conf['cache_class_cache_update'] = 'DrupalDatabaseCache';

// Add Varnish as the page cache handler.
$conf['cache_backends'][] = 'sites/all/modules/varnish/varnish.cache.inc';
$conf['cache_class_cache_page'] = 'VarnishCache';
