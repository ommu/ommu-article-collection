<?php
/**
 * View Article Collection Subjects (view-article-collection-subject)
 * @var $this SubjectController
 * @var $model ViewArticleCollectionSubject
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 19 June 2017, 16:49 WIB
 * @link https://github.com/ommu/plu-article-collection
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'View Article Collection Subjects'=>array('manage'),
		$model->tag_id,
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
			'name'=>'tag_id',
			'value'=>$model->tag_id,
			//'value'=>$model->tag_id != '' ? $model->tag_id : '-',
		),
		array(
			'name'=>'collections',
			'value'=>$model->collections,
			//'value'=>$model->collections != '' ? $model->collections : '-',
		),
		array(
			'name'=>'collection_all',
			'value'=>$model->collection_all,
			//'value'=>$model->collection_all != '' ? $model->collection_all : '-',
		),
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
