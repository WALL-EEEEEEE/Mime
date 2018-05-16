# Mime
<div align='right' style='display:inline-block'><strong>Docmentation:</strong> English <a href="https://github.com/duanqiaobb/pider/blob/develop/doc/zh_cn/README.md">Chinese</a></div>

&ensp;&ensp;&ensp;&ensp;Mime is a php class library that contains tons of user-agent headers from real-world.
It is actually designed for the use of avoiding crawlers-blocking by user-agent in many cases.

# Requirements

+ `>= php7.1`
+ [https://www.useragentstring.com](https://www.useragentstring.com)

> Useragent data is from [https://www.useragentstring.com](https://www.useragentstring.com).


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

&ensp;&ensp;&ensp;&ensp; For the sake of avoiding fetching useragent data from [https://www.useragentstring.com](https://www.useragentstring.com) each time. `Mime` only fetches it at the first time and caches it into `/tmp` diretory.

# Fallback

&ensp;&ensp;&ensp;&ensp; `Mime` has a fallback mechanic since [https://www.useragentstring.com](https://www.useragentstring.com) doesn't work well sometimes. It will load cached useragents in `cache/` directory  when [https://www.useragentstring.com](https://www.useragentstring.com) is down or up slow.


