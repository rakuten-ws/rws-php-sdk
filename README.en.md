Rakuten Web Service SDK for PHP
===============================

[![Build Status](https://secure.travis-ci.org/rakuten-ws/rws-php-sdk.png?branch=master)](http://travis-ci.org/rakuten-ws/rws-php-sdk)

Rakuten Web Service SDK for PHP is a library to make it easy to connect to the Rakuten APIs.

Requirement
-----------

- PHP5.2.3+ (Recommended: PHP5.2.10+ with [curl extension](http://php.net/manual/en/book.curl.php))
- If you want to use this library on PHP5.2.10-, please install [HTTP_Client](http://pear.php.net/manual/en/package.http.http-client.php) on PEAR
  or curl extension.

Download
--------

You can download SDK from following links.

- [Stable 1.0.6 - zip](https://github.com/rakuten-ws/rws-php-sdk/archive/1.0.6.zip)
- [Source Code (Github)](https://github.com/rakuten-ws/rws-php-sdk)

RWS PHP SDK is registered at [Packagist](http://packagist.org/).
Therefore, you can get and manage the library with [Composer](http://getcomposer.org).

Get composer

    curl -s http://getcomposer.org/installer | php

Create *composer.json* file in the project root:


    {
        "require": {
            "rakuten-ws/rws-php-sdk": "1.*"
        }
    }

Install

    php composer.phar install


Basic Usage
-----------

Please register your application using our Web Service site (http://webservice.rakuten.co.jp).

Next, load *autoload.php* in your application.
The *autoload.php* file is in the same directory as this readme file.
Now you can use the library.

For APIs that don't need user authorization, like IchibaItemSearch API and Books API,
you can fetch data by following this sample code.

```php
<?php

require_once '/path/to/sdk-dir/autoload.php';

$client = new RakutenRws_Client();
// Please set your Application ID
$client->setApplicationId('YOUR_APPLICATION_ID');

// Please set your Affiliate ID (Optional)
$client->setAffiliateId('YOUR_AFFILIATE_ID');

// Search for "うどん" with the IchibaItemSearch API
$response = $client->execute('IchibaItemSearch', array(
  'keyword' => 'うどん'
));

// You can check that the response status is correct
if ($response->isOk()) {
    // You can access the response as an array
    var_dump($response['Body']);
} else {
    echo 'Error:'.$response->getMessage();
}
```
You can pass "API Name (string)", "Request Paramters (array)", and
"version" to *RakutenRws_Client::execute()* method.
"version" is an optional parameter. If you don't specify the "version" then the library will 
auotmatically select the latest version.

The following APIs support [Iterator (http://php.net/manual/en/class.iterator.php)],
so you can access each item's data with a foreach statement.

* AuctionGenreKeywordSearch
* AuctionItemCodeSearch
* AuctionItemSearch
* BooksBookSearch
* BooksCDSearch
* BooksDVDSearch
* BooksForeignBookSearch
* BooksGameSearch
* BooksMagazineSearch
* BooksSoftwareSearch
* BooksTotalSearch
* FavoriteBookmarkList
* GoraGolfCourseDetail
* GoraGolfCourseSearch
* GoraPlanSearch
* HighCommissionShop
* HotelDetailSearch
* HotelRanking
* IchibaItemRanking
* IchibaItemSearch
* ItemCodeSearch
* ItemRanking
* ItemSearch
* KeywordHotelSearch
* ProductSearch
* RecipeCategoryRanking
* SimpleHotelSearch
* VacantHotelSearch

Example:

```php
<?php

require_once '/path/to/sdk-dir/autoload.php';

$client = new RakutenRws_Client();
$client->setApplicationId('YOUR_APPLICATION_ID');
$client->setAffiliateId('YOUR_AFFILIATE_ID');

$response = $client->execute('ItemSearch', array(
  'keyword' => 'うどん'
));

if ($response->isOk()) {
    // You can access data using foreach
    foreach ($response as $item) {
        echo $item['itemName']."\n";
    }
} else {
    echo 'Error:'.$response->getMessage();
}
```

To access APIs that need user's authorization, like the RakutenBookmark API,
you need to get an *access_token* in advance.

First, send the user to the authorization page. You can get the authorization page URL with the following code.
At the same time, please don't forget the scope in *RakutenRws_Client::getAuthorizeUrl()*.

```php
<?php

require_once '/path/to/sdk-dir/autoload.php';

$client = new RakutenRws_Client();
// Set Application ID
$client->setApplicationId('YOUR_APPLICATION_ID');
// Set Application Secret
$client->setSecret('YOUR_APPLICATION_SECRET');
// Set Callback URL
$client->setRedirectUrl('CALLBACK_URL');

// Get authorization page URL with a scope
echo $client->getAuthorizeUrl('rakuten_favoritebookmark_read');
```

If you authorize users, the user's browser is redirected to CALLBACK_URL with code
parameter. Then please exchange code to *access_token*.
You can access API by this *access_token*.

```php
<?php

require_once '/path/to/sdk-dir/autoload.php';

$client = new RakutenRws_Client();
// Set Application ID
$client->setApplicationId('YOUR_APPLICATION_ID');
// Set Application Secret
$client->setSecret('YOUR_APPLICATION_SECRET');
// Set Affiliate ID (Optinal)
$client->setAffiliateId('YOUR_AFFILIATE_ID');
// Set Callback URL
$client->setRedirectUrl('CALLBACK_URL');

// Convert code to access_token
// If the request fails, this method's response is null
if (!$client->fetchAccessTokenFromCode()) {
    echo "Error: Failed to get access_token";
    die();
}

// Get list from FavoriteBookmarkList API
$client->execute('FavoriteBookmarkList', array(
    'hits' => 10
));

if ($response->isOk()) {
  foreach ($response as $item) {
    echo $item['itemName']."\n";
  }
} else {
    echo 'Error:'.$response->getMessage();
}
```

Proxy Configuration
-------------------

You can use this API with a proxy. Please set proxy information with *RakutenRws_Client::setProxy()*.

Example:

```php
<?php

require_once '/path/to/sdk-dir/autoload.php';

$client = new RakutenRws_Client();
// Set proxy
$client->setProxy('proxy-host.example.com:port');
$client->setApplicationId('YOUR_APPLICATION_ID');
$client->setAffiliateId('YOUR_AFFILIATE_ID');

// This request is executed via proxy.
$response = $client->execute('ItemSearch', array(
  'keyword' => 'うどん'
));
```


Sample Code
-----------

- There is sample code in the [sample] (https://github.com/rakuten-ws/rws-php-sdk/tree/master/sample) directory.
- Please rename *config.php.sample* and set Application ID, Application Secret and Affiliate ID.

Official API Document
---------------------

- http://webservice.rakuten.co.jp


SDK API Document
----------------

- [API Docs](http://webservice.rakuten.co.jp/sdkapi/php/)

License
-------

- MIT License
