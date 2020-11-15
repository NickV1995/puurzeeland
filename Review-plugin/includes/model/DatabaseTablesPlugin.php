<?php
/**
 * Created by PhpStorm.
 * User: Nick Vinke
 * Date: 7-11-2019
 * Time: 20:47
 */

class DatabaseTablesPlugin {


    public static function CreateTables() {

        DatabaseTablesPlugin::CreateReviewTable();

        DatabaseTablesPlugin::CreateReviewLabelTable();
    }

    public static function CreateReviewTable(){

        global $wpdb;
        // Create database tables
        $sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix .  "review` (
    `review_id` bigint(10) NOT NULL,
    `naam` varchar(64) NOT NULL,
    `recensie` varchar(1024) NOT NULL,
    `review_datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `goedgekeurd` varchar(13) NOT NULL DEFAULT 'In afwachting',
    `label` varchar(32) NOT NULL,
    PRIMARY KEY id (review_id)
    );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function CreateReviewLabelTable(){

        global $wpdb;
        // Create database tables
        $sql1 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix .  "review_label` (
    `id_label` bigint(10) NOT NULL,
    `label` varchar(32) NOT NULL,
    `description` varchar(32) NOT NULL,
    PRIMARY KEY id (id_label),
    UNIQUE KEY `index` (`label`)
    );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql1);
    }
}