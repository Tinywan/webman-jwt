<?php

namespace Tinywan\Jwt;

class Install
{
    public const WEBMAN_PLUGIN = true;
    private const ACCESS_PLACEHOLDER = '__JWT_ACCESS_SECRET_KEY__';
    private const REFRESH_PLACEHOLDER = '__JWT_REFRESH_SECRET_KEY__';

    /**
     * @var array
     */
    protected static $pathRelation = array(
  'config/plugin/tinywan/jwt' => 'config/plugin/tinywan/jwt',
);

    /**
     * Install
     * @return void
     */
    public static function install()
    {
        static::installByRelation();
    }

    /**
     * Uninstall
     * @return void
     */
    public static function uninstall()
    {
        self::uninstallByRelation();
    }

    /**
     * installByRelation
     * @return void
     */
    public static function installByRelation()
    {
        foreach (static::$pathRelation as $source => $dest) {
            if ($pos = strrpos($dest, '/')) {
                $parent_dir = base_path().'/'.substr($dest, 0, $pos);
                if (!is_dir($parent_dir)) {
                    mkdir($parent_dir, 0777, true);
                }
            }
            //symlink(__DIR__ . "/$source", base_path()."/$dest");
            copy_dir(__DIR__ . "/$source", base_path()."/$dest");
            self::initJwtSecrets(base_path()."/$dest/app.php");
        }
    }

    /**
     * 安装时初始化JWT密钥（64位随机字符串）
     * @param string $configFile
     * @return void
     */
    protected static function initJwtSecrets(string $configFile): void
    {
        if (!is_file($configFile) || !is_readable($configFile) || !is_writable($configFile)) {
            return;
        }

        $content = file_get_contents($configFile);
        if (!is_string($content) || $content === '') {
            return;
        }

        if (strpos($content, self::ACCESS_PLACEHOLDER) === false && strpos($content, self::REFRESH_PLACEHOLDER) === false) {
            return;
        }

        try {
            $accessKey = bin2hex(random_bytes(32));
            $refreshKey = bin2hex(random_bytes(32));
        } catch (\Exception $e) {
            return;
        }

        $updated = str_replace(
            [self::ACCESS_PLACEHOLDER, self::REFRESH_PLACEHOLDER],
            [$accessKey, $refreshKey],
            $content
        );

        if ($updated !== $content) {
            file_put_contents($configFile, $updated);
        }
    }

    /**
     * uninstallByRelation
     * @return void
     */
    public static function uninstallByRelation()
    {
        foreach (static::$pathRelation as $source => $dest) {
            $path = base_path()."/$dest";
            if (!is_dir($path) && !is_file($path)) {
                continue;
            }
            /*if (is_link($path) {
                unlink($path);
            }*/
            remove_dir($path);
        }
    }
}
