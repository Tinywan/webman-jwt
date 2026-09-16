# 🚀 JSON Web Token (JWT) for Webman

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tinywan/jwt.svg?style=flat-square)](https://packagist.org/packages/tinywan/jwt)
[![Total Downloads](https://img.shields.io/packagist/dt/tinywan/jwt.svg?style=flat-square)](https://packagist.org/packages/tinywan/jwt)
[![License](https://img.shields.io/packagist/l/tinywan/jwt.svg?style=flat-square)](https://packagist.org/packages/tinywan/jwt)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue.svg)](https://www.php.net)
[![Ask Zread](https://img.shields.io/badge/Ask_Zread-_.svg?style=flat&color=00b0aa&labelColor=000000&logo=data%3Aimage%2Fsvg%2Bxml%3Bbase64%2CPHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTQuOTYxNTYgMS42MDAxSDIuMjQxNTZDMS44ODgxIDEuNjAwMSAxLjYwMTU2IDEuODg2NjQgMS42MDE1NiAyLjI0MDFWNC45NjAxQzEuNjAxNTYgNS4zMTM1NiAxLjg4ODEgNS42MDAxIDIuMjQxNTYgNS42MDAxSDQuOTYxNTZDNS4zMTUwMiA1LjYwMDEgNS42MDE1NiA1LjMxMzU2IDUuNjAxNTYgNC45NjAxVjIuMjQwMUM1LjYwMTU2IDEuODg2NjQgNS4zMTUwMiAxLjYwMDEgNC45NjE1NiAxLjYwMDFaIiBmaWxsPSIjZmZmIi8%2BCjxwYXRoIGQ9Ik00Ljk2MTU2IDEwLjM5OTlIMi4yNDE1NkMxLjg4ODEgMTAuMzk5OSAxLjYwMTU2IDEwLjY4NjQgMS42MDE1NiAxMS4wMzk5VjEzLjc1OTlDMS42MDE1NiAxNC4xMTM0IDEuODg4MSAxNC4zOTk5IDIuMjQxNTYgMTQuMzk5OUg0Ljk2MTU2QzUuMzE1MDIgMTQuMzk5OSA1LjYwMTU2IDE0LjExMzQgNS42MDE1NiAxMy43NTk5VjExLjAzOTlDNS42MDE1NiAxMC42ODY0IDUuMzE1MDIgMTAuMzk5OSA0Ljk2MTU2IDEwLjM5OTlaIiBmaWxsPSIjZmZmIi8%2BCjxwYXRoIGQ9Ik0xMy43NTg0IDEuNjAwMUgxMS4wMzg0QzEwLjY4NSAxLjYwMDEgMTAuMzk4NCAxLjg4NjY0IDEwLjM5ODQgMi4yNDAxVjQuOTYwMUMxMC4zOTg0IDUuMzEzNTYgMTAuNjg1IDUuNjAwMSAxMS4wMzg0IDUuNjAwMUgxMy43NTg0QzE0LjExMTkgNS42MDAxIDE0LjM5ODQgNS4zMTM1NiAxNC4zOTg0IDQuOTYwMVYyLjI0MDFDMTQuMzk4NCAxLjg4NjY0IDE0LjExMTkgMS42MDAxIDEzLjc1ODQgMS42MDAxWiIgZmlsbD0iI2ZmZiIvPgo8cGF0aCBkPSJNNCAxMkwxMiA0TDQgMTJaIiBmaWxsPSIjZmZmIi8%2BCjxwYXRoIGQ9Ik00IDEyTDEyIDQiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8L3N2Zz4K&logoColor=ffffff)](https://zread.ai/Tinywan/webman-jwt)

[English](README.md) | [中文说明](README.zh-CN.md)

JSON Web Token (JWT) is an open standard (RFC 7519) that defines a compact and self-contained way for securely transmitting information between parties as a JSON object. This token is designed to be compact and secure, making it particularly suitable for Single Sign-On (SSO) scenarios in distributed applications.

> **Note**: Starting from version `1.14.0`, secret key length validation has been introduced for security reasons. Versions prior to `1.14.0` did not strictly check key lengths; versions `1.14.0` and above enforce minimum key length requirements.

---

## v2.0.0 Upgrade Guide

`v2.0.0` raises the minimum PHP requirement to **PHP 8.2+** and drops support for PHP 7.4, 8.0, and 8.1.  
- Projects running older PHP versions should stay on `v1.15.x`.
- Projects on PHP 8.2+ can upgrade using:

```shell
composer require tinywan/jwt:^2.0
```

---

## Installation

Install via Composer:

```shell
composer require tinywan/jwt
```

---

## Quick Start

### Generating a Token

```php
use Tinywan\Jwt\JwtToken;

$user = [
    'id'    => 2022,
    'name'  => 'Tinywan',
    'email' => 'Tinywan@163.com',
];

$token = JwtToken::generateToken($user);
var_dump(json_encode($token));
```

**Output (JSON format):**

```json
{
    "token_type": "Bearer",
    "expires_in": 36000,
    "access_token": "eyJ0eXAiOiJAUR-Gqtnk9LUPO8IDrLK7tjCwQZ7CI...",
    "refresh_token": "eyJ0eXAiOiJIEGkKprvcccccQvsTJaOyNy8yweZc..."
}
```

**Response Parameters:**

| Parameter | Type | Description | Example |
| :--- | :--- | :--- | :--- |
| `token_type` | string | Token type | `Bearer` |
| `expires_in` | int | Token expiration duration (seconds) | `36000` |
| `access_token` | string | Access token | `XXXXXXXXXXXXXXXXXXXX` |
| `refresh_token` | string | Refresh token (used to renew expired access tokens) | `XXXXXXXXXXXXXXXXXXXX` |

---

## Supported Methods & APIs

### 1. Get Current User ID
```php
$id = Tinywan\Jwt\JwtToken::getCurrentId();
```

### 2. Get All Payload Claims (Custom Fields)
```php
$extend = Tinywan\Jwt\JwtToken::getExtend();
```

### 3. Get Specific Claim Value
```php
$email = Tinywan\Jwt\JwtToken::getExtendVal('email');
```

### 4. Refresh Token (Exchange Refresh Token for New Access Token)
```php
$refreshToken = Tinywan\Jwt\JwtToken::refreshToken();
```

### 5. Get Remaining Token Lifetime
```php
$exp = Tinywan\Jwt\JwtToken::getTokenExp();
```

### 6. Single Device Login (SSO)
Disabled by default. To enable, update your configuration file `config/plugin/tinywan/jwt/app.php`:
```php
'is_single_device' => true,
```
> Single device login supports defining the client type `client` (defaults to `WEB`), such as: `MOBILE`, `APP`, `WECHAT`, `WEB`, `ADMIN`, `API`, `OTHER`, etc.
```php
$user = [
    'id'     => 2022,
    'name'   => 'Tinywan',
    'client' => 'MOBILE',
];
$token = Tinywan\Jwt\JwtToken::generateToken($user);
var_dump(json_encode($token));
```

### 7. Get Current User Model (`>= 1.2.4`)
```php
$user = Tinywan\Jwt\JwtToken::getUser();
```
The `'user_model'` configuration option accepts a closure (defaults to returning an empty array). You can customize the return model based on your ORM:

**ThinkORM Configuration:**
```php
'user_model' => function($uid) {
    // Returns array
    return \think\facade\Db::table('resty_user')
        ->field('id,username,create_time')
        ->where('id', $uid)
        ->find();
}
```

**Laravel ORM (Illuminate Database) Configuration:**
```php
'user_model' => function($uid) {
    // Returns object
    return \support\Db::table('resty_user')
        ->where('id', $uid)
        ->select('id', 'email', 'mobile', 'create_time')
        ->first();
}
```

### 8. Clear Token (Logout)
```php
$res = Tinywan\Jwt\JwtToken::clear();
```
> Only takes effect when `is_single_device` is set to `true`. Supported parameters: `MOBILE`, `APP`, `WECHAT`, `WEB`, `ADMIN`, `API`, `OTHER`, etc.

### 9. Custom Client Types
```php
// Generate WEB token
$user = [
    'id'     => 2022,
    'name'   => 'Tinywan',
    'client' => JwtToken::TOKEN_CLIENT_WEB,
];
$token = JwtToken::generateToken($user);

// Generate Mobile token
$user = [
    'id'     => 2022,
    'name'   => 'Tinywan',
    'client' => JwtToken::TOKEN_CLIENT_MOBILE,
];
$token = JwtToken::generateToken($user);
```
Defaults to `WEB`.

### 10. Custom Expiration Time for Access & Refresh Tokens
```php
$extend = [
    'id'         => 2024,
    'access_exp' => 7200,  // 2 hours
];
$token = Tinywan\Jwt\JwtToken::generateToken($extend);
```

### 11. Minimum Key Length Requirements (`>= 1.14.0`)
Mandatory minimum key length requirements (especially for `HS*` symmetric algorithms):

| Algorithm | Minimum Key Length (Bytes) | Reference Character Count (UTF-8) | Recommended Generation Method |
| :--- | :--- | :--- | :--- |
| **HS256** | 32 bytes | ≥ 32 characters | `bin2hex(random_bytes(32))` → 64 hex chars |
| **HS384** | 48 bytes | ≥ 48 characters | `random_bytes(48)` |
| **HS512** | 64 bytes | ≥ 64 characters | `random_bytes(64)` |

### 12. Token Error Codes

* **Access Token Errors:**
  * Invalid authentication token: `401011`
  * Authentication token not active yet: `401012`
  * Session expired, please log in again: `401013`
  * Requested custom claim does not exist: `401014`
  * Unknown access token error: `401015`
* **Refresh Token Errors:**
  * Invalid refresh token: `401021`
  * Refresh token not active yet: `401022`
  * Refresh token session expired, please log in again: `401023`
  * Requested refresh token custom claim does not exist: `401024`
  * Unknown refresh token error: `401025`

---

## Signature Algorithms (JWA)

Common signature algorithms include: `HS256 (HMAC-SHA256)`, `RS256 (RSA-SHA256)`, and `ES256 (ECDSA-SHA256)`.

### Supported Algorithms List

```text
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
```
> Note: Only `RS256` and `ES256` are marked as **Recommended**.

### Symmetric Algorithms
Defaults to `HS256` symmetric encryption.  
`HS256` uses the same `secret_key` for signing and verification. If the secret key leaks, security is completely compromised. Therefore, `HS256` is best suited for centralized authentication where signing and validation are both performed by trusted parties.

### Asymmetric Algorithms
`RS256` uses an RSA private key for signing and an RSA public key for verification.  
Public key exposure causes no security risk as long as the private key remains secure. `RS256` allows delegating verification to third-party services by simply providing them the public key.

#### Key Pair Generation Commands (OpenSSL)

**RS512:**
```bash
ssh-keygen -t rsa -b 4096 -E SHA512 -m PEM -P "" -f RS512.key
openssl rsa -in RS512.key -pubout -outform PEM -out RS512.key.pub
```

**RS384:**
```bash
ssh-keygen -t rsa -b 4096 -E SHA354 -m PEM -P "" -f RS384.key
openssl rsa -in RS384.key -pubout -outform PEM -out RS384.key.pub
```

**RS256:**
```bash
ssh-keygen -t rsa -b 4096 -E SHA256 -m PEM -P "" -f RS256.key
openssl rsa -in RS256.key -pubout -outform PEM -out RS256.key.pub
```

---

## 🚀 Video Tutorials

- How to use the JWT Authentication Plugin: https://www.bilibili.com/video/BV1HS4y1F7Jx
- How to use the JWT Authentication Plugin (Algorithms Guide): https://www.bilibili.com/video/BV14L4y1g7sY

---

## Security & Flow

### Concepts
Authentication and authorization are critical yet complex topics in software engineering. In many frameworks, handling security accounts for a significant portion of code. JWT helps you handle authentication easily, securely, and in a standardized way without having to reinvent security specifications.

### Flow Scenario
Suppose your backend API lives on one domain, and your frontend (SPA or mobile application) lives on another domain. When a user submits credentials (username & password), the API validates them and responds with an access token. The frontend includes this token in the `Authorization` header (`Bearer <token>`) on subsequent requests.

### Authentication & Authorization Flowchart

![image](https://user-images.githubusercontent.com/14959876/159104533-f51f0a57-e085-44ab-84d7-363a4bb1eda9.png)

### Token Signing Process

1. User sends username and password to the authentication server.
2. The authentication server verifies credentials and generates a JWT Token:
   - Encodes JWT Header and Payload with Base64URL.
   - Signs the token: `HMAC-SHA256(SecretKey, Base64UrlEncode(Header) + "." + Base64UrlEncode(Payload))`.
3. Returns `base64(header).base64(payload).signature` as the token to the client.
4. Client attaches the token in request headers for subsequent protected API calls.

---

## License

This project is open-sourced software licensed under the [Apache-2.0 License](LICENSE).
