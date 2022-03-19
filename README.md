# JSON Web Token (JWT) for webman plugin

[![Total Downloads](http://poser.pugx.org/tinywan/jwt/downloads)](https://packagist.org/packages/tinywan/jwt)
[![License](http://poser.pugx.org/tinywan/jwt/license)](https://packagist.org/packages/tinywan/jwt) 
[![webman-jwt](https://img.shields.io/github/last-commit/tinywan/jwt/main)]()
[![webman-jwt](https://img.shields.io/github/v/tag/tinywan/jwt?color=ff69b4)]()

> Json web token (JWT), 是为了在网络应用环境间传递声明而执行的一种基于JSON的开放标准（(RFC 7519).该token被设计为紧凑且安全的，特别适用于分布式站点的单点登录（SSO）场景。

JWT的声明一般被用来在身份提供者和服务提供者间传递被认证的用户身份信息，以便于从资源服务器获取资源，也可以增加一些额外的其它业务逻辑所必须的声明信息，该token也可直接被用于认证，也可被加密。

## 认证&授权流程

![image](https://user-images.githubusercontent.com/14959876/159104533-f51f0a57-e085-44ab-84d7-363a4bb1eda9.png)

## 签名流程

1. 用户使用用户名和口令到认证服务器上请求认证。
2. 认证服务器验证用户名和口令后，以服务器端生成JWT Token，这个token的生成过程如下：
  	- 认证服务器还会生成一个 Secret Key（密钥）
 	- 对JWT Header和JWT Payload分别求Base64。在Payload可能包括了用户的抽象ID和的过期时间。
  	- 用密钥对JWT签名 `HMAC-SHA256(SecertKey, Base64UrlEncode(JWT-Header)+'.'+Base64UrlEncode(JWT-Payload))`	
3. 然后把 base64(header).base64(payload).signature 作为 JWT token返回客户端。
4. 客户端使用JWT Token向应用服务器发送相关的请求。这个JWT Token就像一个临时用户权证一样。

## 安装

```shell
composer require tinywan/jwt
```

## 使用

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

**输出（json格式）**
```json
{
    "token_type": "Bearer",
    "expires_in": 36000,
    "access_token": "eyJ0eXAiOiJAUR-Gqtnk9LUPO8IDrLK7tjCwQZ7CI...",
    "refresh_token": "eyJ0eXAiOiJIEGkKprvcccccQvsTJaOyNy8yweZc..."
}
```

**响应参数**

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

## 加密算法

> Generate RS512, RS384 and RS256 keys

### RS512

```php
ssh-keygen -t rsa -b 4096 -E SHA512 -m PEM -P "" -f RS512.key
openssl rsa -in RS512.key -pubout -outform PEM -out RS512.key.pub
```

### RS512

```php
ssh-keygen -t rsa -b 4096 -E SHA354 -m PEM -P "" -f RS384.key
openssl rsa -in RS384.key -pubout -outform PEM -out RS384.key.pub
```

### RS256

```php
ssh-keygen -t rsa -b 4096 -E SHA256 -m PEM -P "" -f RS256.key
openssl rsa -in RS256.key -pubout -outform PEM -out RS256.key.pub
```

## 🚀 视频地址

不懂的同学可以了解一下视频，会有详细的说明哦

- 如何使用 JWT 认证插件：https://www.bilibili.com/video/BV1HS4y1F7Jx
- 如何使用 JWT 认证插件（算法篇）：https://www.bilibili.com/video/BV14L4y1g7sY
