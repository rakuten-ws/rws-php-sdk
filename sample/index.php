<?php

require_once dirname(__FILE__).'/../autoload.php';
require_once dirname(__FILE__).'/config.php';

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}


$response = null;
if (isset($_GET['keyword'])) {
    $rwsclient = new RakutenRws_Client();
    $rwsclient->setApplicationId(RAKUTEN_APP_ID);
    // $rwsclient->setProxy('PROXY');
    $response = $rwsclient->execute('IchibaItemSearch', array(
        'keyword' => $_GET['keyword'],
        'page' => isset($_GET['page']) ? $_GET['page'] : 1,
    ));
}

?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Rakuten Web Service SDK - Sample</title>
<style>

body {
    font-family: Meiryo,"メイリオ","ＭＳ Ｐゴシック";
}
.item {
    display: block;
    width: 250px;
    float: left;
    margin: 20px;
    padding: 10px;
    background-color: #FFDDFF;
    height: 300px;
    overflow: hidden;
    border: 1px solid #CC0000;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}

.item ul {
    padding: 0;
}

.item ul li {
    display: block;
    margin: 3px;
    padding: 0;
}

.item ul li.description {
    overflow: auto;
    font-size: 10px;
    max-height: 100px;
}

</style>
</head>
<body>
<form action="index.php" method="GET">
<label for="keyword">Keyword</label>
<input id="keyword" name="keyword" type="text">
<input type="submit" value="検索">

</form>
<?php if ($response && $response->isOk()): ?>
<div>
<ul>
<?php foreach ($response as $item): ?>
<li class="item">
<a href="<?php echo h($item['itemUrl']) ?>"><?php echo h($item['itemName']) ?></a>

<ul>
<?php if (!empty($item['smallImageUrls'][0]['imageUrl'])): ?>
<li class="image"><img src="<?php echo h($item['smallImageUrls'][0]['imageUrl']) ?>"></li>
<?php endif; ?>
<li class="addbookmark"><a href="bookmark.php?itemCode=<?php echo h($item['itemCode']) ?>">ブックマークへ追加</a></li>
<li class="price"><?php echo h(number_format($item['itemPrice'])) ?>円</li>
<li class="description"><?php echo h($item['itemCaption']) ?></li>
</ul>

</li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>
</body>
</html>
