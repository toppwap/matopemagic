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

Just add your custom funtions here, just like the example above

//Custom Post Types to RSS
function add_cpts_to_rss_feed( $args ) {

  if ( isset( $args['feed'] ) && !isset( $args['post_type'] ) )

    $args['post_type'] = array('post', 'customhere', 'custom 2 here');

  return $args;

}
