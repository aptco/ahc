<?php
include_once "functions-pub.php";

global $body_id;
$body_id = "book-single";

$post_type = "book";
$taxonomy_name = get_taxonomy_name_from_post_type($post_type);

get_nav_list_pub_single($post_type, $taxonomy_name);

get_common();
get_header();
get_page_header($post_type);

include_once "parts-pub-single.php";

get_footer();
?>