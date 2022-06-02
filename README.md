# JSON Web Token (JWT) for webman plugin

[![Latest Stable Version](http://poser.pugx.org/tinywan/jwt/v)](https://packagist.org/packages/tinywan/jwt) 
[![Total Downloads](http://poser.pugx.org/tinywan/jwt/downloads)](https://packagist.org/packages/tinywan/jwt)
[![Daily Downloads](http://poser.pugx.org/tinywan/jwt/d/daily)](https://packagist.org/packages/tinywan/jwt)
[![Latest Unstable Version](http://poser.pugx.org/tinywan/jwt/v/unstable)](https://packagist.org/packages/tinywan/jwt) 
[![License](http://poser.pugx.org/tinywan/jwt/license)](https://packagist.org/packages/tinywan/jwt) 
[![PHP Version Require](http://poser.pugx.org/tinywan/jwt/require/php)](https://packagist.org/packages/tinywan/jwt)

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
$uid = Tinywan\Jwt\JwtToken::getCurrentId();
```

> 2、获取所有字段

```php
$email = Tinywan\Jwt\JwtToken::getExtend();
```

> 3、获取自定义字段

```php
$email = Tinywan\Jwt\JwtToken::getExtendVal('email');
```

> 4、刷新令牌（通过刷新令牌获取访问令牌）

```php
$refreshToken = Tinywan\Jwt\JwtToken::refreshToken();
```

> 5、获令牌有效期剩余时长

```php
$exp = Tinywan\Jwt\JwtToken::getTokenExp();
```
> 6、单设备登录。默认是关闭，开启请修改配置文件`config/plugin/tinywan/jwt`

```php
'is_single_device' => true,
```
> 7、获取当前用户信息（模型）

```php
$user = Tinywan\Jwt\JwtToken::getUser();
```
该配置项目`'user_model'`为一个匿名函数，默认返回空数组，可以根据自己项目ORM定制化自己的返回模型

**ThinkORM** 配置
```php
'user_model' => function($uid) {
// 返回一个数组
return \think\facade\Db::table('resty_user')
	->field('id,username,create_time')
	->where('id',$uid)
	->find();
}
```

**LaravelORM** 配置

```php
'user_model' => function($uid) {
// 返回一个对象
return \support\Db::table('resty_user')
	->where('id', $uid)
	->select('id','email','mobile','create_time')
	->first();
}
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

## 安全性

https://www.w3cschool.cn/fastapi/fastapi-cmia3lcw.html

### 概念

有许多方法可以处理安全性、身份认证和授权等问题。而且这通常是一个复杂而「困难」的话题。在许多框架和系统中，仅处理安全性和身份认证就会花费大量的精力和代码（在许多情况下，可能占编写的所有代码的 50％ 或更多）。

Jwt 可帮助你以标准的方式轻松、快速地处理安全性，而无需研究和学习所有的安全规范。

### 场景

假设您在某个域中拥有后端API。并且您在另一个域或同一域的不同路径（或移动应用程序）中有一个前端。并且您希望有一种方法让前端使用用户名和密码与后端进行身份验证。我们可以使用OAuth2通过JWT来构建它。

### 认证流程

- 用户在前端输入`username`和`password`，然后点击Enter。
- 前端（在用户的浏览器中运行）发送一个`username`和`password`我们的API在一个特定的URL（以申报`tokenUrl="token"`）。
- API 检查username和password，并用“令牌”响应（我们还没有实现任何这些）。“令牌”只是一个包含一些内容的字符串，我们稍后可以使用它来验证此用户。通常，令牌设置为在一段时间后过期。因此，用户稍后将不得不再次登录。如果代币被盗，风险就小了。它不像一个永久有效的密钥（在大多数情况下）。
前端将该令牌临时存储在某处。
- 用户单击前端以转到前端 Web 应用程序的另一部分。
- 前端需要从 API 获取更多数据。但它需要对该特定端点进行身份验证。因此，为了使用我们的 API 进行身份验证，它会发送`Authorization`一个值为`Bearer`加上令牌的标头。如果令牌包含`foobar`，则`Authorization`标头的内容将为：`Bearer foobar`。`注意：中间是有个空格`。
