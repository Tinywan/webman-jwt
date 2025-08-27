<?php
/**
 * @desc JwtTokenTest.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2022/2/24 10:04
 */


namespace Tinywan\Tests;


use Tinywan\Jwt\JwtToken;
use Tinywan\Jwt\RedisHandler;
use Tinywan\Jwt\Exception\RedisConnectionException;

// 定义测试环境常量
define('PHPUNIT_RUNNING', true);

class JwtTokenTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testGenerateToken()
    {
        $user = [
            'id'  => 2022,
            'name'  => 'Tinywan',
            'email' => 'Tinywan@163.com'
        ];
        $token = JwtToken::generateToken($user);
        $this->assertIsArray($token);
        $this->assertArrayHasKey('token_type', $token);
        $this->assertArrayHasKey('access_token', $token);
        $this->assertEquals('Bearer', $token['token_type']);
    }

    public function testRedisAvailability()
    {
        // 在测试环境中，Redis应该返回不可用
        $isAvailable = RedisHandler::isAvailable();
        $this->assertIsBool($isAvailable);
        $this->assertFalse($isAvailable);
    }

    public function testGetCurrentId()
    {
        // 这个测试需要有效的JWT token，所以我们测试异常情况
        $this->expectException(\Tinywan\Jwt\Exception\JwtTokenException::class);
        JwtToken::getCurrentId();
    }

    public function testGetUser()
    {
        // 这个测试需要有效的JWT token，所以我们测试异常情况
        $this->expectException(\Tinywan\Jwt\Exception\JwtTokenException::class);
        JwtToken::getUser();
    }

    public function testGetExtend()
    {
        // 这个测试需要有效的JWT token，所以我们测试异常情况
        $this->expectException(\Tinywan\Jwt\Exception\JwtTokenException::class);
        JwtToken::getExtend();
    }

    public function testGenerateTokenWithMissingId()
    {
        $this->expectException(\Tinywan\Jwt\Exception\JwtTokenException::class);
        $this->expectExceptionMessage('缺少全局唯一字段：id');
        
        $user = [
            'name'  => 'Tinywan',
            'email' => 'Tinywan@163.com'
        ];
        JwtToken::generateToken($user);
    }

    public function testGenerateTokenWithCustomExp()
    {
        $user = [
            'id'  => 2022,
            'name'  => 'Tinywan',
            'email' => 'Tinywan@163.com',
            'access_exp' => 1800 // 30分钟
        ];
        $token = JwtToken::generateToken($user);
        $this->assertIsArray($token);
        $this->assertArrayHasKey('expires_in', $token);
        $this->assertEquals(1800, $token['expires_in']);
    }

    public function testClearToken()
    {
        // 测试清理令牌方法（在非单设备模式下应该返回true）
        $result = JwtToken::clear();
        $this->assertTrue($result);
    }

    public function testGetTokenExp()
    {
        // 这个测试需要有效的JWT token，所以我们测试异常情况
        $this->expectException(\Tinywan\Jwt\Exception\JwtTokenException::class);
        JwtToken::getTokenExp();
    }

    public function testVerifyToken()
    {
        // 这个测试需要有效的JWT token，所以我们测试异常情况
        $this->expectException(\Tinywan\Jwt\Exception\JwtTokenException::class);
        JwtToken::verify();
    }
}