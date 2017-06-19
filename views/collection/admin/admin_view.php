<?php
/**
 * Article Collections (article-collections)
 * @var $this AdminController
 * @var $model ArticleCollections
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 26 October 2016, 06:58 WIB
 * @link https://github.com/ommu/plu-article-collection
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Article Collections'=>array('manage'),
		$model->collection_id,
	);
?>

<?php //begin.Messages ?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
<?php //end.Messages ?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'collection_id',
			'value'=>$model->collection_id,
			//'value'=>$model->collection_id != '' ? $model->collection_id : '-',
		),
		array(
			'name'=>'publish',
			'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			//'value'=>$model->publish,
		),
		array(
			'name'=>'cat_id',
			'value'=>$model->cat_id,
			//'value'=>$model->cat_id != '' ? $model->cat_id : '-',
		),
		array(
			'name'=>'article_id',
			'value'=>$model->article_id,
			//'value'=>$model->article_id != '' ? $model->article_id : '-',
		),
		array(
			'name'=>'publisher_id',
			'value'=>$model->publisher_id,
			//'value'=>$model->publisher_id != '' ? $model->publisher_id : '-',
		),
		array(
			'name'=>'publish_year',
			'value'=>$model->publish_year,
			//'value'=>$model->publish_year != '' ? $model->publish_year : '-',
		),
		array(
			'name'=>'publish_location',
			'value'=>$model->publish_location,
			//'value'=>$model->publish_location != '' ? $model->publish_location : '-',
		),
		array(
			'name'=>'isbn',
			'value'=>$model->isbn,
			//'value'=>$model->isbn != '' ? $model->isbn : '-',
		),
		array(
			'name'=>'pages',
			'value'=>$model->pages != '' ? $model->pages : '-',
			//'value'=>$model->pages != '' ? CHtml::link($model->pages, Yii::app()->request->baseUrl.'/public/visit/'.$model->pages, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'series',
			'value'=>$model->series != '' ? $model->series : '-',
			//'value'=>$model->series != '' ? CHtml::link($model->series, Yii::app()->request->baseUrl.'/public/visit/'.$model->series, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'creation_date',
			'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->creation_id,
			//'value'=>$model->creation_id != 0 ? $model->creation_id : '-',
		),
		array(
			'name'=>'modified_date',
			'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
		),
		array(
			'name'=>'modified_id',
			'value'=>$model->modified_id,
			//'value'=>$model->modified_id != 0 ? $model->modified_id : '-',
		),
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
