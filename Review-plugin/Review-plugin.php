<?php
/*
Plugin Name: Review Plugin
Plugin URI: 
Description: Dit is een Review Plugin
Version: 1.0.0
Author: Jeffrey Scheffers & Nick Vinke
Author URI: https://stichtingivs.nl
License: -
Text Domain: Review-plugin
*/

define('REVIEW_PLUGIN', __FILE__);

require_once plugin_dir_path(__FILE__) . 'includes/defs.php';

register_activation_hook(__FILE__, array('ReviewPlugin', 'on_activation'));

class ReviewPlugin{

  public function __construct(){

  do_action( 'review_pre_init' );

  add_action( 'init', array( $this, 'init' ), 1 );

}

public function init() {
  // Run hook once Plugin has been initialized.
  do_action( 'review_init' );
  // Load admin only components.
  if ( is_admin() ) {

    $this->requireAdmin();

    $this->createAdmin();

  }
  $this->loadViews();

}

public static function on_activation() {
  require_once REVIEW_PLUGIN_MODEL_DIR.'/DatabaseTablesPlugin.php';

  DatabaseTablesPlugin::CreateTables();
}

public function requireAdmin() {
  
  require_once REVIEW_PLUGIN_ADMIN_DIR . '/ReviewPlugin_AdminController.php';
}

  public function createAdmin(){

    ReviewPlugin_AdminController::prepare();
  }


  function loadViews(){

    include REVIEW_PLUGIN_INCLUDES_VIEWS_DIR . '/view_shortcodes.php';
  }

}

$review_plugin = new ReviewPlugin();



