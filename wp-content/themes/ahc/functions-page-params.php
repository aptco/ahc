<?php
global $page_params, $type_params, $slug_params, $jp_names, $top_banners;
global $all_post_types, $category_post_types;
global $truecolors_transfer_id;

$all_post_types = array(
	"page",
	"article",
	"magazine",
	"book",
	"goods",
	"seminar",
	"lecturer",
	"course"
);

$category_post_types = array(
	"page",
	"article"
);

$jp_names["出版物"] = "publication";

$truecolors_transfer_id = 4815;

$type_params = array(
	"page" => array(
		'root_name'		=> "カテゴリトップ",
		'jp_name'		=> "カテゴリトップ",
		'taxonomy_name' => "category",
		'class_name' 	=> "other"
	),
	"article" => array(
		'root_name'		=> "ページ",
		'jp_name'		=> "ページ",
		'taxonomy_name' => "category",
		'class_name' 	=> "other"
	),
	"magazine" => array(
		'root_name'		=> "商品",
		'jp_name'		=> "雑誌",
		'taxonomy_name' => "category-item",
		'class_name' 	=> "publication"
	),
	"book" => array(
		'post_type'		=> "book",
		'root_name'		=> "商品",
		'jp_name'		=> "書籍",
		'taxonomy_name' => "category-item",
		'class_name' 	=> "publication"
	),
	"goods" => array(
		'root_name'		=> "商品",
		'jp_name'		=> "予防教育グッズ",
		'taxonomy_name' => "category-item",
		'class_name' 	=> "publication"
	),
	"seminar" => array(
		'root_name'		=> "セミナー",
		'jp_name'		=> "セミナー",
		'taxonomy_name' => "category-seminar",
		'class_name' 	=> "seminar"
	),
	"lecturer" => array(
		'root_name'		=> "講師",
		'jp_name'		=> "講師",
		'taxonomy_name' => "",
		'class_name' 	=> "lecturer"
	),
	"course" => array(
		'root_name'		=> "通信講座",
		'jp_name'		=> "通信講座",
		'taxonomy_name' => "category-course",
		'class_name' 	=> "course"
	),
	"lecture" => array(
		'root_name'		=> "講演・出張講座",
		'jp_name'		=> "講演・出張講座",
		'taxonomy_name' => "",
		'class_name' 	=> "lecture"
	)
);

$slug_params = array(
	"publication" => array(
		'post_type'		=> array("magazine", "book"),
		'category-slug'	=> "publications",
		'banner' 		=> "header_banner_publication.jpg"
	),
	"magazine" => array(
		'post_type'		=> "magazine",
		'category-slug'	=> "magazines",
		'banner' 		=> "header_banner_publication.jpg"
	),
	"magazine-be" => array(
		'post_type'		=> "magazine",
		'category-slug'	=> "be",
		'banner' 		=> "header_banner_publication.jpg"
	),
	"book" => array(
		'post_type'		=> "book",
		'category-slug'	=> "books",
		'banner' 		=> "header_banner_publication.jpg"
	),
	"goods" => array(
		'post_type'		=> "goods",
		'category-slug'	=> "educationgoods",
		'banner' 		=> "header_banner_goods.jpg"
	),
	"seminar" => array(
		'post_type'		=> "seminar",
		'category-slug'	=> "セミナー",
		'banner' 		=> "header_banner_seminar.jpg"
	),
	"lecturer" => array(
		'post_type'		=> "lecturer",
		'category-slug'	=> "講師",
		'banner' 		=> "header_banner_lecturer.jpg"
	),
	"course" => array(
		'post_type'		=> "course",
		'category-slug'	=> "通信講座",
		'banner' 		=> "header_banner_course.jpg"
	),
	"lecture" => array(
		'post_type'		=> "article",
		'category-slug'	=> "講演・出張講座",
		'banner' 		=> "header_banner_lecture.jpg"
	)
);

