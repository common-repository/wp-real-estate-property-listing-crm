<script src="<?php echo mwp_public_url() . 'js/infinite-scroll.js';?>"></script>
<?php if($total_data > mwp_get_limit() ){?>
<script>initPaginator();</script>
<?php } ?>
