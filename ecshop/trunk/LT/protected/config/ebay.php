<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-9
 * Time: 5:05pm
 * parameters for eBay calling
 */

return array(
    'SiteID'=>array(
        'US'=>'0',
        'MOTO'=>'100',
        'Australia'=>'15',
    ),
    //sandbox key, for developing purpose
    'sandbox'=>array(
        'API_URL'=>"https://api.sandbox.ebay.com/ws/api.dll",
        'COMPATIBILITYLEVEL'=>"893",
        'keys'=>array(
            "sandbox key set" => array(
                "name" => "sandbox key set",
                "DEVID" => "463653ff-bee4-4c45-8a48-b1896d4f228a",
                "AppID" => "Liu975857-d764-447a-b42c-d27a93aef08",
                "CertID" => "dc63f085-c534-46cb-b955-b4f3dd3752f7",
            ),
        ),
        'tokens'=>array(
            'testuser_360388945_cloud' => "AgAAAA**AQAAAA**aAAAAA**IEE2VA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GhDJiBpgydj6x9nY+seQ**VdsBAA**AAMAAA**4nbeBKCMY454cLAwRtq/dhc0kop2JsCxN/3a5eZIncpmVAm/8yYGFe+kBv0AxduHNaQsfGGmHczg/wAh3mg9TsDlvjU+8ZgMCXstmpaPmjzsDeV8zuySofTi9IpSAz99A06EuBsPOBs3PL5PVRwNaPX6er4qBhOfufGHczFkdmPWju+I2W3ZXetpdFeH/Xwx259IaJlgDe6D4fYY+5F/yzcRSHoQV4WjTjCbUQN3q/oOwcPuhDVr9m/e3vc/AyhkDIanKhx8ZpzNrnym0VRopwleOyAjhEaW7SPG09mcFMpqritTKlXon9TDJkfxQDP6EQ9edeKLSHVtQ5XCPooYnp1WRne2euIkyb5/I6yK7qQLrmL3l9+bTA11KEFr7ZUTZgTSlCuvBuMB+kQIa3G+lKrMGRwCoEwehEw6TC1jXKxhisBJrXgqiyLuoep2UDzNnjdDCP5+hKyNvrIXg8uDEdxHE060ynxMqUyY6zbR22o0BJWAXWd4MW1pJ5eECyAQBrhloawNJkRufItS3/Chi7rRPt5y9n8bLOkR5U2DHO27NkRwuOS+iemZXas09UixUkXhQQr16/k3xXFhRAWmbggKgRdRFtvpQSgFsJEuPlUGY2eBnLP7V700FK2XGvJLcgS+qj9hQjdvnFvgr8yETAoSXTU/vijPodkGa9zx4DIQjq0oNYb2ACYdgezeZTVtZ4Zmf4PswntB8lOdPQldrwozdvOMeqBDCpgQT+pLtdQxRrRg1JeXKe/aRayuQYWE",
        ),
    ),
    //production key, use these tokens very careful
    'production'=>array(
        'API_URL'=>"https://api.ebay.com/ws/api.dll",
        'COMPATIBILITYLEVEL'=>"893",
        'keys'=>array(
            "prod key set" => array(
                "name" => "prod key set",
                "DEVID" => "463653ff-bee4-4c45-8a48-b1896d4f228a",
                "AppID" => "Liu2405a7-c418-4bad-8d11-28461a284f6",
                "CertID" => "601cf7a6-2f13-4e97-8068-7bd4e093c18b",
            ),
        ),
        'tokens'=>array(
            'himerus.wish'=>'AgAAAA**AQAAAA**aAAAAA**1dQ4VA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AElIqkAJWCpQ+dj6x9nY+seQ**qoUBAA**AAMAAA**Ty/3Jdj6SZ9+jtSlp7HC2CUzFYQG9DXn9+wGW/eIOfqoQUdyiDNjgPGOXcpQMJ1yxOAP4I1dZ+VGwYoBshqQiyotiA4SAprNITtrxUf4l+irtRDKyUDWDUcNVNdUoV+5fsz4zhTb/0XVLwAThaaK99AEPcVgyUfsLpjqA/1kuDuRqB7eRGZcnTlVrgnrobucdRCqD8RyRTLexNbpd7+XRJfex8uYPpifBPfqVQWaQRmGtZV8O9k9wPCX5BPZq00nRmJdvXjcO7S3s48gdxtL0w3No3DcR+394zppol9bZkBlwa1K87ap0I4X8nwAiMrM7tugtagUIWZUqI3+ytUtp6hdKS88uo3TS2afcYs8g0zgOfBvH+7Y2ea4mrftPGiaGep7MCVAg+iF8NsyXyQjfQnc7o6r19tXk/nmU3FjgNbz4aiUQ1vZFWFJF5xj7dBCdrDkWNYoUTM43vX0nwUGkY9lK2BpO56lLJzhd0m3pB4hsmqaHfmf2yPWawYrhN+/6fAqCoK0KNRI5kLNLc+GlYEQgDjKKqiVMPnPpyMpp+xpRfwPwSkH1qZfLSVfFIGtkyCoUxUtK3Zqvgr2BvLUhI2jSBt+I1a9yjGB/8lhccz/y7O5PRyW6TgBHdmESh8PrU8OfOnciZ4+A8IT0oOBiyYxxkdD1fILQ6ibUmLZrBnLQkDCawpM0d5Dcu5yZoDaGyEt+MV3PmJ5dhkWe5BV3ncNU/NCa9JtI3ckIqbJlY3h5lb0YAa0bI2IyDhj4mpw',
        ),
    ),
    //for fetching operation only
    'ebay-fl'=>array(
        'API_URL'=>"https://api.ebay.com/ws/api.dll",
        'COMPATIBILITYLEVEL'=>"767",
        'keys'=>array(
            'lof'=>array(
                "name" => "ebay-fl",
                "DEVID" => "f7f0848a-70b8-48ef-ac15-2b4d1f8c5637",
                "AppID" => "LOFInc7af-f2d1-448a-b521-476bb468353",
                "CertID" => "2360f8f3-8fa5-409e-b4a0-78ccf826647d",
            ),
        ),
        'tokens'=>array(
            'ebay-fl'=>'AgAAAA**AQAAAA**aAAAAA**e34yVA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wDkoeoDJWEpg2dj6x9nY+seQ**v88BAA**AAMAAA**YKO+e4Uz2Tmh4SCq0xnDja5EA8I5RkhA/+35gvuMhdVSYhxNZ0W3wSMsW+oxyWp8VdEZRTQnCE4DzyELBBC/1HG9+WL9h+rgnuSYH7gYceyskzIaft2v6InyqxDXcnT4MVbKUTCXNDrHDdevED9eBso1ybjCtg8lzL8kf1H37ocZ8Zr6aAL57OHvCjQtlqyilpGi+/400OBO8Z6omFopw8mklcefmIaY6tDzRf8LqarD5os8eH6hZr/LmyVu9cDsmY1vsNRXQeneDfnKDO1jbdDfDkWuSQQPUqpE5A5n4nPIZMAd8MCDE5+Q/06I8ToEO+lraVU+r6PMGE8WLy6dWU//V/a+yYkQoYguIRvsXuz1VC83/h5gwjJuXNaXqk1moucZSgd8Ew1ojuncPcfDGjMsYs/u4Cl0wdTyn7goshm7eSD8lPMVJBrBpvlqNc5Zl5HgUDboWnK3Z2ZDoIRY0sMP009gG4ZV3VdbYaADV9pzV+UkUTXbDNsBkf6MKQulgrrMZ53wEFWErV6+3e0uWQbJKdkcHM1E4MkumNXrrG0xMavm0p3Rp5/Br8CxZ83rIfD0EFE0shxJAezGMZ0jFCyFuF2Oa+6nAhbLdB/teYI9juBP4/s7B9nnofvX2gM5Ye2woPen4yUmAKln3hcoUuIUVT5xKJ6esxZ6pVXAbui6Xh1iuellzdky8dBzlsfCmwplwsklTYyWMcBE5QNwN1knYorvbbc/qmEe2+ltWeeLZNZ+jE4MqZynBrwdUVwn',
        ),
    ),
    //for fetching operation only
    'ebay-discount'=>array(
        'API_URL'=>"https://api.ebay.com/ws/api.dll",
        'COMPATIBILITYLEVEL'=>"767",
        'keys'=>array(
            'lof'=>array(
                "name" => "ebay-discount",
                "DEVID" => "f9535f37-8bc9-4f3e-af92-e714193dc595",
                "AppID" => "Discount-25f3-4c15-adbd-ba636a8317bb",
                "CertID" => "f715d032-e8de-45a2-ad54-a593ca53103b",
            ),
        ),
        'tokens'=>array(
            'ebay-discount'=>'AgAAAA**AQAAAA**aAAAAA**UIUyVA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wMkoWgAJmLoAqdj6x9nY+seQ**yc8BAA**AAMAAA**yv35URRo2jxyfgeVKqwP07WNMqmtSgn1AZ7a8b07iMfg/ek4+GgR9hRRkDO119OSYFiLZgSfkpYR4eyWthTNDW/BO5tKUSqXiWl64xcQB4nXPiukI7qH25b/fZN7Hnc+9REhS1petKICMAga9dsFZbzknPTvE7XFj6tFUdYMgUJbM5ZyYWTEWDcK+kktlekYK97csJIsloqBuYZ9uNo2c68bSdiiUDB7KCHQFlhnmLRJF5+7zeWgKNSuJRqz9SWnDsE1zmBps1y1MjBHJHMRDrObqNIT80/7ETOxAIqBPpQ7PaH9Xm/mMJpay6rXPd2fjJrRsLSwHfYToq5uxWUySfjTHTchUkVm6lFAPZAjSoRM/2wNz8DUlnRf5Ci6jJfg79ke5EMUBSJZuuYuVvrSQxtqb+aoNLmtXyK1TtIAbBnB6aQ5yyXHYim5xPUl9gzwKN4wuDbHOQNxTMypiNhdiGKyuARQbQLhJ4kl8WYY5vtyaMcrVkAolyl8BskMem6AyXsR+7nLzOaZh4AdTRXgqghr0Ep7cLwR/CtbUmH6ogzcvj9HvTd0qBdmC2B7N2iJGh562EQxCqRfBXwbu82026C2DHFdq9ZmcnhOSCftgWBxaRSYnIHBxDuVtq+nfHhgsDos949wFk3zLm+0OEL7uocqaKU6NDycmmc5MeBMtPJSJU8BShgS2U70sAEbfFOa2OggqAC2z+beubfix30iI2qnP7PcrmeBRFY4sx+ZYphOjI3Tz0kSvULGHnXi2oRe',
        ),
    ),
);