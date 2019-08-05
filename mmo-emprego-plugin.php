<?php

/*

Plugin Name: Funções MMO Emprego

Plugin URI: http://www.mmo.co.mz

Description: Funcões e Tweaks

Author: Matope José

Version: 1.0

Author URI: http://www.matopejose.com

License: GPL2

*/

add_theme_support( 'infinite-scroll', array(
    'container'  => 'content',
    'footer'     => 'page',
) );

//CPT RSS//
function add_cpts_to_rss_feed( $args ) {

  if ( isset( $args['feed'] ) && !isset( $args['post_type'] ) )

    $args['post_type'] = array('post', 'carreira', 'recursos');

  return $args;

}

add_filter( 'request', 'add_cpts_to_rss_feed' );

//CPT Home//
add_filter( 'pre_get_posts', 'my_get_posts' );

function my_get_posts( $query ) {

    if ( is_home() && $query->is_main_query())

        $query->set( 'post_type', array( 'post', 'carreira', 'job_listing' ) );

    return $query;

}

//CPT Arquivos//
function namespace_add_custom_types( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array(
     'post', 'carreira', 'job_listing', 'recursos', 'formacao'
		));
	  return $query;
	}
}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );

//CPT Pesquisa//

//IMAGEM NO RSS//
function insertThumbnailRSS($content) {
global $post;
if ( has_post_thumbnail( $post->ID ) ){
$content = '' . get_the_post_thumbnail( $post->ID, 'full', array( 'alt' => get_the_title(), 'title' => get_the_title(), 'style' => 'float:right;' ) ) . '' . $content;
}
return $content;
}
add_filter('the_excerpt_rss', 'insertThumbnailRSS');
add_filter('the_content_feed', 'insertThumbnailRSS');
 
//Ad no Post.

add_filter( 'the_content', 'prefix_insert_post_ads' );

function prefix_insert_post_ads( $content ) {
	
	$ad_code = '<div><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 640 Notícias -->
<ins class="adsbygoogle"
     style="display:inline-block;width:640px;height:300px"
     data-ad-client="ca-pub-7420809296059746"
     data-ad-slot="3175858541"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>';

	if ( is_single() && ! is_admin() ) {
		return prefix_insert_after_paragraph( $ad_code, 4, $content );
	}
	
	return $content;
}
 
// Parent Function that makes the magic happen
 
function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p = '</p>';
	$paragraphs = explode( $closing_p, $content );
	foreach ($paragraphs as $index => $paragraph) {

		if ( trim( $paragraph ) ) {
			$paragraphs[$index] .= $closing_p;
		}

		if ( $paragraph_id == $index + 1 ) {
			$paragraphs[$index] .= $insertion;
		}
	}
	
	return implode( '', $paragraphs );
}