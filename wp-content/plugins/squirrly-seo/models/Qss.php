<?php

/**
 * Connection between Squirrly and Quick Squirrly SEO Table
 * Class SQ_Models_Qss
 */
class SQ_Models_Qss {


    /**
     * Get the Sq for a specific URL from database
     * @param string $hash
     * @param integer $post_id
     * @return mixed|null
     */
    public function getSqSeo($hash = null, $post_id = 0, $meta = null) {
        global $wpdb;
        $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq');
        if (isset($hash) && $hash <> '') {
            $blog_id = get_current_blog_id();

            $query = "SELECT * FROM " . $wpdb->prefix . strtolower(_SQ_DB_) . " WHERE blog_id = '" . (int)$blog_id . "' AND url_hash = '" . $hash . "';";

            if ($row = $wpdb->get_row($query, OBJECT)) {
                $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq', maybe_unserialize($row->seo));
            }
        } elseif ((int)$post_id > 0) {
            $blog_id = get_current_blog_id();

            $query = "SELECT * FROM " . $wpdb->prefix . strtolower(_SQ_DB_) . " WHERE blog_id = '" . (int)$blog_id . "' AND post_id = '" . (int)$post_id . "';";

            if ($row = $wpdb->get_row($query, OBJECT)) {
                $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq', maybe_unserialize($row->seo));
            }
        }

        if (isset($meta) && isset($metas->$meta)) {
            return $metas->$meta;
        }
        return $metas;
    }

    /**
     * Save the SEO for a specific URL into database
     * @param $url
     * @param $url_hash
     * @param $post_id
     * @param $seo
     * @param $date_time
     * @return false|int
     */
    public function saveSqSEO($url, $url_hash, $post_id, $seo, $date_time) {
        global $wpdb;
        $seo = addslashes($seo);
        $blog_id = get_current_blog_id();

        $sq_query = "INSERT INTO " . $wpdb->prefix . strtolower(_SQ_DB_) . " (blog_id, URL, url_hash, post_id, seo, date_time)
                VALUES ('$blog_id','$url','$url_hash','$post_id','$seo','$date_time')
                ON DUPLICATE KEY
                UPDATE blog_id = '$blog_id', URL = '$url', url_hash = '$url_hash', post_id = '$post_id', seo = '$seo', date_time = '$date_time'";

        //echo $wpdb->query($sq_query) . "\n";
        return $wpdb->query($sq_query);
    }

    /**
     * Create DB Table
     */
    public static function createTable() {
        global $wpdb;
        $sq_table_query = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . strtolower(_SQ_DB_) . ' (
                      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                      `blog_id` INT(10) NOT NULL,
                      `post_id`  bigint(20) NOT NULL DEFAULT 0 ,
                      `URL` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `url_hash` VARCHAR(32) NOT NULL,
                      `seo` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `date_time` DATETIME NOT NULL,
                      PRIMARY KEY(id),
                      UNIQUE url_hash(url_hash) USING BTREE,
                      INDEX post_id(post_id) USING BTREE, 
                      INDEX blog_id_url_hash(blog_id, url_hash) USING BTREE
                      )  CHARACTER SET utf8 COLLATE utf8_general_ci';

        if (file_exists(ABSPATH . 'wp-admin/includes/upgrade.php')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            if (function_exists('dbDelta')) {
                dbDelta($sq_table_query, true);
                $count = $wpdb->get_row("SELECT count(*) as count
                              FROM information_schema.columns 
                              WHERE table_name = '" . $wpdb->prefix . strtolower(_SQ_DB_) . "'
                              AND column_name = 'post_id';");

                if ($count->count == 0) {
                    $wpdb->query("ALTER TABLE " . $wpdb->prefix . strtolower(_SQ_DB_) . " ADD COLUMN `post_id` bigint(20) NOT NULL DEFAULT 0");
                }
            }
        }
    }

}