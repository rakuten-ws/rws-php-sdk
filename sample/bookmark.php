<?php

require_once dirname(__FILE__).'/../autoload.php';
require_once dirname(__FILE__).'/config.php';

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

if (!isset($_GET['itemCode'])) {
    header('Location: index.php');
    exit();
}


// ----
$rwsclient = new RakutenRws_Client();
$rwsclient->setApplicationId(RAKUTEN_APP_ID);
$rwsclient->setSecret(RAKUTEN_APP_SECRET);
// $rwsclient->setProxy('PROXY');
$rwsclient->setRedirectUrl($url);

if ($_GET['code']) {
    $rwsclient->fetchAccessTokenFromCode();
    $response = $rwsclient->execute('FavoriteBookmarkAdd', array(
        'itemCode' => $_GET['itemCode']
    ));

    header('Location: index.php');
    exit;
}

header('Location: '.$rwsclient->getAuthorizeUrl('rakuten_favoritebookmark_update'));
exit;
