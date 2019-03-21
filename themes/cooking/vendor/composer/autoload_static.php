<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit51b523f56e298134d109fbc73bbc4aba
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'GS\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'GS\\' => 
        array (
            0 => __DIR__ . '/../..' . '/config',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit51b523f56e298134d109fbc73bbc4aba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit51b523f56e298134d109fbc73bbc4aba::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
