<?php

declare( strict_types = 1 );
namespace Urbanproof\ACF;

class FilterFieldPlugin {

	private $settings;

	public function __construct()
	{
		list(
			'version' => $plugin_version,
		) = get_file_data(
			dirname( __DIR__ ) . '/acf-filters.php',
			array( 'version' => 'Version' ),
			'plugin'
		);
		$this->settings = array(
			'version' => $plugin_version,
			'url'     => plugin_dir_url( __FILE__ ),
			'path'    => plugin_dir_path( __FILE__ ),
		);
		add_action( 'acf/include_field_types', array( $this, 'include_field' ) ); // v5
	}

	public function include_field()
	{
		load_plugin_textdomain( 'acf-filters', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		new Fields\FilterField( $this->settings );
	}

}
