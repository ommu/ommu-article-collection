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

	$this->breadcrumbs=array(
		'Article Collections'=>array('manage'),
		$model->collection_id=>array('view','id'=>$model->collection_id),
		'Update',
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
