# Mime

&ensp;&ensp;&ensp;&ensp;Mime is a php class library that contains tons of user-agent headers from real-world.
It is actually designed for the use of avoiding blocking by user-agent by crawlers in many cases.

# Requirements

+ >= php7.1
+ [https://www.useragentstring.com](https://www.useragentstring.com)

> &ensp;&ensp;&ensp;&ensp;Useragent data is from [https://www.useragentstring.com](https://www.useragentstring.com).
]


# Installation

```shell
git clone https://github.com/duanqiaobb/Mime.git
```

# Usage

#### Random

&ensp;&ensp;&ensp;&ensp; Generate a user-agent randomly.

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->random());
```


#### Browser

&ensp;&ensp;&ensp;&ensp; Generate a browser user-agent randomly.

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->browser());
```

#### PC Browser UserAgent

&ensp;&ensp;&ensp;&ensp; Generate a pc-browser user-agent randomly.

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->pc());
```

#### Mobile Browser userAgent

&ensp;&ensp;&ensp;&ensp; Generate a mobile-browser user-agent randomly.

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->mobile());
```

# Cache

&ensp;&ensp;&ensp;&ensp;


