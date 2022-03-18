<?php
/**
 * @desc RedisHanle.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2022/3/18 17:13
 */

declare(strict_types=1);

namespace Tinywan\Jwt;

use Tinywan\Jwt\Exception\JwtTokenException;
use Workerman\Redis\Client;

class RedisHandler
{
    public const JWT_TOKEN_PRE = 'JWT_TOKEN';

    /**
     * @var Client|null
     */
    protected static ?Client $instance = null;

    /**
     * @desc: 方法描述
     * @return Client|null
     * @author Tinywan(ShaoBo Wan)
     */
    public static function instance(): ?Client
    {
        if (!(static::$instance instanceof Client)) {
            $config = config('redis.default');
            $redis = new Client('redis://' . $config['host'] . ':' . $config['port']);
            $redis->auth($config['password'] ?? '');
        }
        return static::$instance;
    }

    /**
     * @desc: 生成设备缓存令牌
     * @param string $uid
     * @param string $ip
     * @param string $user
     * @return bool
     * @author Tinywan(ShaoBo Wan)
     */
    public static function generateCacheToken(string $uid, string $ip, string $user)
    {
        $cacheKey = self::JWT_TOKEN_PRE.':'.$uid;
        $keyList = self::instance()->keys($cacheKey.':*');
        if (!empty($keyList)) {
            // 登录时，判断该账号是否在其它设备登录，如果有，就请空之前key清除，
            foreach ($keyList as $key) {
                self::instance()->del($key);
            }
        }
        // 重新设置key 。然后存储用户信息和ip地址拼接为key，存储在redis当中
        return self::instance()->setex($cacheKey.':'.$ip, 3600, $user);
    }

    /**
     * @desc: 检查设备缓存令牌
     * @param string $uid
     * @param string $ip
     * @return bool
     * @author Tinywan(ShaoBo Wan)
     */
    public static function verifyeCacheToken(string $uid, string $ip)
    {
        $cacheKey = self::JWT_TOKEN_PRE.':'.$uid.':'.$ip;
        if (!self::instance()->exists($cacheKey)) {
            throw new JwtTokenException('该账号已在其他设备登录，强制下线');
        }
        return true;
    }
}
