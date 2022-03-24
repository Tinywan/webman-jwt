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

## 支持函数列表

> 1、获取当前`uid`

```php
$uid = JwtToken::getCurrentId();
```

> 2、获取所有字段

```php
$email = JwtToken::getExtend();
```

> 3、获取自定义字段

```php
$email = JwtToken::getExtendVal('email');
```

> 4、刷新令牌（通过刷新令牌获取访问令牌）

```php
$refreshToken = JwtToken::refreshToken();
```

> 5、获令牌有效期剩余时长

```php
$exp = JwtToken::getTokenExp();
```

## 签名算法

JWT 最常见的几种签名算法(JWA)：`HS256(HMAC-SHA256)` 、`RS256(RSA-SHA256)` 还有 `ES256(ECDSA-SHA256)`

**JWT 算法列表如下**
```
+--------------+-------------------------------+--------------------+
   | "alg" Param  | Digital Signature or MAC      | Implementation     |
   | Value        | Algorithm                     | Requirements       |
   +--------------+-------------------------------+--------------------+
   | HS256        | HMAC using SHA-256            | Required           |
   | HS384        | HMAC using SHA-384            | Optional           |
   | HS512        | HMAC using SHA-512            | Optional           |
   | RS256        | RSASSA-PKCS1-v1_5 using       | Recommended        |
   |              | SHA-256                       |                    |
   | RS384        | RSASSA-PKCS1-v1_5 using       | Optional           |
   |              | SHA-384                       |                    |
   | RS512        | RSASSA-PKCS1-v1_5 using       | Optional           |
   |              | SHA-512                       |                    |
   | ES256        | ECDSA using P-256 and SHA-256 | Recommended+       |
   | ES384        | ECDSA using P-384 and SHA-384 | Optional           |
   | ES512        | ECDSA using P-521 and SHA-512 | Optional           |
   | PS256        | RSASSA-PSS using SHA-256 and  | Optional           |
   |              | MGF1 with SHA-256             |                    |
   | PS384        | RSASSA-PSS using SHA-384 and  | Optional           |
   |              | MGF1 with SHA-384             |                    |
   | PS512        | RSASSA-PSS using SHA-512 and  | Optional           |
   |              | MGF1 with SHA-512             |                    |
   | none         | No digital signature or MAC   | Optional           |
   |              | performed                     |                    |
   +--------------+-------------------------------+--------------------+

   The use of "+" in the Implementation Requirements column indicates
   that the requirement strength is likely to be increased in a future
   version of the specification.
```
> 可以看到被标记为 Recommended 的只有 RS256 和 ES256。
### 对称加密算法

> 插件安装默认使用`HS256 `对称加密算法。

HS256 使用同一个`「secret_key」`进行签名与验证。一旦 `secret_key `泄漏，就毫无安全性可言了。因此 HS256 只适合集中式认证，签名和验证都必须由可信方进行。

### 非对称加密算法

> RS256 系列是使用 RSA 私钥进行签名，使用 RSA 公钥进行验证。

公钥即使泄漏也毫无影响，只要确保私钥安全就行。RS256 可以将验证委托给其他应用，只要将公钥给他们就行。

> 以下为RS系列算法生成命令，仅供参考

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

> 不懂的同学可以了解一下视频，会有详细的说明哦

- 如何使用 JWT 认证插件：https://www.bilibili.com/video/BV1HS4y1F7Jx
- 如何使用 JWT 认证插件（算法篇）：https://www.bilibili.com/video/BV14L4y1g7sY
