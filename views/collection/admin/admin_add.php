<?php
/**
 * Article Collections (article-collections)
 * @var $this AdminController
 * @var $model ArticleCollections
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 26 October 2016, 06:58 WIB
 * @link https://github.com/ommu/ommu-article-collection
 *
 */

	$this->breadcrumbs=array(
		'Article Collections'=>array('manage'),
		Yii::t('phrase', 'Create'),
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array(
		'model'=>$model,
		'article'=>$article,
		'publisher'=>$publisher,
		'setting'=>$setting,
		'media_file_type'=>$media_file_type,
		'upload_file_type'=>$upload_file_type,
	)); ?>
</div>
