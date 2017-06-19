<?php
/**
 * Article Collection Settings (article-collection-setting)
 * @var $this SettingController
 * @var $model ArticleCollectionSetting
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 26 October 2016, 06:58 WIB
 * @link https://github.com/ommu/plu-article-collection
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'article-collection-setting-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<div class="dialog-content">
	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'article_cat_id'); ?>
			<div class="desc">
				<?php 
				$parent = null;
				$category = ArticleCategory::getCategory(null, $parent);
				if($category != null)
					echo $form->dropDownList($model,'article_cat_id', $category);
				else
					echo $form->dropDownList($model,'article_cat_id', array('prompt'=>Yii::t('phrase', 'No Parent')));?>
				<?php echo $form->error($model,'article_cat_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


