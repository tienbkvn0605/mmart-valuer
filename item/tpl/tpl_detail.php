<?php
/**
 * バルルの詳細画面対応
 * 
 * 2024-02-09   新規作成    ダット
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
    <title><?php echo $title ?? ''?></title>
	<meta name="description" content="<?php echo $description ?? ''?>">
	<meta name="keywords" content=<?php echo $keywords ?? ''?>">	
	<link rel="stylesheet" type="text/css" media="all" href="https://www.bnet.gr.jp/css/fav_item_v2.css?<?php echo time()?>"/>
	<link rel="stylesheet" type="text/css" media="all" href="https://www.bnet.gr.jp/css/fav_item_popup.css?<?php echo time()?>"/>
	<link rel="stylesheet" href="css/reset.css?<?php echo time() ?>">
	<link rel="stylesheet" href="css/footer.css?<?php echo time() ?>">
	<link rel="stylesheet" href="css/common.css?<?php echo time() ?>">
	<link rel="stylesheet" href="css/style.css?<?php echo time() ?>">
	<link rel="stylesheet" href="css/detail.css?<?php echo time() ?>">
	<link rel="stylesheet" href="css/ckeditor5.css?<?php echo time() ?>">
	<link rel="stylesheet" href="css/featherlight.css?<?php echo time() ?>">
	<link rel="stylesheet" href="css/uikit.min.css?<?php echo time() ?>">

	<script src="js/jquery.min.js?<?php echo time()?>"></script>
	<script src="js/uikit.min.js?<?php echo time()?>"></script>
	<script src="js/uikit-icons.min.js?<?php echo time()?>"></script>
	<script src="js/common.js?<?php echo time()?>"></script>
	<script src="js/detail.js?<?php echo time()?>"></script>
	
	<?php echo $sns_info['header'] ?? '';?>
</head>
<body>
	<?php echo $sns_info['body_head'] ?? '';?>
	<div id="fb-root"></div>
	<!-- Container-->
	<div id="top" class="container">
		<?php include_once('tpl_header.php')?>
		<div class="contents clearfix">
			<!-- 商品情報 -->
			<?php include_once('tpl_item_info.php') ?>
			
			<!-- 商品画像 -->
			<?php include_once('tpl_item_images.php') ?>
			<?php include_once('tpl_soryo.php')?>
		</div><!-- /contents -->
		<a id="pageTop" href="#top">↑ページトップへ</a>
	</div><!-- /container -->
	<?php include_once('tpl_footer.php')?>
</body>
</html>