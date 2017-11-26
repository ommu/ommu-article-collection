<?php
/**
 * View Article Collection Subjects (view-article-collection-subject)
 * @var $this SubjectController
 * @var $model ViewArticleCollectionSubject
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 19 June 2017, 16:49 WIB
 * @link https://github.com/ommu/ommu-article-collection
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('tag_id'); ?><br/>
			<?php echo $form->textField($model,'tag_id'); ?><br/>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('collections'); ?><br/>
			<?php echo $form->textField($model,'collections'); ?><br/>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('collection_all'); ?><br/>
			<?php echo $form->textField($model,'collection_all'); ?><br/>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
