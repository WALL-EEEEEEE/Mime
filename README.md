# Mime

&ensp;&ensp;&ensp;&ensp;Mime is a php class library that contains tons of user-agent headers from real-world.
It is actually designed for the use of avoiding blocking by user-agent by crawlers in many cases.

# Requirements

+ `>= php7.1`
+ [https://www.useragentstring.com](https://www.useragentstring.com)

> Useragent data is from [https://www.useragentstring.com](https://www.useragentstring.com).
]


# Installation

```shell
git clone https://github.com/duanqiaobb/Mime.git
```

# Usage

#### 1. Random

Generate a user-agent randomly.

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->random());
```


#### 2. Browser

Generate a browser user-agent randomly.

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->browser());
```

#### 3. PC Browser UserAgent

Generate a pc-browser user-agent randomly.

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->pc());
```

#### 4. Mobile Browser userAgent

Generate a mobile-browser user-agent randomly.

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->mobile());
```

# Cache

&ensp;&ensp;&ensp;&ensp;


