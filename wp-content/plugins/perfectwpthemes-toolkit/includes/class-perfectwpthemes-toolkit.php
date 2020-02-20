<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://perfectwpthemes.com
 * @since      1.0.0
 *
 * @package    Perfectwpthemes_Toolkit
 * @subpackage Perfectwpthemes_Toolkit/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Perfectwpthemes_Toolkit
 * @subpackage Perfectwpthemes_Toolkit/includes
 * @author     perfectwpthemes <perfectwpthemes@gmail.com>
 */
class Perfectwpthemes_Toolkit {

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
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

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
		if ( defined( 'PERFECTWPTHEMES_TOOLKIT_VERSION' ) ) {
			$this->version = PERFECTWPTHEMES_TOOLKIT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'perfectwpthemes-toolkit';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->load_theme_dependencies();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Perfectwpthemes_Toolkit_Loader. Orchestrates the hooks of the plugin.
	 * - Perfectwpthemes_Toolkit_i18n. Defines internationalization functionality.
	 * - Perfectwpthemes_Toolkit_Admin. Defines all hooks for the admin area.
	 * - Perfectwpthemes_Toolkit_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-perfectwpthemes-toolkit-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-perfectwpthemes-toolkit-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-perfectwpthemes-toolkit-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-perfectwpthemes-toolkit-public.php';
		
		/**
		 * Function responsible for admin notice when theme is activated
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/admin-notice.php';

		/**
		 * The class responsible for defining custom meta field, sidebar position, for post and page.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/custom-fields/sidebar-position.php';

		/**
		 * The class reponsible for defining custom meta field for author.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/custom-fields/author-profile-links.php';

		/**
		 * The class responsible for defining theme information.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/theme-info/class-theme-info.php';
		
		/**
		 * Function responsible for including theme dependencies.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions.php';

		/**
		 * Function responsible for including common theme dependencies.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/themes/theme-functions.php';

		/**
		 * Function responsible for including common template dependencies.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/themes/template-functions.php';

		$theme_text_domain = perfectwpthemes_toolkit_theme_text_domain();

		if( in_array( $theme_text_domain, perfectwpthemes_toolkit_theme_array() ) && $theme_text_domain == 'glaze-blog-lite' || $theme_text_domain == 'glaze-blog' ) {

			/**
			 * Load customizer additions.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer.php';
		}
		

		$this->loader = new Perfectwpthemes_Toolkit_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Perfectwpthemes_Toolkit_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Perfectwpthemes_Toolkit_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Perfectwpthemes_Toolkit_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Perfectwpthemes_Toolkit_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Load theme dependencies.
	 *
	 * @since    1.0.0
	 */
	public function load_theme_dependencies() {
		
		prefectwpthemes_toolkit_theme_dependencies();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Perfectwpthemes_Toolkit_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
