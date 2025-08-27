<?php

return [
    'enable' => true,
    'jwt' => [
        /** 算法类型 HS256、HS384、HS512、RS256、RS384、RS512、ES256、ES384、ES512、PS256、PS384、PS512 */
        'algorithms' => 'HS256',

        /** access令牌秘钥 */
        'access_secret_key' => '2022d3d3LmJq',

        /** access令牌过期时间，单位：秒。默认 2 小时 */
        'access_exp' => 7200,

        /** refresh令牌秘钥 */
        'refresh_secret_key' => '2022KTxigxc9o50c',

        /** refresh令牌过期时间，单位：秒。默认 7 天 */
        'refresh_exp' => 604800,

        /** refresh 令牌是否禁用，默认不禁用 false */
        'refresh_disable' => false,

        /** 令牌签发者 */
        'iss' => 'webman.tinywan.cn',

        /** 某个时间点后才能访问，单位秒。（如：30 表示当前时间30秒后才能使用） */
        'nbf' => 0,

        /** 时钟偏差冗余时间，单位秒。建议这个余地应该不大于几分钟 */
        'leeway' => 60,

        /** 是否允许单设备登录，默认不允许 false */
        'is_single_device' => false,

        /** 缓存令牌时间，单位：秒。默认 7 天 */
        'cache_token_ttl' => 604800,

        /** 缓存令牌前缀，默认 JWT:TOKEN: */
        'cache_token_pre' => 'JWT:TOKEN:',

        /** 缓存刷新令牌前缀，默认 JWT:REFRESH_TOKEN: */
        'cache_refresh_token_pre' => 'JWT:REFRESH_TOKEN:',

        /** 用户信息模型 */
        'user_model' => function ($uid) {
            return [];
        },

        /** 是否支持 get 请求获取令牌 */
        'is_support_get_token' => false,
        /** GET 请求获取令牌请求key */
        'is_support_get_token_key' => 'authorization',

        /** access令牌私钥 */
        'access_private_key' => <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAz7q5I3uJXesetkWd5l5Q5a5J5j5o5k5l5m5n5p5q5r5s5t5u5v5w
x5y5z505152535455565758595a5b5c5d5e5f5g5h5i5j5k5l5m5n5o5p5q5r5s5t5u5v
5w5x5y5z605162536465666768696a6b6c6d6e6f707172737475767778797a7b7c7d
7e7f808182838485868788898a8b8c8d8e8f909192939495969798999a9b9c9d9e9f
a0a1a2a3a4a5a6a7a8a9aaabacadaeafb0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1
c2c3c4c5c6c7c8c9cacbcccdcecfd0d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2
e3e4e5e6e7e8e9eaebecedeeeff0f1f2f3f4f5f6f7f8f9fafbfcfdfeffAgMBAAEC
-----END RSA PRIVATE KEY-----
EOD,

        /** access令牌公钥 */
        'access_public_key' => <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAz7q5I3uJXesetkWd5l5Q
5a5J5j5o5k5l5m5n5p5q5r5s5t5u5v5w5x5y5z505152535455565758595a5b5c5d
5e5f5g5h5i5j5k5l5m5n5o5p5q5r5s5t5u5v5w5x5y5z605162536465666768696a
6b6c6d6e6f707172737475767778797a7b7c7d7e7f808182838485868788898a8b8c
8d8e8f909192939495969798999a9b9c9d9e9fa0a1a2a3a4a5a6a7a8a9aaabacadae
afb0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1c2c3c4c5c6c7c8c9cacbcccdcecfd0
d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2e3e4e5e6e7e8e9eaebecedeeeff0f1f2
f3f4f5f6f7f8f9fafbfcfdfeffAwIDAQAB
-----END PUBLIC KEY-----
EOD,

        /** refresh令牌私钥 */
        'refresh_private_key' => <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAz7q5I3uJXesetkWd5l5Q5a5J5j5o5k5l5m5n5p5q5r5s5t5u5v5w
x5y5z505152535455565758595a5b5c5d5e5f5g5h5i5j5k5l5m5n5o5p5q5r5s5t5u5v
5w5x5y5z605162536465666768696a6b6c6d6e6f707172737475767778797a7b7c7d
7e7f808182838485868788898a8b8c8d8e8f909192939495969798999a9b9c9d9e9f
a0a1a2a3a4a5a6a7a8a9aaabacadaeafb0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1
c2c3c4c5c6c7c8c9cacbcccdcecfd0d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2
e3e4e5e6e7e8e9eaebecedeeeff0f1f2f3f4f5f6f7f8f9fafbfcfdfeffAgMBAAEC
-----END RSA PRIVATE KEY-----
EOD,

        /** refresh令牌公钥 */
        'refresh_public_key' => <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAz7q5I3uJXesetkWd5l5Q
5a5J5j5o5k5l5m5n5p5q5r5s5t5u5v5w5x5y5z505152535455565758595a5b5c5d
5e5f5g5h5i5j5k5l5m5n5o5p5q5r5s5t5u5v5w5x5y5z605162536465666768696a
6b6c6d6e6f707172737475767778797a7b7c7d7e7f808182838485868788898a8b8c
8d8e8f909192939495969798999a9b9c9d9e9fa0a1a2a3a4a5a6a7a8a9aaabacadae
afb0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1c2c3c4c5c6c7c8c9cacbcccdcecfd0
d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2e3e4e5e6e7e8e9eaebecedeeeff0f1f2
f3f4f5f6f7f8f9fafbfcfdfeffAwIDAQAB
-----END PUBLIC KEY-----
EOD,
    ],
];