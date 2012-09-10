<?php

require_once dirname(__FILE__).'/../autoload.php';
require_once dirname(__FILE__).'/config.php';

$itemCode = isset($_GET['itemCode']) ? $_GET['itemCode'] : null;
$keyword  = isset($_GET['keyword'])  ? $_GET['keyword']  : '';
$page     = isset($_GET['page'])     ? $_GET['page']     : 1;

// 必要なパラメータをチェックします
if (!$itemCode) {

    // 検索画面へ戻ります
    header('Location: index.php?keyword='.urlencode($keyword).'&page='.urlencode($page));
    exit();
}

// 現在のリクエストURLを取得します。(リダイレクト用)
$port = ':'.$_SERVER['SERVER_PORT'];
$isSecure = (isset($_SERVER['SSL']) && $_SERVER['SSL'] == 'on');
$scheme = 'http';
if ($isSecure) {
    $scheme = 'https';
}
if ($scheme == 'http' && $port == ':80' || $scheme == 'https' && $port == ':443') {
    $port = '';
}
$url = $scheme.'://'.$_SERVER['HTTP_HOST'].$port.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

// Clientインスタンスを生成
$rwsclient = new RakutenRws_Client();
// アプリIDをセット
$rwsclient->setApplicationId(RAKUTEN_APP_ID);
// Secretをセット
$rwsclient->setSecret(RAKUTEN_APP_SECRET);
// アフィリエイトIDをセット (任意)
$rwsclient->setAffiliateId(RAKUTEN_APP_AFFILITE_ID);
// 認証時リダイレクトURLをセット
$rwsclient->setRedirectUrl($url);

// リクエストに 'code' があった場合、アクセストークンを取得し
// API を実行します。
// If a request has 'code', get access_token and execute API
if ($_GET['code']) {

    // アクセストークンを取得します。
    if ($rwsclient->fetchAccessTokenFromCode()) {

        // Bookmark追加APIを実行します (http://webservice.rakuten.co.jp/api/favoritebookmarkadd/)
        $response = $rwsclient->execute('FavoriteBookmarkAdd', array(
            'itemCode' => $_GET['itemCode']
        ));
    }

    // 検索画面へ戻ります
    header('Location: index.php?keyword='.urlencode($keyword).'&page='.urlencode($page).'&m=1');
    exit;
}

// パラメーターに 'code' がない場合は、rakuten_favoritebookmark_update scope の
// 承認画面へ遷移します
header('Location: '.$rwsclient->getAuthorizeUrl('rakuten_favoritebookmark_update'));
exit;
