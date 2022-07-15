<?php

namespace Hagersten\Lib\PostTypes;

use Hagersten\Lib\Classes\CustomPostType;

/**
 * Description of Instagram
 *
 * @package package
 * @version $id: Instagram.php $
 */
class Instagram {
	
	public function init() {
		$class = new \ReflectionClass( get_class( ) );

		$shortName = $class->getShortName();
		
		$name = (!empty($shortName) ? $shortName : 'Instagram');

		$config = array(
			'menu_icon' => 'dashicons-camera',
			'pluralize' => false
		);

		$cpt = new CustomPostType( $name, $config );
		
		$cpt->register();
	}
	
}

Instagram::init();