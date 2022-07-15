<?php

namespace Hagersten\Lib\Classes;

/**
 * Create a custom post type with taxonomy, table head and content in the admin can also be added
 * 
 * Usage:
 * 
 * $class = new \ReflectionClass( 'Product' );
 * $name = $class->getShortName();
 *		
 * $config = array(
 *		'menu_icon' => 'dashicons-businessman'
 * );
 *
 * $cpt = new CustomPostType( $name, $config );
 *
 * $cpt->setSlug( 'producent' );
 * $cpt->addTaxonomy( 'Location' );
 * $cpt->register();
 *
 * @package package
 * @version $id: CustomPostType.php $
 */
class CustomPostType {

	private $name;
	private $cptName;
	private $taxonomy;
	private $taxonomyName;
	private $taxonomyPluralize;
	private $slug;
	private $taxonomySlug;
	private $config = array(
		'hierarchical' => true,
		'has_archive' => false,
		'show_ui' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies' => array(),
		'public' => true,
		'query_var' => true,
		'menu_icon' => 'dashicons-businessman',
		'pluralize' => false
	);
	private $labels;
	private $themeName;

	public function __construct( $name, $config = array(), $labels = array() ) {
		$this->name = $name;
		$this->cptName = str_replace( ' ', '-', strtolower( $name ) );
		$this->config = array_merge( $this->config, $config );
		$this->labels = $labels;

		$theme = wp_get_theme();
		$this->themeName = $theme->get( 'Name' );
	}

	public function setSlug( $slug ) {
		$this->slug = $slug;
	}

	public function setTaxSlug( $taxSlug ) {

		$this->taxSlug = $taxSlug;
	}

	public function setConfig( $config = array() ) {
		$this->config = array_merge( $this->config, $config );
	}

	public function setLabels( $labels = array() ) {
		$this->labels = $labels;
	}

	public function addTaxonomy( $taxonomy, $pluralize = true ) {
		$this->taxonomyPluralize = $pluralize;
		$this->taxonomy = $taxonomy;
		$this->taxonomyName = str_replace( ' ', '-', strtolower( $taxonomy ) );

		if( !$this->taxonomySlug ) {
			$this->taxonomySlug = str_replace( ' ', '-', strtolower( $taxonomy ) );
		}
	}

	public function register() {
		if( !post_type_exists( $this->cptName ) ) {
			add_action( 'init', function() {
				$this->registerPostType();
			} );
		}

		if( !taxonomy_exists( $this->taxonomyName ) ) {
			add_action( 'init', function() {
				$this->registerTaxonomy();
			} );
		} else {
			add_action( 'init', function() {
				$this->addTaxonomyToPost();
			} );
		}
		
		if( $this->taxonomy ) {
			add_filter( 'manage_edit-' . $this->cptName . '_columns', function( $defaults ) {
				return $this->tableHead( $defaults );
			} );
			
			add_action( 'manage_' . $this->cptName . '_posts_custom_column', function( $columnName ) {
				$this->tableContent( $columnName );
			} );
		}
	}

	private function registerTaxonomy() {
		$name = trim( implode( ' ', preg_split( '/(?=[A-Z])/', $this->taxonomy ) ) );
		
		$config = array(
			'labels' => array(
				'name' => __( ( $this->taxonomyPluralize ) ? $this->pluralize( $name ) : $name, $this->themeName ),
				'singular_name' => __( $name, $this->themeName ),
				'add_new_item' => __( 'Add new ' . strtolower( $name ), $this->themeName )
			),
			'rewrite' => array( 'slug' => (!empty($this->taxSlug) ? $this->taxSlug : "") ),
			'hierarchical' => true,
		);

		register_taxonomy( $this->taxonomyName, $this->cptName, $config );
	}

	private function addTaxonomyToPost() {
		register_taxonomy_for_object_type( $this->taxonomyName, $this->cptName );
	}

	private function registerPostType() {
		$name = trim( implode( ' ', preg_split( '/(?=[A-Z])/', $this->name ) ) );
		
		if( !$this->labels ) {
			$this->labels = array(
				'name' => __( ( $this->config['pluralize'] ) ? $this->pluralize( $name ) : $name, $this->themeName ),
				'singular_name' => __( $name, $this->themeName ),
				'add_new_item' => __( 'Add new ' . strtolower( $name ), $this->themeName )
			);
		}

		if( !$this->slug ) {
			$this->slug = str_replace( ' ', '-', strtolower( $name ) );
		}

		$config = array_merge( $this->config, array(
			'labels' => $this->labels,
			'rewrite' => array( 'slug' => $this->slug )
		) );

		register_post_type( $this->cptName, $config );
	}

	private function tableHead( $defaults ) {
		$name = trim( implode( ' ', preg_split( '/(?=[A-Z])/', $this->taxonomy ) ) );
		
		$defaults[ $this->taxonomyName ] = $name;

		return $defaults;
	}

	private function tableContent( $columnName ) {
		global $post;
				
		if( $columnName === $this->taxonomyName ) {
			$terms = wp_get_post_terms( $post->ID, $this->taxonomyName );
			$items = array();

			foreach( $terms as $term ) {
				array_push( $items, $term->name );
			}

			echo implode( ', ', $items );
		}
	}
	
	private function pluralize( $singular ) {
		if( !strlen( $singular ) )  {
			return $singular;
		}

		$lastLetter = strtolower( $singular[strlen( $singular ) - 1] );

		switch( $lastLetter ) {
			case 'y':
				return substr( $singular, 0, -1 ).'ies';
			case 's':
				return $singular . 'es';
			default:
				return $singular . 's';
		}
	}

}
