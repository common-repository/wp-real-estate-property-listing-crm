<!-- Single button -->
<div class="mwp-bootstrap btn-group md-butonactions ">
  
  <a role="button" class="<?php echo $class;?>" data-toggle="dropdown" aria-expanded="false">
    <span class="glyphicon glyphicon-share " aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Share">
	</span>
  </a>
  
  <ul class="dropdown-menu pull-right" role="menu">
    <li><a class="send-to-friend" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-url="<?php echo $url;?>" data-property-address="<?php echo $address;?>"><?php _e('Email to friend', mwp_localize_domain());?></a></li>
    <li><a class="share-popup" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url;?>" rel="nofollow" target="_blank">Facebook</a></li>
    <li><a class="share-popup" href="http://twitter.com/intent/tweet?text=Check out this property! <?php echo urldecode($address).' '.$url;?>" rel="nofollow" target="_blank">Twitter</a></li>
    <li><a class="share-popup" href="https://plus.google.com/share?url=<?php echo $url;?>" rel="nofollow" target="_blank">Google+</a></li>
  </ul>
</div>
