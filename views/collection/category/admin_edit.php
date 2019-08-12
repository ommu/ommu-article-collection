<?php
/**
 * Article Collection Categories (article-collection-category)
 * @var $this CategoryController
 * @var $model ArticleCollectionCategory
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 20 October 2016, 10:13 WIB
 * @link https://github.com/ommu/ommu-article-collection
 *
 */

	$this->breadcrumbs=array(
		'Article Collection Categories'=>array('manage'),
		$model->cat_id=>array('view','id'=>$model->cat_id),
		Yii::t('phrase', 'Update'),
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
