<?php
/**
 * View Article Collection Subjects (view-article-collection-subject)
 * @var $this SubjectController
 * @var $model ViewArticleCollectionSubject
 * @var $dataProvider CActiveDataProvider
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
		'View Article Collection Subjects',
	);
?>

<?php $this->widget('application.components.system.FListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'pager' => array(
		'header' => '',
	), 
	'summaryText' => '',
	'itemsCssClass' => 'items clearfix',
	'pagerCssClass'=>'pager clearfix',
)); ?>
