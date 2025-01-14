<?php # -*- coding: utf-8 -*-

add_action( 'init', array ( 'WPrev_Zill_Plugin_Action', 'init' ) );

class WPrev_Zill_Plugin_Action
{
    /**
     * Creates a new instance.
     *
     * @wp-hook init
     * @see    __construct()
     * @return void
     */
    public static function init()
    {
        new self;
    }

    /**
     * Register the action. May do more magic things.
     */
    public function __construct()
    {
        add_action( 'wprev_srfw_plugin_action', array ( $this, 'srfw_slider_action_print' ), 10, 1 );
    }

    /**
     * Prints out reviews
     *
     * Usage:
     *    <code>do_action( 'wprev_srfw_plugin_action', 1 );</code>
     *	
     * @wp-hook wprev_srfw_plugin_action
     * @param int $templateid
     * @return void
     */
    public function srfw_slider_action_print( $templateid = 0 )
    {
		$a['tid']=$templateid;
		if($templateid>0){
		//ob_start();
		include plugin_dir_path( __FILE__ ) . 'partials/review-slider-for-woocommerce-public-display.php';
		//return ob_get_clean();
		}
    }
}