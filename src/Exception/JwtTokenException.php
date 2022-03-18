<?php
/**
 * @desc JwtTokenException.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2022/2/21 9:53
 */

declare(strict_types=1);

namespace Tinywan\Jwt\Exception;

use function is_array;
use function implode;

class JwtTokenException extends \RuntimeException
{
    protected $error;

    public function __construct($error)
    {
        parent::__construct();
        $this->error   = $error;
        $this->message = is_array($error) ? implode(PHP_EOL, $error) : $error;
    }

    /**
     * 获取验证错误信息
     * @access public
     * @return array|string
     */
    public function getError()
    {
        return $this->error;
    }
}
