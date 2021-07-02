<?php

function write_sitemap()
{
	global $page_params;

	//Get Data
	$sitemap = array();

	//はじめに
	$ary = get_sitemap_children_from_page("はじめに", "article", 0, 0, 1);
	foreach($ary as $i=>$obj) $sitemap[] = $obj;

	//セミナー
	//$sitemap[] = get_sitemap_from_taxonomy("セミナー", $page_params["seminars"]["url"], "category-seminar", 1);
	//$sitemap[] = get_sitemap_object("セミナー", $page_params["seminars"]["url"]);

	//出版物、予防教育グッズ
	$taxonomy_name = "category-item";
	$ary = get_sitemap_children($taxonomy_name, 0, 0, 3);
	foreach($ary as $i=>$obj) $sitemap[] = $obj;

	//通信講座
	$sitemap[] = get_sitemap_from_taxonomy("通信講座", $page_params["courses"]["url"], "category-course", 1);

	//講演・出張講座
	$sitemap[] = get_sitemap_from_category("講演・出張講座", $page_params["lectures"]["url"], "講演・出張講座", "article", 1);

	//講師紹介
	$sitemap[] = get_sitemap_object("講師紹介", $page_params["lecturers"]["url"]);

	//Write HTML
	$str = "";
	$tabs = get_tabs(3);

	$str .= $tabs .'<div class="section sitemap">' . "\n";

	$str .= get_sitemap_html($sitemap, 4);

	$str .= $tabs .'</div>' . "\n";

	echo $str;
}

function get_sitemap_object($name, $url)
{
	return array(
		"name" => $name,
		"url" => $url
	);
}

function get_sitemap_from_taxonomy($root_name, $url, $taxonomy_name, $max_depth)
{
	$obj = get_sitemap_object($root_name, $url);

	$obj["list"] = get_sitemap_children($taxonomy_name, 0, 0, $max_depth);

	return $obj;
}

function get_sitemap_from_category($root_name, $url, $category_name, $post_type, $max_depth)
{
	$obj = get_sitemap_object($root_name, $url);

	$obj["list"] = get_sitemap_children_from_page($category_name, $post_type, 0, 0, $max_depth);

	return $obj;
}

function get_sitemap_children($taxonomy_name, $parent_id, $depth, $max_depth)
{
	$ary = array();

	$cats = get_custom_categories($taxonomy_name, $parent_id);
 
	foreach($cats as $cat)
	{
		$obj = get_sitemap_object($cat->name, get_term_link($cat));

		if ($depth < $max_depth)
		{
			$id = $cat->term_id;
			$obj["list"] = get_sitemap_children($taxonomy_name, $id, $depth + 1, $max_depth);
		}

		$ary[] = $obj;
	}

	return $ary;
}

function get_sitemap_children_from_page($category_name, $post_type, $parent_id, $depth, $max_depth)
{
	$ary = array();

	$posts = get_posts_from_category($category_name, $post_type, $parent_id);

	foreach($posts as $i=>$post)
	{
		$obj = get_sitemap_object($post->post_title, get_permalink($post));

		if ($depth < $max_depth)
		{
			$id = $post->ID;
			$obj["list"] = get_sitemap_children_from_page($category_name, $post_type, $id, $depth + 1, $max_depth);
		}

		$ary[] = $obj;
	}

	return $ary;
}

function get_posts_from_category($category_name, $post_type, $parent_id = 0)
{
	$cat = get_term_by('name', $category_name, 'category');

	$args = array(
		'order'			=> 'ASC',
		'orderby' 		=> 'name',
		'hierarchical'  => true,
		'post_type' => $post_type,
		'category' => $cat->term_id,
		'post_parent' => $parent_id
	);

	return get_posts($args);
}

function get_sitemap_html($array, $is_root, $tabnum = 3)
{
	$str = "";
	$tabs = get_tabs($tabnum);

	foreach($array as $i=>$obj)
	{
		$ultag = '<ul';
		if ($is_root) $ultag .= ' class="clearfix"';
		$ultag .= '>';

		if (!$is_root || $i % 3 == 0) $str .= $tabs . $ultag . "\n";

		$str .= $tabs . '	<li>' . "\n";
		$str .= $tabs . '		' . get_alink_html($obj["name"], $obj["url"]) . "\n";

		if (array_key_exists("list", $obj))
		{
			$str .= get_sitemap_html($obj["list"], false, $tabnum + 2);
		}

		$str .= $tabs . '	</li>' . "\n";

		if (!$is_root || ($i + 1) % 3 == 0) $str .= $tabs . '</ul>' . "\n";
	}

	return $str;
}