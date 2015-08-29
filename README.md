[![GitHub issues](https://img.shields.io/github/issues/LittleGreyGrey/Get_favicon.svg?style=flat-square)](https://github.com/LittleGreyGrey/Get_favicon/issues)
[![GitHub forks](https://img.shields.io/github/forks/LittleGreyGrey/Get_favicon.svg?style=flat-square)](https://github.com/LittleGreyGrey/Get_favicon/network)
[![GitHub stars](https://img.shields.io/github/stars/LittleGreyGrey/Get_favicon.svg?style=flat-square)](https://github.com/LittleGreyGrey/Get_favicon/stargazers)
[![GitHub license](https://img.shields.io/badge/license-AGPL-blue.svg?style=flat-square)](https://raw.githubusercontent.com/LittleGreyGrey/Get_favicon/master/LICENSE)
# Get_favicon

## Description

According to URL to get the site favicon.

```
.
├── LICENSE
├── README.md
└── Get_favicon.class.php
```

## Examples

```php
require 'Get_favicon.class.php';
$get_favicon = new Get_favicon;
$get_favicon->get($_REQUEST['u'], $_REQUEST['a']);
```

## Test

[http://favicon.wiphp.com] (http://favicon.wiphp.com).
