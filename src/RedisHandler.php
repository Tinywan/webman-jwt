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

class RedisHandler
{
    /**
     * @desc: 生成缓存令牌
     * （1）登录时，判断该账号是否在其它设备登录，如果有，就请空之前key清除，
     * （2）重新设置key，然后存储用户信息在redis当中
     * @param string $pre
     * @param string $client
     * @param string $uid
     * @param int $ttl
     * @param string $token
     * @author Tinywan(ShaoBo Wan)
     */
    public static function generateToken(string $pre, string $client, string $uid, int $ttl, string $token): void
    {
        $cacheKey = $pre . $client. ':'. $uid;
        Redis::del($cacheKey);
        Redis::setex($cacheKey, $ttl, $token);
    }


    /**
     * @desc: 刷新存储的缓存令牌
     * @param string $pre
     * @param string $client
     * @param string $uid
     * @param int $ttl
     * @param string $token
     * @return void
     */
    public static function refreshToken(string $pre, string $client, string $uid, int $ttl, string $token): void
    {
        $cacheKey = $pre . $client . ':' . $uid;
        $isExists = Redis::exists($cacheKey);
        if ($isExists) {
            $ttl = Redis::ttl($cacheKey);
        }
        Redis::setex($cacheKey, $ttl, $token);
    }

    /**
     * @desc: 检查设备缓存令牌
     * @param string $pre
     * @param string $client
     * @param string $uid
     * @param string $token
     * @return bool
     * @author Tinywan(ShaoBo Wan)
     */
    public static function verifyToken(string $pre, string $client, string $uid, string $token): bool
    {
        $cacheKey = $pre . $client. ':'. $uid;
        if (!Redis::exists($cacheKey)) {
            throw new JwtCacheTokenException('该账号已在其他设备登录，强制下线');
        }
        if (Redis::get($cacheKey) != $token) {
            throw new JwtCacheTokenException('身份验证会话已过期，请再次登录！');
        }
        return true;
    }

    /**
     * @desc: 清理缓存令牌
     * @param string $pre
     * @param string $client
     * @param string $uid
     * @return bool
     * @author Tinywan(ShaoBo Wan)
     */
    public static function clearToken(string $pre, string $client, string $uid): bool
    {
        Redis::del($pre . $client. ':'. $uid);
        return true;
    }
}
