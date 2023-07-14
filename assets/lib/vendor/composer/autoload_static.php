<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite9e0d806dc8e5219b118e05293dd99af
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite9e0d806dc8e5219b118e05293dd99af::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite9e0d806dc8e5219b118e05293dd99af::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite9e0d806dc8e5219b118e05293dd99af::$classMap;

        }, null, ClassLoader::class);
    }
}
