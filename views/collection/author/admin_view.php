<?php
/**
 * Article Collection Authors (article-collection-author)
 * @var $this AuthorController
 * @var $model ArticleCollectionAuthor
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 20 October 2016, 10:12 WIB
 * @link https://github.com/ommu/plu-article-collection
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Article Collection Authors'=>array('manage'),
		$model->author_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'author_id',
				'value'=>$model->author_id,
				//'value'=>$model->author_id != '' ? $model->author_id : '-',
			),
			array(
				'name'=>'publish',
				'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
				//'value'=>$model->publish,
			),
			array(
				'name'=>'author_name',
				'value'=>$model->author_name != '' ? $model->author_name : '-',
				//'value'=>$model->author_name != '' ? CHtml::link($model->author_name, Yii::app()->request->baseUrl.'/public/visit/'.$model->author_name, array('target' => '_blank')) : '-',
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
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
