<?php

/**
 * @desc RedisHanle.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2022/3/18 17:13
 */

declare(strict_types=1);

namespace Tinywan\Jwt;

use support\Redis;
use Tinywan\Jwt\Exception\JwtCacheTokenException;
use Tinywan\Jwt\Exception\RedisConnectionException;
use RedisException;

class RedisHandler
{
    /**
     * @desc: 检查Redis连接状态
     * @throws RedisConnectionException 当Redis连接失败时抛出异常
     */
    private static function checkConnection()
    {
        try {
            if (!Redis::ping()) {
                throw new RedisConnectionException('Redis连接不可用');
            }
        } catch (RedisException $e) {
            throw new RedisConnectionException('Redis连接失败: ' . $e->getMessage());
        }
    }

    /**
     * @desc: 生成缓存键名
     * @param string $pre 键前缀
     * @param string $client 客户端类型
     * @param string $uid 用户ID
     * @return string 完整的缓存键名
     */
    private static function generateKey(string $pre, string $client, string $uid)
    {
        return sprintf('%s%s:%s', $pre, $client, $uid);
    }

    /**
     * @desc: 安全执行Redis操作
     * @param callable $callback Redis操作回调函数
     * @return mixed 回调函数执行结果
     * @throws RedisConnectionException
     */
    private static function safeExecute(callable $callback)
    {
        self::checkConnection();
        
        try {
            return $callback();
        } catch (RedisException $e) {
            throw new RedisConnectionException('Redis操作失败: ' . $e->getMessage());
        }
    }
    /**
     * @desc: 生成缓存令牌
     * （1）登录时，判断该账号是否在其它设备登录，如果有，就请空之前key清除，
     * （2）重新设置key，然后存储用户信息在redis当中
     * @param string $pre
     * @param string $client
     * @param string $uid
     * @param int $ttl
     * @param string $token
     * @throws RedisConnectionException
     * @author Tinywan(ShaoBo Wan)
     */
    public static function generateToken(string $pre, string $client, string $uid, int $ttl, string $token)
    {
        self::validateRedisParams($ttl, $token);
        $cacheKey = self::generateKey($pre, $client, $uid);
        
        self::safeExecute(function() use ($cacheKey, $ttl, $token) {
            Redis::del($cacheKey);
            $result = Redis::setex($cacheKey, $ttl, $token);
            
            if (!$result) {
                throw new RedisConnectionException('Redis设置令牌失败');
            }
        });
    }


    /**
     * @desc: 刷新存储的缓存令牌
     * @param string $pre
     * @param string $client
     * @param string $uid
     * @param int $ttl
     * @param string $token
     * @throws RedisConnectionException
     * @return void
     */
    public static function refreshToken(string $pre, string $client, string $uid, int $ttl, string $token)
    {
        self::validateRedisParams($ttl, $token);
        $cacheKey = self::generateKey($pre, $client, $uid);
        
        self::safeExecute(function() use ($cacheKey, $ttl, $token) {
            $isExists = Redis::exists($cacheKey);
            if ($isExists) {
                $currentTtl = Redis::ttl($cacheKey);
                if ($currentTtl > 0) {
                    $ttl = $currentTtl;
                }
            }
            
            $result = Redis::setex($cacheKey, $ttl, $token);
            if (!$result) {
                throw new RedisConnectionException('Redis刷新令牌失败');
            }
        });
    }

    /**
     * @desc: 检查设备缓存令牌
     * @param string $pre
     * @param string $client
     * @param string $uid
     * @param string $token
     * @return bool
     * @throws RedisConnectionException
     * @throws JwtCacheTokenException
     * @author Tinywan(ShaoBo Wan)
     */
    public static function verifyToken(string $pre, string $client, string $uid, string $token): bool
    {
        if (empty($token)) {
            throw new \InvalidArgumentException('Token不能为空');
        }

        $cacheKey = self::generateKey($pre, $client, $uid);
        
        return self::safeExecute(function() use ($cacheKey, $token) {
            if (!Redis::exists($cacheKey)) {
                throw new JwtCacheTokenException('身份验证会话已过期，请再次登录！');
            }
            
            $cachedToken = Redis::get($cacheKey);
            if ($cachedToken === false) {
                throw new RedisConnectionException('Redis获取令牌失败');
            }
            
            if ($cachedToken != $token) {
                throw new JwtCacheTokenException('该账号已在其他设备登录，强制下线');
            }
            
            return true;
        });
    }

    /**
     * @desc: 清理缓存令牌
     * @param string $pre
     * @param string $client
     * @param string $uid
     * @return bool
     * @throws RedisConnectionException
     * @author Tinywan(ShaoBo Wan)
     */
    public static function clearToken(string $pre, string $client, string $uid): bool
    {
        $cacheKey = self::generateKey($pre, $client, $uid);
        
        return self::safeExecute(function() use ($cacheKey) {
            $result = Redis::del($cacheKey);
            if ($result === false) {
                throw new RedisConnectionException('Redis清理令牌失败');
            }
            return true;
        });
    }

    /**
     * @desc: 验证Redis操作参数
     * @param int $ttl 过期时间
     * @param string $token 令牌
     * @throws \InvalidArgumentException
     */
    private static function validateRedisParams(int $ttl, string $token): void
    {
        if ($ttl <= 0) {
            throw new \InvalidArgumentException('TTL必须大于0');
        }
        
        if (empty($token)) {
            throw new \InvalidArgumentException('Token不能为空');
        }
    }

    /**
     * @desc: 检查Redis是否可用
     * @return bool Redis是否可用
     */
    public static function isAvailable(): bool
    {
        try {
            return Redis::ping() === true;
        } catch (RedisException $e) {
            return false;
        }
    }
}
