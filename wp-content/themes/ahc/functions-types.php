<?php
include_once "functions-pub.php";
include_once "functions-lecturer.php";
include_once "functions-seminar.php";

function loop_all_post_types($error_message = "", $query = null)
{
	global $wp_query, $post;

	if (!$query) $query = $wp_query;

	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post();

			switch($post->post_type)
			{
				case "magazine":
				case "book":
				case "goods":
					write_pub_archive();
				break;
				case "seminar":
					write_seminar_archive();
				break;
				case "lecturer":
					write_lecturer_archive();
				break;
				default:
					write_article_archive();
				break;
			}
		endwhile;
?>
		<!-- ページネーション -->
		<?php wp_pagination(); ?>
		<!-- /ページネーション -->
<?php
	else :
		write_error_message($error_message);
	endif;
}