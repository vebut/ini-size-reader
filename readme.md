# IniSizeReader
This library helps with parsing/reading ini-file styled size values such as
`4M`, `2MB`, `1024`, `1GB`, etc into bytes.

Main purpose of this is to easily be able to determine settings such as
`post_max_size`, `upload_max_filesize` and `memory_limit`.

## Usage

```php
<?php
use Vebut\IniSizeReader\Reader;

// Read formatted string and output bytes
$reader = new Reader("1MB");
$reader->getBytes(); // 1048576

// post_max_size = 2M
$postMaxSize = new Reader(ini_get("post_max_size"));
$postMaxSize->getBytes(); // 2097152
$postMaxSize->getString(); // "2M"
```

For simplicity the `Reader` also offers a static shortcut method
```php
<?php
use Vebut\IniSizeReader\Reader;
Reader::toBytes("1M"); // 1048576
```
