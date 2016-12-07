<?php
/**
 * Articles (articles)
 * @var $this SiteController
 * @var $model Articles
 * @var $dataProvider CActiveDataProvider
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Articles
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Articles',
	);
?>

<?php if($model != null) {
	foreach($model as $key => $val) {
		$this->renderPartial('_view', array('data'=>$val), false, false);
	}?>
	
	<div class="pagination block t-center mt-70 mb-00">
		<?php $this->widget('application.components.system.OLinkPager', array(
			'pages' => $dataProvider->pagination,
			'header' => '',
		));?>
	</div>	
<?php } else {?>
<?php }?>