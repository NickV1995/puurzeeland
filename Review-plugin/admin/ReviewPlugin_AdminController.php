<?php

class ReviewPlugin_AdminController{

  static function prepare(){

    if (is_admin()):

      add_action('admin_menu', array('ReviewPlugin_AdminController', 'add_admin_menu'));

    endif;
  }

    static function add_admin_menu(){

      add_menu_page(
        'Recensies plug-in',
        'Recensies plug-in',
        'manage_options',
        'review-menu',
        array('ReviewPlugin_AdminController', 'review_admin_main_menu'),
        'dashicons-list-view',
        25);
    
      add_submenu_page(
        'review-menu',
        'Alle Recensies',
        'Nieuwe recensies',
        'manage_options',
        'admin_review_lijst',
        array('ReviewPlugin_AdminController', 'review_admin_main_submenu')
      );
    
      add_submenu_page(
        'review-menu',
        'Alle Recensies',
        'Goedgekeurde recensies',
        'manage_options',
        'admin_review_approved',
        array('ReviewPlugin_AdminController', 'review_admin_main_approved_submenu')
      );
    
    }
    
    static function review_admin_main_menu(){

      include REVIEW_PLUGIN_ADMIN_VIEWS_DIR . '/admin_main.php';
    }

    static function review_admin_main_submenu(){
    
      include REVIEW_PLUGIN_ADMIN_VIEWS_DIR . '/admin_review_lijst.php';
    }
    
    static function review_admin_main_approved_submenu(){
    
      include REVIEW_PLUGIN_ADMIN_VIEWS_DIR . '/admin_review_approved.php';
    }
    
  
  }