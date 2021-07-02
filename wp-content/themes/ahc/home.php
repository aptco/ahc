<?php
/**
 * @package ahc-ahc
 */
include_once "functions-top.php";
include_once "functions-whatsnew.php";
include_once "functions-faq.php";

global $gnav_datas;
get_global_nav();

get_header();

update_news_entries();
update_faq_entries();
?>

<?php write_title_slider() ?>

<!--  イベントエリア -->
<div class="area event">
	<div class="wrapper">
		<ul class="box">
<?php write_list_for_events() ?>
		</ul>
	</div>
</div>
<!-- // イベントエリア --> 

<!--　コンテンツ　-->
<div id="contents">
	<div class="wrapper"> 
		<!--　悩み別リンク　-->
<?php write_top_article_links(); ?>
		<!--　//　悩み別リンク　--> 
		<!--　コンテンツリンク　-->
<?php write_top_content_links(); ?>
		<!--　//　コンテンツリンク　--> 

		<!--　大バナー　--> 
		<div class="clearfix">
<?php write_list_of_large_banners(); ?>
		</div>
		<!--　// 大バナー　-->

		<!--　小バナー　--> 
<?php write_list_of_small_banners(); ?>
		<!--　// 小バナー　-->
	</div>
	<!--　//　.wrapper　--> 
</div>

<!-- ニュースエリア -->
<div class="area news">
	<div class="wrapper"> 
		<div class="border-list">
			<div class="title">お知らせ</div>
			<div class="link"><a href="whatsnew/"><i class="fa fa-angle-double-right"></i>一覧を見る</a></div>
			<ul class="list">
<?php write_list_of_news_for_home(4); ?>
			</ul>
		</div>
	</div>
</div>
<!-- //　ニュースエリア --> 

<!-- SNSエリア -->
<div class="area sns">
<?php
	$sns_name = "アスク・ヒューマン・ケア";
	$facebook_url = "https://www.facebook.com/askhumancare";
	$twitter_id = "askhumancare";
	$twitter_url = "https://twitter.com/askhumancare";
	$twitter_widget_id = "687301783459201024";
?>
	<div class="wrapper clearfix">
		<div class="box-2-1">
			<div class="fb-page" data-href="<?php echo $facebook_url; ?>" data-tabs="timeline" data-width="500" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
				<div class="fb-xfbml-parse-ignore">
					<blockquote cite="<?php echo $facebook_url; ?>"><a href="<?php echo $facebook_url; ?>"><?php echo $sns_name; ?></a></blockquote>
				</div>
			</div>
		</div>
		<div class="box-2-2"> 
			<a class="twitter-timeline" href="<?php echo $twitter_url; ?>" data-widget-id="<?php echo $twitter_widget_id; ?>">@<?php echo $twitter_id; ?>さんのツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
	</div>
</div>
<!-- //　SNSエリア -->
<?php get_footer(); ?>