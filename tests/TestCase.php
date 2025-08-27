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
        // 强制定义config函数，确保在测试前可用
        $this->defineConfigFunction();
        
        // 强制定义request函数，确保在测试前可用
        $this->defineRequestFunction();
        
        // 强制定义base_path函数，确保在测试前可用
        $this->defineBasePathFunction();
    }

    /**
     * 定义config函数
     */
    protected function defineConfigFunction(): void
    {
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
    }

    /**
     * 定义request函数
     */
    protected function defineRequestFunction(): void
    {
        if (!function_exists('request')) {
            function request() {
                return new class {
                    public function header($key) {
                        // 返回null，让JWT验证失败并抛出预期的异常
                        return null;
                    }
                    
                    public function get($key) {
                        return null;
                    }
                };
            }
        }
    }

    /**
     * 定义base_path函数
     */
    protected function defineBasePathFunction(): void
    {
        if (!function_exists('base_path')) {
            function base_path() {
                return __DIR__;
            }
        }
    }
}