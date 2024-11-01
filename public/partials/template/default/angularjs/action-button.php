<?php
$basename = pathinfo($_SERVER['PHP_SELF']);
$self = explode('/',$_SERVER['PHP_SELF']);
$map_data_basename = '';
if ($self[1] != 'wp-content' && $self[1] != '') {
	$map_data_basename = $self[1];
}
if( isset($_SERVER['DOCUMENT_ROOT']) ){
	define('WP_USE_THEMES', false);
	require($_SERVER['DOCUMENT_ROOT'] . '/' . $map_data_basename . '/wp-load.php');
}
$class = '';
?>
<?php if( is_user_logged_in() ){ ?>
	<?php if( Mwp_Actions_Favorite::get_instance()->check_property("{{mdproperties.id}}") ){ ?>
		<a
			class="btn-outline butonactions btn btn-primary favorite property_favorite_remove btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="{{mdproperties.id}}"
			data-property-feed="{{mdproperties.favorite.feed}}"
			data-toggle="tooltip"
			data-placement="top"
			title="<?php _e('Remove to favorite', mwp_localize_domain());?>"
			role="button"
		>
			<i class="fa fa-heart"></i> {{mdproperties.favorite.label}}
		</a>
	<?php }else{ ?>
		<a
			class="btn-outline butonactions btn btn-default favorite property_favorite btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="{{mdproperties.id}}"
			data-property-feed="{{mdproperties.favorite.feed}}"
			data-toggle="tooltip"
			data-placement="top"
			title="<?php _e('Add to favorite', mwp_localize_domain());?>"
			role="button"
		>
			<i class="fa fa-heart-o"></i> {{mdproperties.favorite.label}}
		</a>
	<?php } ?>
<?php }else{ ?>
		<a
			class="btn-outline butonactions btn btn-default register-open btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-post="<?php echo "property-id={{mdproperties.id}}&property-feed={{mdproperties.favorite.feed}}"; ?>"
			data-current-action="{{mdproperties.favorite.action}}"
			data-toggle="tooltip"
			data-placement="top"
			title="<?php _e('Register or login to add as favorites', mwp_localize_domain());?>"
			role="button"
		>
			<i class="fa fa-heart-o"></i> {{mdproperties.favorite.label}}
		</a>
		<?php if( !is_user_logged_in() ) { ?>
			<div class="content-{{mdproperties.favorite.action}} hidden" style="display:hiden !important;">{{mdproperties.favorite.content}}</div>
		<?php } ?>
<?php } ?>
<?php if( is_user_logged_in() ){ ?>
	<?php if( Mwp_Actions_XOut::get_instance()->check_property("{{mdproperties.id}}") ){ ?>
		<a
			class="btn-outline butonactions btn btn-primary property_xout_remove xout btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="{{mdproperties.id}}"
			data-property-feed="{{mdproperties.xout.feed}}"
			data-toggle="tooltip"
			data-placement="top"
			title="Un-Xout property"
			role="button"
		>
			<i class="fa fa-times-circle"></i> {{mdproperties.xout.label}}
		</a>
	<?php }else{ ?>
		<a
			class="btn-outline butonactions btn btn-default property_xout xout btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="{{mdproperties.id}}"
			data-property-feed="{{mdproperties.xout.feed}}"
			data-toggle="tooltip"
			data-placement="top"
			title="Xout property"
			role="button"
		>
			<i class="fa fa-times-circle-o"></i> {{mdproperties.xout.label}}
		</a>
	<?php } ?>
<?php }else{ ?>
		<a
			class="btn-outline butonactions btn btn-default register-open btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-post="<?php echo "property-id={{mdproperties.id}}&property-feed={{mdproperties.xout.feed}}"; ?>"
			data-current-action="{{mdproperties.xout.action}}"
			data-toggle="tooltip"
			data-placement="top"
			title="<?php _e('Register or login to Xout property', mwp_localize_domain());?>"
			role="button"
		>
			<i class="fa fa-times-circle"></i> {{mdproperties.xout.label}}
		</a>
		<?php if( !is_user_logged_in() ) { ?>
			<div class="content-{{mdproperties.xout.action}} hidden" style="display:hiden !important;">{{mdproperties.xout.content}}</div>
		<?php } ?>
<?php } ?>
<a class="btn-outline butonactions btn btn-default btn-xs <?php echo $class;?> print-pdf-action" href="{{mdproperties.printpdf.url}}" target="_blank" role="button">{{mdproperties.printpdf.label}}</a>
<!-- Single button -->
<div class="btn-group md-butonactions ">
  <a role="button" class="btn-outline btn btn-default btn-xs <?php echo $class;?>" data-toggle="dropdown" aria-expanded="false">
    Share <span class="caret"></span>
  </a>
  <ul class="dropdown-menu" role="menu">
    <li><a class="send-to-friend" href="javascript:void(null)" data-property-id="{{mdproperties.id}}" data-property-url="{{mdproperties.url}}" data-property-address="{{mdproperties.title}}"><?php _e('Email to friend', mwp_localize_domain());?></a></li>
    <li><a class="share-popup" href="https://www.facebook.com/sharer/sharer.php?u={{mdproperties.url}}" rel="nofollow" target="_blank">Facebook</a></li>
    <li><a class="share-popup" href="http://twitter.com/intent/tweet?text=Check out this property! <?php echo urldecode("{{mdproperties.title}}").' ';?>{{mdproperties.title}}" rel="nofollow" target="_blank">Twitter</a></li>
    <li><a class="share-popup" href="https://plus.google.com/share?url={{mdproperties.url}}" rel="nofollow" target="_blank">Google+</a></li>
  </ul>
</div>


