<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitee67329dc2c9a1fba4e9055bcdd53818
{
    public static $files = array (
        'a5f882d89ab791a139cd2d37e50cdd80' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
        '4cfe55868654b2ea9298a46af9d2b853' => __DIR__ . '/..' . '/jtsternberg/shortcode-button/shortcode-button.php',
    );

    public static $classMap = array (
        'Shortcode_Button_107' => __DIR__ . '/..' . '/jtsternberg/shortcode-button/shortcode-button.php',
        'TGMPA_Bulk_Installer' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
        'TGMPA_Bulk_Installer_Skin' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
        'TGMPA_List_Table' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
        'TGMPA_Utils' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
        'TGM_Bulk_Installer' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
        'TGM_Bulk_Installer_Skin' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
        'TGM_Plugin_Activation' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
        'WDS_Shortcode' => __DIR__ . '/../..' . '/includes/shortcode.php',
        'WDS_Shortcode_Admin' => __DIR__ . '/../..' . '/includes/shortcode-admin.php',
        'WDS_Shortcode_Instances' => __DIR__ . '/../..' . '/includes/shortcode-instances.php',
        'WDS_Shortcodes' => __DIR__ . '/../..' . '/includes/shortcodes.php',
        'WDS_Shortcodes_Base' => __DIR__ . '/../..' . '/includes/init.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitee67329dc2c9a1fba4e9055bcdd53818::$classMap;

        }, null, ClassLoader::class);
    }
}
