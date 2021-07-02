<?php 
/**
 * @package ahc-ahc
 */
global $body_id, $gnav_datas;
get_global_nav();

if(is_home())
{
	$page_title = get_bloginfo('name');
}
else
{
	$page_title = get_the_title() . " ｜ " . get_bloginfo('name');
}

?><!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="description" content="<?php echo wp_trim_words(get_contents_for_list(), 400);?>">
	<title><?php echo $page_title?></title>

	<link rel="stylesheet" href="<?php assets_dir();?>css/reset.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri();?>?20210331" type="text/css" />
<?php if(is_home()): ?>
	<link rel="stylesheet" href="<?php assets_dir();?>css/top.css" type="text/css" />
<?php else: ?>
	<link rel="stylesheet" href="<?php assets_dir();?>css/second.css" type="text/css" />
<?php endif; ?>
	<link rel="stylesheet" href="<?php assets_dir();?>css/parts.css" type="text/css" />
	<link href="<?php assets_dir();?>font-awesome/font-awesome.min.css" rel="stylesheet">
	<link href="<?php assets_dir();?>css/plugins/jquery.bxslider.css" rel="stylesheet">
	<link href="<?php assets_dir();?>css/plugins/drawer.min.css" rel="stylesheet">

	<?php include_once "typesquare.php"; ?>
	<?php include_once "ogp.php"; ?>
	<?php include_once "ga.php"; ?>
<?php wp_head(); ?>
</head>
<body<?php if($body_id) echo' id="' . $body_id .'"'; ?>>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<!-- 共通ヘッダ -->
	<header id="header"> 
		
		<!-- ロゴエリア -->
		<div id="logo-area" class="clearfix">
			<div class="fl">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php assets_dir();?>images/common/ahc_logo.png" alt="自分らしい生き方応援します アスク・ヒューマン・ケア 特定非営利活動法人ASK 事業部" class="logo"></a></div>
			<div class="fr">
				<ul class="primary-navi">
<?php echo $gnav_datas[1];?>
				</ul>
				<ul class="btn-area">
					<li class="shop-pc">
						<a href="<?php echo get_field('shop-top-url-pc', 'option'); ?>"><img src="<?php assets_dir();?>images/common/btn_shop.png" alt="AHCオンラインショップ"></a>
					</li>
					<li class="shop-sp">
						<a href="<?php echo get_field('shop-top-url-sp', 'option'); ?>">AHCオンラインショップ</a>
					</li>
					<li class="contact">
						<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><img src="<?php assets_dir();?>images/common/btn_contact.png" alt="お問い合わせ"></a>
					</li>
					<li class="search">
<?php get_search_form(); ?>					
					</li>
				</ul>
			</div>
		</div>
		<!-- ロゴエリア --> 
		
		<!-- メニュー -->
		<div id="menu">
			<ul class="global_navi">
<?php echo $gnav_datas[0];?>
			</ul>
		</div>
		<!-- //メニュー --> 
		
	</header>
	<!-- // 共通ヘッダ -->

	<!-- スマホメニュー -->
	<div id="menu-mobile">
		<div class="menu-hamburger">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
		<nav class="mobile-navi" role="navigation">
			<div class="wrapper">
<?php echo get_mobile_local_navi();?>
				<ul class="global">
<?php echo $gnav_datas[2];?>
				</ul>
			</div>
		</nav>
		<div class="overlay"></div>
	</div>
	<!-- //スマホメニュー --> 

<?php
if(!(is_home())) 
{
	include_once "parts-page-header.php";
}

