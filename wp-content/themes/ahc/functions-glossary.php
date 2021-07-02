<?php
global $glossary_anchor;
$glossary_anchor = "term-";

function update_glossary_entries()
{
	global $post_ids, $glossary_cats, $glossary_anchor;

	$post_id = $post_ids["glossary"];
	$field_name = 'glossary-entry';

	$page_url = get_permalink($post_id);

	$glossary_cats = array();
	$nav_list = array();

	$tmp = array();

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$furigana = get_sub_field('furigana');
		$fi = mb_substr($furigana, 0, 1);

		$data = array(
			"category" => $fi,
			"name" => get_sub_field('name'),
			"furigana" => get_sub_field('furigana'),
			"content" => get_sub_field('content')
		);

		$tmp[] = $data;

	endwhile;

	usort($tmp, function($a, $b)
	{
		$av = $a["furigana"];
		$bv = $b["furigana"];
		if ($av == $bv) return 0;
		else return ($av < $bv)?-1:1;
	}
	);

	foreach($tmp as $ti => $data)
	{
		$tid = $glossary_anchor . ($ti + 1);

		$fi = $data["category"];

		$data["id"] = $tid;
		$data["url"] = "#" . $tid;

		if (!array_key_exists($fi, $glossary_cats))
		{
			$glossary_cats[$fi] = array();
			$glossary_cats[$fi]["list"] = array();
		}

		$glossary_cats[$fi]["list"][] = $data;
	}

	foreach($glossary_cats as $fi => $fEntry)
	{
		$data = $fEntry["list"][0];

		$eAry = array(
			'name' => $fi,
			'url'  => $data["url"],
			'list' => array()
		);

		foreach($fEntry["list"] as $data)
		{
			$entry = array(
				'name' => $data["name"],
				'url'  => $data["url"]
			);

			$eAry["list"][] = $entry;
		}

		$nav_list[] = $eAry;
	}

	global $side_nav_datas;

	$data = array(
		'type'		=> "nav",
		'list'		=> $nav_list,
		'current'	=> -1
	);

	$side_nav_datas = array($data);
}

function sort_glossary_posts($posts)
{
	global $glossary_cats, $glossary_anchor, $side_nav_datas;

	$glossary_cats = array();
	$nav_list = array();
	$tmp = array();

	foreach($posts as $i => $entry)
	{
		$furigana = get_field('term-furigana', $entry->ID);
		$fi = mb_substr($furigana, 0, 1);

		$data = array(
			"category" => $fi,
			"name" => $entry->post_title,
			"furigana" => $furigana,
			"content" => $entry->post_content
		);

		$tmp[] = $data;
	}

	usort($tmp, function($a, $b)
	{
		$av = $a["furigana"];
		$bv = $b["furigana"];
		if ($av == $bv) return 0;
		else return ($av < $bv)?-1:1;
	}
	);

	foreach($tmp as $ti => $entry)
	{
		$tid = $glossary_anchor . ($ti + 1);

		$fi = $entry["category"];
		$entry["id"] = $tid;
		$entry["url"] = "#" . $tid;

		if (!array_key_exists($fi, $glossary_cats))
		{
			$glossary_cats[$fi] = array();
			$glossary_cats[$fi]["list"] = array();
		}

		$glossary_cats[$fi]["list"][] = $entry;
	}

	foreach($glossary_cats as $fi => $fEntry)
	{
		$entry = $fEntry["list"][0];

		$eAry = array(
			'name' => $fi,
			'url'  => $entry["url"],
			'list' => array()
		);

		foreach($fEntry["list"] as $entry)
		{
			$entry = array(
				'name' => $entry["name"],
				'url'  => $entry["url"]
			);

			$eAry["list"][] = $entry;
		}

		$nav_list[] = $eAry;
	}

	$data = array(
		'type'		=> "nav",
		'list'		=> $nav_list,
		'current'	=> -1
	);

	$side_nav_datas = array($data);
}

function write_list_of_glossary()
{
	global $glossary_cats;

	$str = "";
	$tabs = get_tabs(3);

	$str .= $tabs . '<div class="section glossary">' . "\n";

	foreach ($glossary_cats as $ci => $entry)
	{
		foreach ($entry['list'] as $i => $data)
		{
			$id = $data["id"];
			$name = $data["name"];
			$content = $data["content"];

			$str .= $tabs . '	<dl id="' . $id . '">' . "\n";
			$str .= $tabs . '		<dt>' . $name . '</dt>' . "\n";
			$str .= $tabs . '		<dd>' . "\n";
			$str .= $tabs . '			' . $content . "\n";
			$str .= $tabs . '		</dd>' . "\n";
			$str .= $tabs . '	</dl>' . "\n";
		}
	}

	$str .= $tabs . '</div>' . "\n";

	echo $str;
}