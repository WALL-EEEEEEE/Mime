# Mime
&ensp;&ensp;&ensp;&ensp; `Mime` 是一个随机模拟 `useragent` 的库。 它可以用来作为反反爬的工具，用来躲过一些
通过 `useragent` 的反爬手段。

## 需求

+ `>= php7.1`
+ [https://www.useragentstring.com](https://www.useragentstring.com)

> `Mime` 的 `useragent` 数据来源于 [https://www.useragentstring.com](https://www.useragentstring.com)

## 安装

```shell
git clone https://github.com/duanqiaobb/Mime.git
```

## 使用

#### 1. 随机`useragent`

生成随机`useragent`

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->random());
```


#### 2. 浏览器`useragent`

生成随机浏览器`useragent`

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->browser());
```

#### 3. PC端浏览器`useragent` 

生成随机PC端浏览器`useragent`

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->pc());
```

#### 4. 手机端浏览器`useragent` 

生成随机手机端浏览器`useragent`

```php
<?php
include("Mime/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent();
var_dump($ua->mobile());
```

## 缓存

&ensp;&ensp;&ensp;&ensp; 为了避免每次都需要从 [https://www.useragentstring.com](https://www.useragentstring.com) 拉取和请求数据. `Mime` 只在第一次的时候才会从[https://www.useragentstring.com](https://www.useragentstring.com)拉取数据，并将其缓存在`tmp/`目录下。

## 备用

&ensp;&ensp;&ensp;&ensp; 由于网站[https://www.useragentstring.com](https://www.useragentstring.com)并不是很稳定，所以`Mime`提供了相应的备用机制. 当请求[https://www.useragentstring.com](https://www.useragentstring.com)超时，`Mime`会从`cache/`目录中的`useragent`已有的数据,直接提取.



