<?php

// autoload_real_52.php generated by xrstf/composer-php52

class ComposerAutoloaderInitc66d97086369af13e42e41d7ada0bfce {
	private static $loader;

	public static function loadClassLoader($class) {
		if ('xrstf_Composer52_ClassLoader' === $class) {
			require dirname(__FILE__).'/ClassLoader52.php';
		}
	}

	/**
	 * @return xrstf_Composer52_ClassLoader
	 */
	public static function getLoader() {
		if (null !== self::$loader) {
			return self::$loader;
		}

		spl_autoload_register(array('ComposerAutoloaderInitc66d97086369af13e42e41d7ada0bfce', 'loadClassLoader'), true /*, true */);
		self::$loader = $loader = new xrstf_Composer52_ClassLoader();
		spl_autoload_unregister(array('ComposerAutoloaderInitc66d97086369af13e42e41d7ada0bfce', 'loadClassLoader'));

		$vendorDir = dirname(dirname(__FILE__));
		$baseDir   = dirname($vendorDir);
		$dir       = dirname(__FILE__);

		$map = require $dir.'/autoload_namespaces.php';
		foreach ($map as $namespace => $path) {
			$loader->add($namespace, $path);
		}

		$classMap = require $dir.'/autoload_classmap.php';
		if ($classMap) {
			$loader->addClassMap($classMap);
		}

		$loader->register(true);

		require $vendorDir . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php';
		require $vendorDir . '/jtsternberg/cmb2-related-links/cmb2-related-links.php';
		require $vendorDir . '/jtsternberg/cmb2-term-select/cmb2-term-select.php';
		require $vendorDir . '/webdevstudios/cmb2-user-select/cmb2-user-select.php';
		require $vendorDir . '/webdevstudios/cpt-core/CPT_Core.php';
		require $vendorDir . '/webdevstudios/taxonomy_core/Taxonomy_Core.php';
		require $vendorDir . '/webdevstudios/wds-shortcodes/vendor/jtsternberg/shortcode-button/shortcode-button.php';
		require $vendorDir . '/webdevstudios/cmb2-user-select/cmb2-user-select.php';
		require $vendorDir . '/webdevstudios/cmb2-post-search-field/cmb2_post_search_field.php';
		require $vendorDir . '/jtsternberg/cmb2-related-links/cmb2-related-links.php';
		require $vendorDir . '/jtsternberg/cmb2-term-select/cmb2-term-select.php';
		require $vendorDir . '/webdevstudios/wds-shortcodes/wds-shortcodes.php';
		require $vendorDir . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php';

		return $loader;
	}
}
