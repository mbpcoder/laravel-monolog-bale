

monolog-bale
=============

🔔 Bale Handler for Monolog


# Installation
-----------
Install using composer:

```bash
composer require thecoder/laravel-monolog-bale  
```

# Usage
Open config/logging.php and change the file

```php

 'channels' => [
    'stack' => [
        'driver'   => 'stack',
        'channels' => ['single', 'bale'],
    ],
    
    ....
    
        'bale' => [
            'driver' => 'monolog',
            'level' => 'debug',
            
            'handler' => TheCoder\MonologBale\BaleBotHandler::class,
            'handler_with' => [
                'token' => env('LOG_BALE_BOT_TOKEN'),
                'chat_id' => env('LOG_BALE_CHAT_ID'),
                'bot_api' => env('LOG_BALE_BOT_API', 'https://api.bale.org/bot'),
                'proxy' => env('LOG_BALE_BOT_PROXY', null),
            ],
            
            'formatter' => TheCoder\MonologBale\BaleFormatter::class,
            'formatter_with' => [
                'tags' => env('LOG_BALE_TAGS', null),
            ],            
        ],
]

```

Add the following variables to your .env file.

```php
LOG_BALE_BOT_TOKEN=
LOG_BALE_CHAT_ID=
#LOG_BALE_BOT_API='https://api.bale.org/bot'
# add tor proxy for restricted country
#LOG_BALE_BOT_PROXY='socks5h://localhost:9050'
```
# ScreenShot

![Casdapture](https://user-images.githubusercontent.com/3877538/124601040-a0cc8100-de7c-11eb-93b8-b5acf08d06c8.PNG)
