<?php
return [
    'enable' => true,
    'jwt' => [
        // 算法类型 ES256、HS256、HS384、HS512、RS256、RS384、RS512
        'algorithms' => 'HS256',
        // access令牌秘钥
        'access_secret_key' => '2022d3d3LmJq',
        // access令牌过期时间，单位秒。默认 2 小时
        'access_exp' => 36000,
        // refresh令牌秘钥
        'refresh_secret_key' => '2022KTxigxc9o50c',
        // refresh令牌过期时间，单位秒。默认 7 天
        'refresh_exp' => 72000,
        // 令牌签发者
        'iss' => 'webman.tinywan.cn',
        // 令牌签发时间
        'iat' => time(),

        /**
         * access令牌 RS256 私钥
         * 生成RSA私钥(Linux系统)：openssl genrsa -out access_private_key.key 1024 (2048)
         */
        'access_private_key' => '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCgVuPmX9cCXhBKxsFo7p1anl1kB3bZaF9obEP/myx6kpros6k/
sADMjPpQ2xnrpbKfE5tIrDtaaVaLeEnT3gdxu4hQyUAJmEgP3XIQb2pA0d0sV5hp
7KUoV+bTKSa/Pgo8IGJkuEHVs6oCNJNl7VJR5d05UFuiNSqzVopqVQ7GowIDAQAB
AoGAOecHCCPmLomvkoFySSWal6YHDd+QMPT7N2eZqs3r4xvca1quLTyvHS9wGhD1
rF67Qa0/75+bE4xk35sB9kwBHaQJhD1LjkJV0cUJm1ob9aK7nLldRgk51ZWRFHjF
j3vBBzVUndxA4clyNtCALgDGy8fkyY1QcfMK82JIw2fozqECQQDLvewjIwzJoKTl
SHrTLLHQ2tgxX93cu0em4iEPI7cC22gkEcLmt3XljEc1uiuvTaqyojMaPU66DO0P
3dPyGEHTAkEAyXcUXnceFKuBZOCkkqzSjAt/EgaqsJZEKzU9qTFbhw6P5q7w91C9
/mx5O5Wr5PHFmTny1matLc9hg/iZn9OV8QJBAL8ewLVROrylAinG7NjNk1vs/mKK
oE9gKt2kQAi4owN+F9nGA4Nz05dqGJ6Qrkv62kZJmxBhNEmYuIRqvVfbY1sCQQC+
BTkLGKMgr9stwMy5I5S7TqSd5ffc8v59Gox8JvfDXTLRTDQvsNJjRQDb+IHXQUs1
CPlIzDOPv8ikZzjPDQyhAkAwD/A0qz+s3J15Vh8sVZ21YjoiIH80FabUOnr9XW4i
0+v0hN5ozhVj75C2eJia+OMXZAaWZsqSY3jnVgkffhhp
-----END RSA PRIVATE KEY-----',

        /**
         * access令牌 RS256 公钥
         * 生成RSA公钥(Linux系统)：openssl rsa -in access_private_key.key -pubout -out access_public_key.key
         */
        'access_public_key' => '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCgVuPmX9cCXhBKxsFo7p1anl1k
B3bZaF9obEP/myx6kpros6k/sADMjPpQ2xnrpbKfE5tIrDtaaVaLeEnT3gdxu4hQ
yUAJmEgP3XIQb2pA0d0sV5hp7KUoV+bTKSa/Pgo8IGJkuEHVs6oCNJNl7VJR5d05
UFuiNSqzVopqVQ7GowIDAQAB
-----END PUBLIC KEY-----',

        /**
         * refresh令牌 RS256 私钥
         * 生成RSA私钥(Linux系统)：openssl genrsa -out refresh_private_key.key 1024 (2048)
         */
        'refresh_private_key' => '',

        /**
         * refresh令牌 RS256 公钥
         * 生成RSA公钥(Linux系统)：openssl rsa -in refresh_private_key.key -pubout -out refresh_public_key.key
         */
        'refresh_public_key' => '',
    ],
];