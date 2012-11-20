<?php

require_once dirname(__FILE__).'/../autoload.php';

require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/helper.php';

$response = null;
$keyword  = "";
$page     = 1;
if (isset($_GET['keyword'])) {
    $keyword   = $_GET['keyword'];
    $page      = isset($_GET['page']) ? $_GET['page'] : 1;

    // Clientインスタンスを生成 Make client instance
    $rwsclient = new RakutenRws_Client();
    // アプリIDをセット Set Application ID
    $rwsclient->setApplicationId(RAKUTEN_APP_ID);
    // アフィリエイトIDをセット (任意) Set Affiliate ID (Optional)
    $rwsclient->setAffiliateId(RAKUTEN_APP_AFFILITE_ID);

    // プロキシの設定が必要な場合は、ここで設定します。
    // If you want to set proxy, please set here.
    // $rwsclient->setProxy('proxy');

    // 楽天市場商品検索API2 で商品を検索します
    // Search by IchibaItemSearch (http://webservice.rakuten.co.jp/api/ichibaitemsearch/)
    $response = $rwsclient->execute('IchibaItemSearch', array(
        'keyword' => $keyword,
        'page'    => $page,
        'hits'    => 9
    ));
}

?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Rakuten Web Service SDK - Sample</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<header>
<h1><a href="index.php">Rakuten Web Service SDK - Sample</a></h1>
</header>

<nav class="search-form">
<div>
<!-- Rakuten Web Services Attribution Snippet FROM HERE -->
<a href="http://webservice.rakuten.co.jp/" target="_blank"><img src="http://webservice.rakuten.co.jp/img/credit/200709/credit_31130.gif" border="0" alt="楽天ウェブサービスセンター" title="楽天ウェブサービスセンター" width="311" height="30"/></a>
<!-- Rakuten Web Services Attribution Snippet TO HERE -->
</div>
<form action="index.php" method="GET">
<input id="keyword" class="keyword" name="keyword" type="text" value="<?php echo h($keyword) ?>">
<input type="submit" class="search-button" value="検索">
</form>
</nav>

<?php if (isset($_GET['m']) && $_GET['m'] == '1'): ?>
<div class="notice">
ブックマークへ追加しました
</div>
<?php endif; ?>

<?php if ($response && $response->isOk()): ?>

<div class="pager"><?php echo $pager = pager(
    (int)$page,
    (int)$response['pageCount'],
    '?keyword=%s&amp;page=%d',
    $keyword
) ?></div>

<div id="itemarea">
<ul id="itemlist">
<?php foreach ($response as $item): ?>
<li class="item">

<a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>">
<?php echo h(mb_strimwidth($item['itemName'], 0, 80, '...', 'UTF-8')) ?></a>

<ul>
<?php if (!empty($item['smallImageUrls'][0]['imageUrl'])): ?>
<li class="image"><img src="<?php echo h($item['smallImageUrls'][0]['imageUrl']) ?>"></li>
<?php endif; ?>
<li class="addbookmark"><a href="bookmark.php?itemCode=<?php echo h($item['itemCode']) ?>&amp;keyword=<?php echo h($keyword) ?>&amp;page=<?php echo h($page) ?>">ブックマークへ追加</a></li>
<li class="price"><?php echo h(number_format($item['itemPrice'])) ?>円</li>
<li class="description"><?php echo h($item['itemCaption']) ?></li>
</ul>

</li>
<?php endforeach; ?>
</ul>
</div>
<div class="pager"><?php echo $pager ?></div>
<?php endif; ?>

</body>
</html>
