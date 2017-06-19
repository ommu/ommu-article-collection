<?php
/**
 * View Article Collection Subjects (view-article-collection-subject)
 * @var $this SubjectController
 * @var $data ViewArticleCollectionSubject
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 19 June 2017, 16:49 WIB
 * @link https://github.com/ommu/plu-article-collection
 * @contact (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tag_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tag_id), array('view', 'id'=>$data->tag_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('collections')); ?>:</b>
	<?php echo CHtml::encode($data->collections); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('collection_all')); ?>:</b>
	<?php echo CHtml::encode($data->collection_all); ?>
	<br />


</div>