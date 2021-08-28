<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4c3823fb71ada93ace922c324a726186
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4c3823fb71ada93ace922c324a726186::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4c3823fb71ada93ace922c324a726186::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4c3823fb71ada93ace922c324a726186::$classMap;

        }, null, ClassLoader::class);
    }
}
