<?php
/**
 * Articles (articles)
 * @var $this SiteController
 * @var $data Articles
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Articles
 * @contect (+62)856-299-4114
 *
 */
	
?>

<!-- Post -->
<div class="post clearfix">
	<!-- Left, Dates -->
	<div class="dates f-left">
		<!-- Post Time -->
		<h6 class="date">
			<span class="day colored helvetica">
			<?php echo date('d', strtotime($data->published_date));?>
			</span>
			<?php echo Utility::getLocalMonthName($data->published_date);?> <?php echo date('Y', strtotime($data->published_date));?>
		</h6>
		<!-- Details -->
		<div class="details">
			<ul class="t-right fullwidth">
				<!-- Posted By -->
				<li>
					Posted By <a><?php echo $data->creation_relation->displayname?></a>
					<i class="fa fa-user"></i>
				</li>
				<li>
					<?php
					if($data->views->location_id != null) {
						$locationCode = $data->views->location->province_code;?>
						<a href="<?php echo Yii::app()->createUrl($locationCode.'/index')?>" title="<?php echo $data->views->location->province_relation->province;?>"><?php echo $data->views->location->province_relation->province;?></a>
					<?php } else
						echo Yii::t('phrase', 'Indonesia');?>
					<i class="fa fa-map-marker"></i>
				</li>
				<!-- Comments -->
				<?php /*
				<li>
					<a href="#">12 Comments</a>
					<i class="fa fa-comments"></i>
				</li>
				*/?>
				<!-- Tags -->
				<?php $tags = $data->tags;
				if(!empty($tags)) {
					$countTags = count($tags);?>
					<li>
						<?php 
						$i = 0;
						foreach($tags as $key => $val) {
							$i++;?>
							<a href="<?php echo Yii::app()->controller->createUrl('index', array('tag'=>$val->tag_TO->body));?>" title="<?php echo $val->tag_TO->body?>"><?php echo $val->tag_TO->body?></a><?php echo $i != $countTags ? ',' : '';?>
						<?php }?>
						<i class="fa fa-tags"></i>
					</li>
				<?php }?>
				<!-- Liked -->
				<?php /*
				<li>
					<a href="#">Extra Link</a>
					<i class="fa fa-link"></i>
				</li>
				*/?>
			</ul>
		</div>
		<!-- End Details -->
	</div>
	<!-- End Left, Dates -->
	<!-- Post Inner -->
	<div class="post-inner f-right">
		<!-- Header -->
		<a href="<?php echo Yii::app()->controller->createUrl('view', array('id'=>$data->article_id, 't'=>Utility::getUrlTitle($data->title)))?>">
			<h2 class="post-header semibold">
				<?php echo $data->title;?>
			</h2>
		</a>
		<!-- Media -->
		<?php $medias = $data->medias;
		if(!empty($medias)) {
			$count = count($medias);?>
			<div class="post-image <?php echo $count > 1 ? 'image_slider mp-gallery clearfix' : 'post-media mp-gallery';?>">
				<?php foreach($medias as $key => $val) {
					$image = Yii::app()->request->baseUrl.'/public/article/'.$val->article_id.'/'.$val->media;?>
					<?php if($count > 1) {?>
						<!-- Slide -->
						<li class="slide">
							<a href="<?php echo $image;?>" title="Post image">
								<img src="<?php echo Utility::getTimThumb($image, 880, 470, 1)?>" alt="">
							</a>
						</li>
						<!-- Slide -->
					<?php } else {?>
						<a href="<?php echo $image;?>" title="Post image">
						<img src="<?php echo Utility::getTimThumb($image, 880, 470, 1)?>" alt="">
						</a>
				<?php }
				}?>
			</div>
		<?php }?>
		<!-- Description -->
		<div class="post-text light">
			<?php $shortText = empty($medias) ? 800 : 230;
			echo Utility::shortText(Utility::hardDecode($data->body), $shortText);?>
		</div>
		<!-- Load More Button -->
		<a href="<?php echo Yii::app()->controller->createUrl('view', array('id'=>$data->article_id, 't'=>Utility::getUrlTitle($data->title)))?>" class="post-more uppercase light st">
			<?php echo Yii::t('phrase', 'Selengkapnya');?>
		</a>
	</div>
	<!-- End Post Inner -->
</div>
<!-- End Post -->