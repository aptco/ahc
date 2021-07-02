<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package ahc-tc
 */
get_common();
get_header();
?>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
	<!-- コンテンツ -->
	<div id="content">
		<div class="entry-content p404">
			<i class="fa fa-frown-o"></i>
			<h1>404 not found</h1>
			<h2>お探しのページは見つかりませんでした。</h2>
			<p>
				お探しのページは一時的にアクセスできない状況にあるか、<br />
				移動もしくは削除されたようです。
			</p>
			<ul class="links">
				<li><a href="<?php echo home_url('/'); ?>sitemap/"><i class="fa fa-chevron-circle-right"></i>サイトマップ</a></li>
				<li><a href="<?php echo home_url('/'); ?>"><i class="fa fa-chevron-circle-right"></i>トップページへ戻る</a></li>
			</ul>
		</div><!-- .entry-content -->
	</div>
	<!-- // コンテンツ -->

<?php get_footer(); ?>