<?php
/**
 * This is use to update public design changes
 *
 *
 *
 * @package MD_Single_Property
 * @author  masterdigm / Allan
 */
class Mwp_Actions_Buttons {
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	private $plugin_name;
	private $version;
	public $button = array(
		'favorite',
		'xout',
		'share',
		'print',
	);

	public function __construct(){
		$this->init();
	}
	
	public function init(){
		$this->plugin_name 	= mwp_plugin_name();
		$this->version 	 	= mwp_plugin_version();
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		Mwp_Actions_Favorite::get_instance();
		Mwp_Actions_XOut::get_instance();
		Mwp_Actions_PDF::get_instance();
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function enqueue_scripts(){
		wp_enqueue_script( 
			$this->plugin_name . '-button-actions', 
			mwp_public_url() . 'js/buttonaction-min.js', 
			array( 'jquery' ), 
			$this->version, 
			true 
		);
	}

	/**
	 * Display the buttons
	 * @param	array	$array_buttons		Show button according to value.
	 * 										key 'show'
	 * 										if show = 1 display the button container
	 * 										Accepts :
	 * 										key 'favorite'
	 * 										array(
	 * 											'show'=>1,
	 * 											'label'=>'Favorite',
	 * 											'other' => array(
	 * 												'class'=>''
	 * 											)
	 * 										),
	 * 										key 'xout'
	 *
	 * @return
	 *
	 * */
	public function display($array_buttons){
		$buttons = '';

		foreach($array_buttons as $key => $val ){
			if( $key == 'favorite' ){
				$buttons = $this->favorite_button($array_buttons['favorite']);
			}
			if( $key == 'xout' ){
				$buttons .= $this->xout_button($array_buttons['xout']);
			}
			if( $key == 'print' ){
				$buttons .= $this->print_button($array_buttons['print']);
			}
			if( $key == 'share' ){
				$buttons .= $this->share_button($array_buttons['share']);
			}
		}

		$show = 1;
		if( isset($array_buttons['show']) ){
			$show = $array_buttons['show'];
		}

		if( $show == 1 ){
			return $buttons;
		}
	}

	/**
	 * Show favorite button
	 * @param	array		args		accepted values:
	 * 									'label'	string display the name in public view,
	 * 									'show' boolean 1/0 show this button, 1 for yes and 0 for no, default 1,
	 * 									'other'	array accept key
	 * 									array(
	 * 										'class'=>''
	 * 									)
	 * @return	mix			include
	 * */
	public function favorite_button($args){
		if( isset($args['label']) ){
			$label = $args['label'];
		}else{
			$label = _label('button-favorite');
		}
		if( isset($args['show']) && $args['show'] == 1 ){
			$show = 1;
		}else{
			$show = 0;
		}
		if( isset($args['other']) ){
			$other = $args['other'];
		}else{
			$other = array();
		}

		if( isset($other['class']) ){
			$class = $other['class'];
		}else{
			$class = 'favorite-button';
		}

		if( isset($args['feed']) ){
			$feed = $args['feed'];
		}

		$property_id = 0;
		if( isset($args['property_id']) ){
			$property_id = $args['property_id'];
		}

		$is_save = false;
		if( isset($args['is_save']) ){
			$is_save = true;
		}

		$bootstrap_btn_class = 'default';
		if( isset($args['bootstrap_btn_class']) ){
			$bootstrap_btn_class = $args['bootstrap_btn_class'];
		}
		$require = false;
		if( isset($args['require']) && $args['require'] ){
			$require = $args['require'];
		}
		$data = array();
		if( $show == 1 ){
			$action = 'saveproperty_action';
			$content = '<p>' . __('Must register or login to mark as favorite', mwp_localize_domain()) . '</p>';
			$favorite_template = Mwp_Theme_Locator::get_instance()->locate_template('actionbuttons/favorite-button.php');
			$data['property_id'] = $property_id;
			$class = '';
			$data['class'] = $class;
			$data['label'] = $label;
			$data['feed'] = $feed;
			$data['content'] = $content;
			$data['action'] = $action;
			Mwp_View::get_instance()->display($favorite_template, $data);
		}
	}

	/**
	 * Show X-Out button
	 * @param	array		args		accepted values:
	 * 									'label'	string display the name in public view,
	 * 									'show' boolean 1/0 show this button, 1 for yes and 0 for no, default 1,
	 * 									'other'	array accept key
	 * 									array(
	 * 										'class'=>''
	 * 									)
	 * @return	mix			include
	 * */
	public function xout_button($args){
		if( isset($args['label']) ){
			$label = $args['label'];
		}else{
			$label = _label('button-xout');
		}
		if( isset($args['show']) && $args['show'] == 1 ){
			$show = 1;
		}else{
			$show = 0;
		}
		if( isset($args['other']) ){
			$other = $args['other'];
		}else{
			$other = array();
		}

		if( isset($other['class']) ){
			$class = $other['class'];
		}else{
			$class = 'xout-button';
		}

		if( isset($args['feed']) ){
			$feed = $args['feed'];
		}

		$property_id = 0;
		if( isset($args['property_id']) ){
			$property_id = $args['property_id'];
		}

		$is_save = false;
		if( isset($args['is_save']) ){
			$is_save = true;
		}

		$bootstrap_btn_class = 'default';
		if( isset($args['bootstrap_btn_class']) ){
			$bootstrap_btn_class = $args['bootstrap_btn_class'];
		}

		if( $show == 1 ){
			$action = 'xoutproperty_action';
			$content = '<p>' . __('Must register or login to mark as x-out', mwp_localize_domain()) . '</p>';
			$template = Mwp_Theme_Locator::get_instance()->locate_template('actionbuttons/xout-button.php');
			$data['property_id'] = $property_id;
			$class = '';
			$data['class'] = $class;
			$data['label'] = $label;
			$data['feed'] = $feed;
			$data['content'] = $content;
			$data['action'] = $action;
			Mwp_View::get_instance()->display($template, $data);
		}
	}

	/**
	 * Show Print button
	 * @param	array		args		accepted values:
	 * 									'label'	string display the name in public view,
	 * 									'show' boolean 1/0 show this button, 1 for yes and 0 for no, default 1,
	 * 									'other'	array accept key
	 * 									array(
	 * 										'class'=>''
	 * 									)
	 * @return	mix			include
	 * */
	public function print_button($args){
		if( isset($args['label']) ){
			$label = $args['label'];
		}else{
			$label = _label('button-printpdf');
		}
		if( isset($args['show']) && $args['show'] == 1 ){
			$show = 1;
		}else{
			$show = 0;
		}
		if( isset($args['other']) ){
			$other = $args['other'];
		}else{
			$other = array();
		}

		if( isset($other['class']) ){
			$class = $other['class'];
		}else{
			$class = 'print-button';
		}

		if( isset($args['url']) ){
			$url = $args['url'];
		}else{
			$url = '';
		}

		$property_id = 0;
		if( isset($args['property_id']) ){
			$property_id = $args['property_id'];
		}

		$bootstrap_btn_class = 'default';
		if( isset($args['bootstrap_btn_class']) ){
			$bootstrap_btn_class = $args['bootstrap_btn_class'];
		}

		if( $show == 1 ){
			$template = Mwp_Theme_Locator::get_instance()->locate_template('actionbuttons/print-button.php');
			$data['property_id'] = $property_id;
			$class = '';
			$data['class'] = $class;
			$data['label'] = $label;
			$data['property_id'] = $property_id;
			$data['url'] = $url;
			Mwp_View::get_instance()->display($template, $data);
		}
	}

	/**
	 * Share button
	 * @param	array		args		accepted values:
	 * 									'label'	string display the name in public view,
	 * 									'show' boolean 1/0 show this button, 1 for yes and 0 for no, default 1,
	 * 									'other'	array accept key
	 * 									array(
	 * 										'class'=>''
	 * 									)
	 * @return	mix			include
	 * */
	public function share_button($args){
		if( isset($args['label']) ){
			$label = $args['label'];
		}else{
			$label = _label('button-share');
		}
		if( isset($args['show']) && $args['show'] == 1 ){
			$show = 1;
		}else{
			$show = 0;
		}
		if( isset($args['other']) ){
			$other = $args['other'];
		}else{
			$other = array();
		}

		if( isset($other['class']) ){
			$class = $other['class'];
		}else{
			$class = 'share-button';
		}

		$property_id = 0;
		if( isset($args['property_id']) ){
			$property_id = $args['property_id'];
		}

		$is_save = false;
		if( isset($args['is_save']) ){
			$is_save = true;
		}

		if( isset($args['url']) ){
			$url = $args['url'];
		}else{
			$url = '';
		}

		if( isset($args['address']) ){
			$address = $args['address'];
		}else{
			$address = '';
		}

		$bootstrap_btn_class = 'default';
		if( isset($args['bootstrap_btn_class']) ){
			$bootstrap_btn_class = $args['bootstrap_btn_class'];
		}

		if( $show == 1 ){
			$template = Mwp_Theme_Locator::get_instance()->locate_template('actionbuttons/share-button.php');
			$data['property_id'] = $property_id;
			$class = '';
			$data['class'] = $class;
			$data['label'] = $label;
			$data['property_id'] = $property_id;
			$data['url'] = $url;
			$data['address'] = $address;
			Mwp_View::get_instance()->display($template, $data);
		}
	}

	public static function display_sort_button($args = array()){
		$class_sort_container = '';
		if( isset($args['class_container']) ){
			$class_sort_container = $args['class_container'];
		}

		$class_button = '';
		if( isset($args['class_button']) ){
			$class_button = $args['class_button'];
		}

		$class_dropdown_ul = '';
		if( isset($args['class_dropdown_ul']) ){
			$class_dropdown_ul = $args['class_dropdown_ul'];
		}

		$bootstrap_btn_class = 'default';
		if( isset($args['bootstrap_btn_class']) ){
			$bootstrap_btn_class = $args['bootstrap_btn_class'];
		}
		if( !is_map_view() ){
			require 'view/sort.php';
		}
	}
}
