<?php
/**
 * Article Collections (article-collections)
 * @var $this AdminController
 * @var $model ArticleCollections
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 26 October 2016, 06:58 WIB
 * @link https://github.com/ommu/ommu-article-collection
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('collection_id'); ?><br/>
			<?php echo $form->textField($model,'collection_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('cat_id'); ?><br/>
			<?php echo $form->textField($model,'cat_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('article_id'); ?><br/>
			<?php echo $form->textField($model,'article_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publisher_id'); ?><br/>
			<?php echo $form->textField($model,'publisher_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish_year'); ?><br/>
			<?php echo $form->textField($model,'publish_year'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish_location'); ?><br/>
			<?php echo $form->textField($model,'publish_location'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('isbn'); ?><br/>
			<?php echo $form->textField($model,'isbn'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('pages'); ?><br/>
			<?php echo $form->textArea($model,'pages'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('series'); ?><br/>
			<?php echo $form->textArea($model,'series'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_id'); ?><br/>
			<?php echo $form->textField($model,'creation_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
