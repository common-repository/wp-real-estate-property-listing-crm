<?php
class Mwp_Actions_PDF{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public $print_pdf_property_id;
	public $parse_url;
	public $api_feed;
	public $agent_info;

	public function __construct(){
		$this->init_wp_hook();
		$this->api_feed = mwp_valid_api();
	}

	public function init_wp_hook(){
		global $wp_query;
		add_action('init', array($this,'rewrite_url_pdf'));
		add_action('parse_request', array($this,'http_request_print'));
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

	public function rewrite_url_pdf(){
		add_rewrite_rule(
			'printpdf/(\d*)$',
			'index.php?printpdf=$matches[1]',
			'top'
		);
		add_rewrite_tag('%printpdf%', '([^&]+)');
	}

	public function build_property_photos($photos){
		$i = 1;
		$per_row = 3;
		$total_photos = count($photos);
		$body_photos = '';
		$body_photos .= '<table border="0"><tr>';
		if( is_array($photos) && $total_photos > 0 ){
			foreach( $photos as $key_photo => $val_photo ){
				$val_photos = mwp_urlencode($val_photo);
				//if( @getimagesize($val_photos) ){
				if( $val_photos != '' ){
					$check = ($i % $per_row);
					$body_photos .= '<td><img src="'.$val_photos.'"></td>';
					if($check == 0 && $i > 0 ) {
						$body_photos .= '</tr><tr>';
					}else{
					}
					$i++;
				}
			}
		}
		$body_photos .= '</tr></table>';

		if( has_filter('print_pdf_body_photos') ){
			$body_photos = apply_filters('print_pdf_body_photos', $photos);
		}

		return $body_photos;
	}

	public function build_property_details(){
		$details = '<table>';
			$details .= '<tr>';
				$details .= '<td>'. __('Price',mwp_localize_domain()).' : '.mwp_html_property_price(false).'</td>';
				if(!has_filter('list_display_baths_'.mwp_get_source())){
					$details .= '<td>Bath : '.mwp_property_bathrooms(false).'</td>';
				}
			$details .= '</tr>';
			$details .= '<tr>';
				if(!has_filter('list_display_bed_'.mwp_get_source())){
					$details .= '<td>' . __('Bed', mwp_localize_domain()).' : '.mwp_property_beds(false).'</td>';
				}
			$details .= '<td>'.apply_filters('before_pdf_area','~') . apply_filters('property_area_unit_' . mwp_get_source(), mwp_get_property_area_unit()).' : '.apply_filters('property_area_' . mwp_get_source(), mwp_get_property_area()).'</td>';
			$details .= '</tr>';
			$details .= '<tr><td>' . __('Year Built', mwp_localize_domain()).' : '.mwp_year_built().'</td><td>'._label('mls').' : '.mwp_get_mls().'</td></tr>';
			$details .= '<tr><td colspan="2"></td></tr>';
			$details .= '<tr><td colspan="2">'.strip_tags(mwp_get_data_loop()->description,'<p><br><i><b>').'</td></tr>';
		$details .= '</table>';
		if( has_filter('print_pdf_body_details') ){
			$details = apply_filters('print_pdf_body_details', $details);
		}
		return $details;
	}

	public function agent_info(){
		$agent 	 = '<p>'. __('Agent', mwp_localize_domain()).'</p>';
		$agent 	.= '<table width="340" cellspacing="0" cellpadding="0">';
			$agent 	.=	'<tbody>';
				$agent 	.=	'<tr>';
					$agent 	.=	'<td align="left">';
						$agent	.= $this->agent_info->get_name()."<br>";
						$agent 	.= __('Phone', mwp_localize_domain()).' : '.$this->agent_info->get_phone()."<br>";
						$agent	.= __('Mobile', mwp_localize_domain()). ' : '.$this->agent_info->get_mobile_num()."<br>";
						$agent 	.= __('Email', mwp_localize_domain()). ' : '.$this->agent_info->get_email()."<br>";
					$agent	.=	'</td>';
					$agent 	.=	'<td align="center"><img src="'.mwp_urlencode($this->agent_info->get_photo()).'" width="85px"></td>';
				$agent 	.=	'</tr>';
			$agent 	.=	'</tbody>';
		$agent 	.= '</table>';
		return $agent;
	}

	public function http_request_print(){
		$this->parse_uri();
		$property_id = $this->get_print_pdf_property_id();
		$source = $this->get_uri_api_source();
		if( $property_id ){
			$data = array(
				'id' => $property_id
			);
			$loop_data = apply_filters('md_single_property_pdf_' . $source, $data);
			if( $loop_data->loop_property() ){
				while($loop_data->loop_property()): $loop_data->md_set_property();mwp_set_loop($loop_data);
					$source = mwp_get_source();
					$attr_agent = array(
						'agent' => mwp_get_agent(),
						'property' => mwp_get_data_loop()
					);
					$this->agent_info = mwp_agent_details($attr_agent);
					$name 		= mwp_get_account_data_key('company');
					$address 	= "Address: ".mwp_get_account_data_key('street_address').', '.mwp_get_account_data_key('state').', '.mwp_get_account_data_key('country')."\n";
					$website 	= mwp_get_account_data_key('website')."\n\n";

					$header_details = $address . $website;
					// hook filter
					if( has_filter('print_pdf_header') ){
						$header_details = apply_filters('print_pdf_header', $header_details_string);
					}

					// create new PDF document
					// create new PDF document
					$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
					//$pdf->SetPrintHeader(false);
					//$pdf->SetPrintFooter(false);
					// set document information
					$pdf->SetCreator('Masterdigm');
					$pdf->SetAuthor('Name');
					$pdf->SetTitle('Property');
					$pdf->SetSubject('Masterdigm Print Flyer');
					$pdf->SetKeywords('TCPDF, PDF, masterdigm');
					// set default header data

					$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $name,$header_details);

					// set header and footer fonts
					$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

					// set default monospaced font
					$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

					// set margins
					$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
					$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

					// set auto page breaks
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

					// set image scale factor
					$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

					// set some language-dependent strings (optional)
					if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
						require_once(dirname(__FILE__).'/lang/eng.php');
						$pdf->setLanguageArray($l);
					}

					// ---------------------------------------------------------

					// set font
					//$pdf->SetFont('dejavusans', '', 10);

					// add a page
					$pdf->AddPage();
					$data_photos = mwp_single_photos();
					$photos 		= apply_filters('pdf_photos_' . $source, $data_photos);
					$body_photos 	= $this->build_property_photos($photos);
					$body_details 	= $this->build_property_details();
					// create some HTML content
					$logo = mwp_urlencode(mwp_get_account_data_key('company_logo'));
					$html = '<p></p><img src="'.$logo.'" width="130px">
					'.$this->agent_info().'
					<h2>'.mwp_property_title().'</h2>
					'.$body_details.'
					<p></p>
					'.$body_photos.'
					';
					// output the HTML content
					$pdf->writeHTML($html, true, false, true, false, '');

					//Close and output PDF document
					//$filename = strtolower(str_replace(' ','_',\helpers\Text::remove_non_alphanumeric(md_property_address())));
					$filename = $property_id;
					$pdf->Output($filename.'.pdf', 'I');
					exit();
				endwhile;
			}
		}//if property_id
	}

	public function parse_uri(){
		if(!empty($_SERVER['REQUEST_URI']))
		{
			$urlvars = explode('/', $_SERVER['REQUEST_URI']);
			$this->parse_url = $urlvars;
		}
	}
	
	public function is_printpdf_url(){
		$urlvars = $this->parse_url;
		return array_search('printpdf',$urlvars);
	}

	public function get_uri_api_source(){
		$source = mwp_get_current_api_source();
		$urlvars = $this->parse_url;
		$printpdf = array_search('printpdf',$urlvars);

		foreach($urlvars as $val){
			if( in_array($val, $this->api_feed) ){
				$source = $val;
			}
		}

		return $source;
	}

	public function get_print_pdf_property_id(){

		$urlvars = $this->parse_url;
		$printpdf = array_search('printpdf',$urlvars);

		if( $printpdf ){
			return $urlvars[$printpdf+1];
		}
		return false;
	}
}
