<?php

/**
 * @desc RedisConnectionException.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2024/12/31 10:00
 */

declare(strict_types=1);

namespace Tinywan\Jwt\Exception;

class RedisConnectionException extends JwtTokenException
{
    public const ERROR_CODE = 500001;
    
    public function __construct(string $message = 'Redis连接失败', int $code = self::ERROR_CODE, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}