$page_params = array(
	//トップページ（スライド）
	"top-slides" => array(
		'id' => 81
	),
	//トップページ（イベント） 
	"top-events" => array(
		'id' => 83
	),
	//トップページ（リンク） 
	"top-links" => array(
		'id' => 4701
	),
	"hajimeni_1" => array(
		'name' => '自分らしく生きるとは？',
		'id' => 4743,
		'priority' => 3
	),
	"hajimeni_2" => array(
		'name' => '対人援助のスキルを磨く',
		'id' => 4747,
		'priority' => 3
	),
	"hajimeni_3" => array(
		'name' => '依存症の当事者と家族のために',
		'id' => 4746,
		'priority' => 3
	),
	"seminars" => array(
		'name' => 'セミナー',
		//'id' => 145,
		'id' => 8433,
		'priority' => 1
	),
	"publications" => array(
		'name' => '出版物',
		'id' => 147,
		'priority' => 1
	),
	"be" => array(
		'name' => '季刊Be!',
		'id' => 0,
		'url' => "./items/be",
		'priority' => 1
	),
	"goods" => array(
		'name' => '予防教育グッズ',
		'id' => 149,
		'priority' => 1
	),
	"courses" => array(
		'name' => '通信講座',
		'id' => 4586,
		'priority' => 1
	),
	"lectures" => array(
		'name' => '講演・出張講座',
		'id' => 4588,
		'priority' => 1
	),
	"lecturers" => array(
		'name' => '講師紹介',
		'id' => 155,
		'priority' => 1
	),
	"about" => array(
		'name' => 'アスク・ヒューマン・ケアとは',
		'id' => 119,
		'priority' => 2
	),
	"whats-new" => array(
		'name' => 'お知らせ',
		'id' => 113,
		'priority' => 3
	),
	/*
	2020/03/16
	"faq" => array(
		'name' => 'よくある質問',
		'id' => 115,
		'priority' => 2
	),
	*/
	"contact" => array(
		'name' => 'お問い合わせ',
		'id' => 122,
		'priority' => 3
	),
	"access" => array(
		'name' => '交通案内',
		'id' => 143,
		'priority' => 2
	),
	"sitemap" => array(
		'name' => 'サイトマップ',
		'id' => 141,
		'priority' => 2
	),
	"glossary" => array(
		'name' => 'アディクション用語集',
		'id' => 6591,
		'priority' => 2
	),
	"ahc-mailmag" => array(
		'name' => 'AHC便り',
		'id' => 5323,
		'priority' => 2
	)
);

foreach($page_params as $key=>$entry)
{
	if (!array_key_exists('url', $entry))
	{
		if ($entry['id'] != 0) $page_params[$key]['url'] = get_permalink($entry['id']);
		else $entry['url'] = "";
	}
}

foreach($type_params as $key=>$type)
{
	$jp_names[$type['jp_name']] = $key;
}

function get_global_url($key)
{
	global $page_params;

	if (array_key_exists($key, $page_params))
	{
		return $page_params[$key]['url'];
	}
}

function get_post_type_from_category($term_id, $taxonomy_name)
{
	global $slug_params;

	if ($taxonomy_name == "category")
	{
		return array("page", "article");
	}
	else if ($taxonomy_name == $slug_params["seminar"]['category-slug'])
	{
		return  $slug_params["seminar"]['post_type'];
	}
	else if ($taxonomy_name == $slug_params["course"]['category-slug'])
	{
		return  $slug_params["course"]['post_type'];
	}
	else
	{
		$ancestors = get_ancestors($term_id, $taxonomy_name);

		foreach($ancestors as $term_id2)
		{
			$term2 = get_term($term_id2, $taxonomy_name);
			$term_name = $term2->name;

			if ($term_name == "雑誌")
			{
				return  $slug_params["magazine"]['post_type'];
				break;
			}
			else if ($term_name == "書籍")
			{
				return  $slug_params["book"]['post_type'];
				break;
			}
			else if ($term_name == "予防教育グッズ")
			{
				return  $slug_params["goods"]['post_type'];
				break;
			}
		}
	}

	return "";
}