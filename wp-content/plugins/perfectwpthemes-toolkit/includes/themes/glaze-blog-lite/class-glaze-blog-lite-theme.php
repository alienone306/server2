<?php
/**
 * Class that defines dependencies for Glaze Blog Lite theme.
 *
 * @package Perfectwpthemes_Toolkit
 */

if( ! class_exists( 'Prefectwpthemes_Toolkit_Glaze_Blog_Lite_Theme' ) ) {

	class Prefectwpthemes_Toolkit_Glaze_Blog_Lite_Theme {

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      Perfectwpthemes_Toolkit_Loader    $loader    Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

			$this->init();
		}

		public function init() {

			// Initialize Widget
			add_action( 'widgets_init', array( $this, 'widget_initialization' ), 20 );

			$this->load_dependencies();
			$this->initialize_custom_fields();
		}

		/**
		 * Load the required dependencies for this theme.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function load_dependencies() {

			require_once plugin_dir_path( __FILE__ ) . 'custom-fields/single-layout.php';

			require_once plugin_dir_path( __FILE__ ) . 'info.php';
			
			require_once plugin_dir_path( __FILE__ ) . 'functions.php';

			// Load Instagram Widget Class
			require_once plugin_dir_path( __FILE__ ) . 'widgets/instagram-widget.php';

			$this->loader = new Perfectwpthemes_Toolkit_Loader();
		}

		
		/**
		 * Initialize custom field for post and page.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function initialize_custom_fields() {

			$sidebar_position_custom_field = new Perfectwpthemes_Toolkit_Sidebar_Position_Custom_Field();

			$author_custom_field = new Perfectwpthemes_Toolkit_Author_Custom_Field();

			$single_layout_custom_field = new Perfectwpthemes_Toolkit_Single_Layout_Field();
		}


		/**
		 * Initialize widget areas and register widgets.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function widget_initialization() {

			register_sidebar( array(
				'name'          => esc_html__( 'Instagram Widget Area', 'perfectwpthemes-toolkit' ),
				'id'            => 'glaze-blog-lite-instagram-widget-area',
				'description'   => esc_html__( 'Add widgets here.', 'perfectwpthemes-toolkit' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget_title"><h3>',
				'after_title'   => '</h3></div>',
			) );

			register_widget( 'Perfectwpthemes_toolkit_Instagram_Widget' );
		}
	}
}

