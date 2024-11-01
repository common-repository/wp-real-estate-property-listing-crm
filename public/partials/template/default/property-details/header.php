<?php $header_property = Mwp_View::get_instance()->data['property_data']->property_data[0];?>
<?php
	$title = '';
	if( Mwp_Settings_Property_DBEntity::get_instance()->get_property_title() == 'tagline' ){
		$title = $header_property->tag_line();
	}else{
		$title = $header_property->get_address();
	}
	$img = Mwp_View::get_instance()->data['property_data']->get_property_photo();
?>
<meta name="description" content="<?php echo mwp_remove_nonaplha($header_property->description());?>">
<link rel="canonical" href="<?php echo Mwp_PropertyDetailsURL::get_instance()->get_property_url($header_property->get_property_url());?>" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $title;?>" />
<meta property="og:description" content="<?php echo mwp_remove_nonaplha($header_property->description());?>" />
<meta property="og:url" content="<?php echo Mwp_PropertyDetailsURL::get_instance()->get_property_url($header_property->get_property_url());?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo( 'name' );?>" />
<?php if( $img ){ ?>
	<?php foreach( $img as $k => $v ){ ?>
		<meta property="og:image" content="<?php echo $v;?>" />
	<?php } ?>
<?php } ?>
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?php echo mwp_remove_nonaplha($header_property->description());?>" />
<meta name="twitter:title" content="<?php echo $title;?>" />
<meta name="twitter:url" content="" />
<?php if( $img ){ ?>
	<meta name="twitter:image" content="<?php echo $img[0];?>" />
<?php } ?>
<link rel="stylesheet" id="masterdigm-public" href="<?php echo mwp_default_template_url() . '/masterdigm-public.css';?>">
<link rel="stylesheet" id="masterdigm-style" href="<?php echo mwp_default_template_url() . '/masterdigm-style.css';?>">
<?php Mwp_Actions_ShowPopup::get_instance()->is_popup_reg_form(); ?>
