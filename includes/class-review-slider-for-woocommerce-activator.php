<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Summary_Reviews
 * @subpackage Summary_Reviews/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Summary_Reviews
 * @subpackage Summary_Reviews/includes
 * @author     Your Name <email@example.com>
 */
class Summary_Reviews_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	 
	public static function activate_all($networkwide) {
		global $wpdb;
		 
		if (function_exists('is_multisite') && is_multisite()) {
			// check if it is a network activation - if so, run the activation function for each blog id
			if ($networkwide) {
						$old_blog = $wpdb->blogid;
				// Get all blog ids
				$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
				foreach ($blogids as $blog_id) {
					switch_to_blog($blog_id);
					self::activate();
				}
				switch_to_blog($old_blog);
				return;
			}   
		} 
		self::activate();   
	}
	 
	public static function activate() {
	
		//============================
		//need to make this multisite compatible
		//=============================
	
		//create table in database
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$table_name = $wpdb->prefix . 'srfw_reviews';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			pageid varchar(50) DEFAULT '' NOT NULL,
			pagename tinytext NOT NULL,
			created_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			created_time_stamp int(12) NOT NULL,
			reviewer_name tinytext NOT NULL,
			reviewer_id varchar(50) DEFAULT '' NOT NULL,
			rating int(2) NOT NULL,
			review_text text NOT NULL,
			hide varchar(3) DEFAULT '' NOT NULL,
			review_length int(5) NOT NULL,
			type varchar(12) DEFAULT '' NOT NULL,
			userpic varchar(250) DEFAULT '' NOT NULL,
			from_url varchar(800) DEFAULT '' NOT NULL,
			from_logo varchar(500) DEFAULT '' NOT NULL,
			from_url_review varchar(800) DEFAULT '' NOT NULL,
			review_length_char int(5) NOT NULL,
			categories text NOT NULL,
			posts text NOT NULL,
			miscpic varchar(500) DEFAULT '' NOT NULL,
			UNIQUE KEY id (id),
			PRIMARY KEY (id)
		) $charset_collate;";
		dbDelta( $sql );
		
		//create template posts table in dbDelta 
		$table_name = $wpdb->prefix . 'srfw_post_templates';
		
		$sql_template = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			title varchar(200) DEFAULT '' NOT NULL,
			template_type varchar(7) DEFAULT '' NOT NULL,
			style int(2) NOT NULL,
			created_time_stamp int(12) NOT NULL,
			display_num int(2) NOT NULL,
			display_num_rows int(3) NOT NULL,
			display_order varchar(6) DEFAULT '' NOT NULL,
			hide_no_text varchar(3) DEFAULT '' NOT NULL,
			template_css text NOT NULL,
			min_rating int(2) NOT NULL,
			min_words int(4) NOT NULL,
			max_words int(4) NOT NULL,
			rtype varchar(25) DEFAULT '' NOT NULL,
			rpage varchar(200) DEFAULT '' NOT NULL,
			createslider varchar(3) DEFAULT '' NOT NULL,
			numslides int(2) NOT NULL,
			sliderautoplay varchar(3) DEFAULT '' NOT NULL,
			sliderdirection varchar(12) DEFAULT '' NOT NULL,
			sliderarrows varchar(3) DEFAULT '' NOT NULL,
			sliderdots varchar(3) DEFAULT '' NOT NULL,
			sliderdelay int(2) NOT NULL,
			sliderheight varchar(3) DEFAULT '' NOT NULL,
			showreviewsbyid varchar(600) DEFAULT '' NOT NULL,
			template_misc varchar(200) DEFAULT '' NOT NULL,
			read_more varchar(3) DEFAULT '' NOT NULL,
			read_more_num int(4) NOT NULL,
			facebook_icon varchar(3) DEFAULT '' NOT NULL,
			read_more_text varchar(200) DEFAULT '' NOT NULL,
			UNIQUE KEY id (id),
			PRIMARY KEY (id)
		) $charset_collate;";
		
		dbDelta( $sql_template );
	
		//add columns to table, just need to update the dbDelta function above, will modify to match.
		
		//check for fb app id from free plugin and save it 
		
		//$paidoptions = get_option( 'srfw_options' );
		//$freeoptions = get_option( 'wpfbr_options' );
		//if(!$paidoptions && $freeoptions){
		//	update_option( 'srfw_options', $freeoptions );
		//}

	}


}
