<?php
/**
 * Article Collection Authors (article-collection-author)
 * @var $this AuthorController
 * @var $model ArticleCollectionAuthor
 * @var $form CActiveForm
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
		$model->author_id=>array('view','id'=>$model->author_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>