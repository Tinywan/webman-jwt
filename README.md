# webman jwt 认证插件

[![Latest Stable Version](http://poser.pugx.org/tinywan/jwt/v)](https://packagist.org/packages/tinywan/casbin)
[![Total Downloads](http://poser.pugx.org/tinywan/jwt/downloads)](https://packagist.org/packages/tinywan/casbin)
[![License](http://poser.pugx.org/tinywan/jwt/license)](https://packagist.org/packages/tinywan/casbin)
[![PHP Version Require](http://poser.pugx.org/tinywan/jwt/require/php)](https://packagist.org/packages/tinywan/casbin)
[![webman-event](https://img.shields.io/github/last-commit/tinywan/jwt/main)]()
[![webman-event](https://img.shields.io/github/v/tag/tinywan/jwt?color=ff69b4)]()


## 安装

```shell
composer require tinywan/validate
```

##  基本用法

### 生成令牌

```php
use Tinywan\Jwt\JwtToken;

$user = [
    'uid'  => 2022,
    'name'  => 'Tinywan',
    'email' => 'Tinywan@163.com'
];
$token = JwtToken::generateToken($user);
var_dump(json_encode($token));
```
输出
```json
{
    "token_type": "Bearer",
    "expires_in": 36000,
    "access_token": "eyJ0eXAiOiJAUR-Gqtnk9LUPO8IDrLK7tjCwQZ7CI...",
    "refresh_token": "eyJ0eXAiOiJIEGkKprvcccccQvsTJaOyNy8yweZc..."
}
```

#### 响应参数

| 参数|类型|是否必填|最大长度|描述|示例值|
|:---|:---|:---|:---|:---|:---|
|token_type| string | 是| 8 | Token 类型 | Bearer |
|expires_in| int | 是| 16 | 凭证有效时间，单位：秒 | 36000 |
|access_token| string | 是| 128 | 访问凭证 | XXXXXXXXXXXXXXXXXXXXXXXXXX |
|refresh_token| string | 是| 128 | 刷新凭证（访问凭证过期使用 ） | XXXXXXXXXXXXXXXXXXXXXXXXXX |

### 获取当前uid

```php
$uid = JwtToken::getCurrentId();
```

### 获取其他自定义字段

```php
$email = JwtToken::getExtendVal('email');
```

### 刷新令牌

```php
$refreshToken = JwtToken::refreshToken();
```