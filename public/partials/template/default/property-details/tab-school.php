<table class="table-responsive table-condensed table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Type</th>
			<th>Grades</th>
			<th>GreatSchool Ratings</th>
			<th>Distance</th>
		</tr>
	</thead>
	<tbody>
		<?php if($res){ ?>
			<?php foreach($res as $key => $val){ ?>
				<tr>
					<td>
						<a href="<?php echo $val->overviewLink;?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Click to know more School details">
							<?php echo $val->name;?>
							- <a href="<?php echo $val->reviewsLink;?>" target="_blank">Reviews</a>
							- <a href="<?php echo $val->schoolStatsLink;?>" target="_blank">Stat</a>
						</a>
					</td>
					<td><?php echo $val->type;?></td>
					<td><?php echo $val->gradeRange;?></td>
					<td>
						<?php
							$rating = 'NR';
							if( isset($val->gsRating) ){
								$rating = $val->gsRating;
							}
						?>
						<a href="<?php echo $val->ratingsLink;?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Click to know more School rating">
							<img src="<?php echo mwp_asset_url() . '24x24_GS_School_Rating_Medium_' . $rating . '.png';?>" alt="Rating <?php echo $rating;?>"
							- Rating Details
						</a>
					</td>
					<td><?php echo $val->distance;?> mi</td>
				</tr>
			<?php }//foreach ?>
		<?php }//if ?>
	</tbody>
</table>
<div>
<p>Disclaimer: School attendance zone boundaries are supplied by Maponics and are subject to change. Check with the applicable school district prior to making a decision based on these boundaries.</p>
<a href="http://www.greatschools.org/" target="_blank"><img src="<?php echo mwp_asset_url() . 'logo_GS_200x50.gif';?>" alt="GreatSchool Logo"></a>
</div>
