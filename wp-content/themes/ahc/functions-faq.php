<?php
global $faq_anchor;
$faq_anchor = "category-";

function get_faq_categories()
{
	global $post_ids;

	return split_newline_to_array( get_field('faq-categories', $post_ids["faq"]) );
}

function update_faq_entries()
{
	global $post_ids, $faq_top, $faq_cats, $faq_anchor;

	$post_id = $post_ids["faq"];
	$field_name = 'faq-entry';

	$page_url = get_permalink($post_id);

	$faq_top = array();
	$faq_cats = array();
	$nav_list = array();

	$cat_names = get_faq_categories();

	foreach($cat_names as $ci=>$name)
	{
		$eAry = array(
			'name' => $name,
			'url'  => "#" . $faq_anchor . ($ci + 1)
		);

		$nav_list[] = $eAry;

		$faq_cats[] = array(
			'category'	=> $name,
			'list'		=> array(),
		);
	}

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$cat_name = get_sub_field('select-faq-cats');

		$ci = array_search($cat_name, $cat_names);
		$cii = count($faq_cats[$ci]['list']);

		$qid = "q" . ($ci + 1) . "-" . ($cii + 1);

		$data = array(
			"category" => $cat_name,
			"question" => get_sub_field('question'),
			"answer" => get_sub_field('answer'),
			"id" => $qid,
			"url" => $page_url . "#" . $qid
		);

		if (get_sub_field('list-on-top') == 1)
		{
			$faq_top[] = $data;
		}		
		
		$faq_cats[$ci]['list'][] = $data;

	endwhile;

	global $side_nav_datas;

	$data = array(
		'type'		=> "nav",
		'list'		=> $nav_list,
		'current'	=> -1
	);

	$side_nav_datas = array($data);
}

function write_list_of_faq_for_home($num = 0)
{
	global $faq_top;

	$str = "";
	$tabs = get_tabs(3);

	foreach ($faq_top as $i => $data)
	{
		$question = $data["question"];

		$str .= $tabs . '<li>'."\n";
		$str .= $tabs . '	' . get_alink_html($question, $data["url"], "_self") . "\n";
		$str .= $tabs . '</li>'."\n";

		if ($num > 0 && $i >= $num - 1) break;
	}

	echo $str;
}

function write_list_of_faq()
{
	global $faq_cats, $faq_anchor;

	$str = "";
	$tabs = get_tabs(3);

	$cat_names = get_faq_categories();

	foreach ($faq_cats as $ci => $entry)
	{
		$cat_name = $entry['category'];
		$cn = str_pad($ci + 1, 2, "0", STR_PAD_LEFT);

		$str .= $tabs . '<!-- カテゴリ' . $cn . '-->' . "\n";
		$str .= $tabs . '<div class="section" id="' . $faq_anchor . ($ci + 1) . '">' . "\n";
		$str .= $tabs . '	<h2>' . $cat_name . '</h2>' . "\n";

		foreach ($entry['list'] as $i => $data)
		{
			$question = $data["question"];
			$answer = $data["answer"];
			$id = $data["id"];

			$str .= $tabs . '	<dl class="faq" id="' . $id . '">' . "\n";
			$str .= $tabs . '		<dt>' . $question . '</dt>' . "\n";
			$str .= $tabs . '		<dd>' . "\n";
			$str .= $tabs . '			' . $answer . "\n";
			$str .= $tabs . '		</dd>' . "\n";
			$str .= $tabs . '	</dl>' . "\n";
		}

		$str .= $tabs . '</div>' . "\n";
		$str .= $tabs . '<!-- //カテゴリ' . $cn . ' -->' . "\n";
	}

	echo $str;
}