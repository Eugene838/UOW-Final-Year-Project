<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8c1d4aa22372f7912e945a0883c5360d
{
    public static $prefixesPsr0 = array (
        'c' => 
        array (
            'classmap' => 
            array (
                0 => __DIR__ . '/../..' . '/',
            ),
        ),
        'M' => 
        array (
            'Mail' => 
            array (
                0 => __DIR__ . '/../..' . '/',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit8c1d4aa22372f7912e945a0883c5360d::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit8c1d4aa22372f7912e945a0883c5360d::$classMap;

        }, null, ClassLoader::class);
    }
}
