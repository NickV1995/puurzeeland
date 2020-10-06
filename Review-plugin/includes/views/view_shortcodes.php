<?php

add_shortcode('review_plugin_main_view', 'load_main_view');

function load_main_view( $atts, $content = NULL){

  include REVIEW_PLUGIN_INCLUDES_VIEWS_DIR.'/review_plugin_main_view.php';
}