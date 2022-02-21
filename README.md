# webman jwt 认证插件

[![Latest Stable Version](http://poser.pugx.org/tinywan/jwt/v)](https://packagist.org/packages/tinywan/casbin)
[![Total Downloads](http://poser.pugx.org/tinywan/jwt/downloads)](https://packagist.org/packages/tinywan/casbin)
[![License](http://poser.pugx.org/tinywan/jwt/license)](https://packagist.org/packages/tinywan/casbin)
[![webman-event](https://img.shields.io/github/last-commit/tinywan/jwt/main)]()
[![webman-event](https://img.shields.io/github/v/tag/tinywan/jwt?color=ff69b4)]()

Json web token (JWT), 是为了在网络应用环境间传递声明而执行的一种基于JSON的开放标准（(RFC 7519).该token被设计为紧凑且安全的，特别适用于分布式站点的单点登录（SSO）场景。

JWT的声明一般被用来在身份提供者和服务提供者间传递被认证的用户身份信息，以便于从资源服务器获取资源，也可以增加一些额外的其它业务逻辑所必须的声明信息，该token也可直接被用于认证，也可被加密。

## 安装

```shell
composer require tinywan/jwt
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

##### 输出（Json）
```json
{
    "token_type": "Bearer",
    "expires_in": 36000,
    "access_token": "eyJ0eXAiOiJAUR-Gqtnk9LUPO8IDrLK7tjCwQZ7CI...",
    "refresh_token": "eyJ0eXAiOiJIEGkKprvcccccQvsTJaOyNy8yweZc..."
}
```

##### 响应参数

| 参数|类型|描述|示例值|
|:---|:---|:---|:---|
|token_type| string |Token 类型 | Bearer |
|expires_in| int |凭证有效时间，单位：秒 | 36000 |
|access_token| string |访问凭证 | XXXXXXXXXXXXXXXXXXXX|
|refresh_token| string | 刷新凭证（访问凭证过期使用 ） | XXXXXXXXXXXXXXXXXXX|

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