<?php

function get_page_header($slug = null, $post_id = null)
{
	if ($slug == null)
	{
		global $post;
		$slug = $post->post_type;
	}

	$imgurl = "";

	if (get_field("title-img-changed", $post_id) == 1)
	{
		$imgurl = get_field("title-img", $post_id);
	}

	$title = get_the_title($post_id);
	
	if ($imgurl == "")
	{
		$banner_img = get_top_banner_from_slug($slug);
		if ($banner_img) $imgurl = get_assets_dir() . 'images/' . $banner_img;
	}

	if ($imgurl != "") get_img_page_header($imgurl, $title);
	else get_text_page_header($title);
}

function get_img_page_header($imgurl, $title)
{
	$str = '';
	$str .=	'<img src="' .  $imgurl . '" alt="' . $title .'">';
	write_header_template($str);
}

function get_text_page_header($title)
{
	$str = '';
	$str .=	'<div class="wrapper">';
	$str .=	'	<div class="page-title">';
	$str .=	'		<h1>' . $title . '</h1>';
	$str .=	'	</div>';
	$str .=	'</div>';
	write_header_template($str);
}

function write_header_template($html)
{
?>
<!-- タイトルエリア -->
<div class="area banner">
<?php echo $html ?>
</div>
<!-- // タイトルエリア -->
<?php
get_breadcrumbs();
}

function get_breadcrumbs()
{
?>
<!-- パンくず -->
<div id="breadcrumb">
  <div class="wrapper">
  	<?php if(function_exists('bcn_display')) bcn_display(); ?>
  </div>
</div>
<!-- //パンくず -->
<?php
}