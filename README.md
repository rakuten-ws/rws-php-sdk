Rakuten Web Service SDK for PHP
===============================

[![Build Status](https://secure.travis-ci.org/rakuten-ws/rws-php-sdk.png?branch=master)](http://travis-ci.org/rakuten-ws/rws-php-sdk)

Rakuten Web Service SDK for PHP は、PHPアプリケーションから
楽天が提供しているAPIに、簡単にアクセスすることができるSDK
(Software Development Kit)です。

動作要件
--------

- PHP5.2.3以上 (PHP5.2.10以上, [curl拡張](http://php.net/manual/ja/book.curl.php) 導入を推奨)
- PHP5.2.10未満を利用する場合、PEAR の [HTTP_Client] (http://pear.php.net/manual/ja/package.http.http-client.php)
  か curl拡張の導入が必要です。

基本的な使い方
--------------

事前に、楽天ウェブサービスのドキュメントページ(http://webservice.rakuten.co.jp)
にて、アプリ登録を行ってください。

このドキュメントと同じディレクトリにある *autoload.php* を読み込むことにより、
SDK の利用準備が整います。

ユーザ認証の必要のない、APIについては、以下のように情報を取得することができます。

    require_once '/path/to/sdk-dir/autoload.php';

    $client = new RakutenRws_Client();
    // アプリID (デベロッパーID) をセットします
    $client->setApplicationId('YOUR_APPLICATION_ID');

    // アフィリエイトID をセットします(任意)
    $client->setAffiliateId('YOUR_AFFILIATE_ID');

    // ItemSearch API から、keyword=うどん を検索します
    $response = $client->execute('ItemSearch', array(
      'keyword' => 'うどん'
    ));

    // レスポンスが正しいかを isOk() で確認することができます
    if ($response->isOk()) {
        // 配列アクセスによりレスポンスにアクセスすることができます。
        var_dump($response['Body']);
    } else {
        echo 'Error:'.$response->getMessage();
    }

*RakutenRws_Client::execute()* には、API名、パラメータ、バージョンを
指定します。そのうち、バージョンについては省略することが可能で、
省略した場合、自動的にSDKが指定した最新バージョンを選択します。

以下のAPIはレスポンスが、Iterator に対応しているため
foreach で 情報(商品情報・施設情報など) を順次取得することが可能です。

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

以下が例です。

    require_once '/path/to/sdk-dir/autoload.php';

    $client = new RakutenRws_Client();
    $client->setApplicationId('YOUR_APPLICATION_ID');
    $client->setAffiliateId('YOUR_AFFILIATE_ID');

    $response = $client->execute('ItemSearch', array(
      'keyword' => 'うどん'
    ));

    if ($response->isOk()) {
        // レスポンスを foreach でアクセスできます
        foreach ($response as $item) {
            echo $item['itemName']."\n";
        }
    } else {
        echo 'Error:'.$response->getMessage();
    }


FavoriteBookmarkAPI (楽天ブックマーク系API) のようなユーザ認証が必要な
APIを使う場合は、 *access_token* を取得する必要があります。

まず、ユーザを認証ページに誘導してください。認証ページのURLは、以下のように取得することができます。
この時、 *RakutenRws_Client::getAuthorizeUrl()* には、API利用スコープを設定することを忘れないください。

    require_once '/path/to/sdk-dir/autoload.php';

    $client = new RakutenRws_Client();
    // アプリID (デベロッパーID) をセットします
    $client->setApplicationId('YOUR_APPLICATION_ID');
    // Secret をセットします
    $client->setSecret('YOUR_APPLICATION_SECRET');
    // リダイレクトURL (ログイン後に戻ってくるURL) をセットします
    $client->setRedirectUrl('CALLBACK_URL');

    // 認証ページへのURLを取得します
    // APIドキュメントを参照の上、利用スコープを指定してください
    echo $client->getAuthorizeUrl('rakuten_favoritebookmark_read');

認証が成功すると、CALLBACK_URL に code というパラメータ付きで
戻されます。以下のように、code から access_token を取得することができます。

    require_once '/path/to/sdk-dir/autoload.php';

    $client = new RakutenRws_Client();
    // アプリID (デベロッパーID) をセットします
    $client->setApplicationId('YOUR_APPLICATION_ID');
    // Secret をセットします
    $client->setSecret('YOUR_APPLICATION_SECRET');
    // アフィリエイトID をセットします (任意)
    $client->setAffiliateId('YOUR_AFFILIATE_ID');
    // リダイレクトURL (ログイン後に戻ってくるURL) をセットします
    $client->setRedirectUrl('CALLBACK_URL');

    // code から access_token を取得します
    // 失敗すると null となります
    if (!$client->fetchAccessTokenFromCode()) {
        echo "Error: アクセストークン取得失敗";
        die();
    }

    // FavoriteBookmarkList で お気に入りブックマークを
    // 10件取得します
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

プロキシの設定
--------------

*RakutenRws_Client::setProxy()* で、プロキシを通してAPIにアクセスすることができます。

以下が利用例になります

    require_once '/path/to/sdk-dir/autoload.php';

    $client = new RakutenRws_Client();
    $client->setProxy('proxy-host.example.com:port');
    $client->setApplicationId('YOUR_APPLICATION_ID');
    $client->setAffiliateId('YOUR_AFFILIATE_ID');

    // このリクエストは、プロキシを通して行われます。
    $response = $client->execute('ItemSearch', array(
      'keyword' => 'うどん'
    ));


サンプルコード
-------------

- [sample] (https://github.com/rakuten-ws/rws-php-sdk/tree/master/sample) ディレクトリにサンプルを用意しています。
- config.php.sample を config.php にリネームし、アプリID, application_secret をセットすることで動作します。

公開APIドキュメント
-------------------

- http://webservice.rakuten.co.jp

Composer での入手
-----------------

RWS PHP SDK は、[Packagist](http://packagist.org/) にパッケージ登録を行っています。
そのため、 [Composer](http://getcomposer.org/) を通してパッケージを入手することができます。

- composer を入手します

  curl -s http://getcomposer.org/installer | php

- あなたの開発プロジェクトのルートに composer.json を作成します。

    {
        "require": {
            "rakuten-ws/rws-php-sdk": "1.*"
        }
    }

- composer を通してパッケージを入手します

  php composer.phar install

SDK API Document
----------------

- [API Docs](http://webservice.rakuten.co.jp/sdkapi/php/)

ライセンス
----------

- MIT License

バグ報告・コントリビュート
--------------------------

この SDK は、オープンソースです。 MIT License の下で利用することができます。

もし、あなたがSDK中に間違えを見つけた場合は、[こちら] (https://github.com/rakuten-ws/rws-php-sdk/issues)から
バグ報告を行ってください。

また、Pull Request を歓迎しております。
Pull Request を行う場合は、[こちらのレポジトリ] (https://github.com/rakuten-ws/rws-php-sdk) に対して、
送信してください。
