<?php
/**
 * @desc TestCase.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2022/3/18 9:46
 */

declare(strict_types=1);


namespace Tinywan\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // 设置测试配置
        $this->setupTestConfig();
    }

    /**
     * 设置测试配置
     */
    protected function setupTestConfig(): void
    {
        // 模拟配置函数
        if (!function_exists('config')) {
            function config($key) {
                // Handle plugin config structure
                if ($key === 'plugin.tinywan.jwt.app.jwt') {
                    $config = require __DIR__ . '/../src/config/plugin/tinywan/jwt/app.php';
                    return $config['jwt'];
                }
                
                $config = require __DIR__ . '/config.php';
                $keys = explode('.', $key);
                $value = $config;
                
                foreach ($keys as $k) {
                    if (isset($value[$k])) {
                        $value = $value[$k];
                    } else {
                        return null;
                    }
                }
                
                return $value;
            }
        }

        // 模拟request函数
        if (!function_exists('request')) {
            function request() {
                return new class {
                    public function header($key) {
                        return 'Bearer test.token';
                    }
                    
                    public function get($key) {
                        return null;
                    }
                };
            }
        }

        // 模拟base_path函数
        if (!function_exists('base_path')) {
            function base_path() {
                return __DIR__;
            }
        }
    }
}