<?php
/**
 * Article Collections (article-collections)
 * @var $this AdminController
 * @var $model ArticleCollections
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 26 October 2016, 06:58 WIB
 * @link https://github.com/ommu/ommu-article-collection
 *
 */

	$this->breadcrumbs=array(
		'Article Collections'=>array('manage'),
		$model->collection_id,
	);
?>

<div class="box">
	<?php 
	$medias = $model->article->medias;
	$media = $model->article->view->media_cover ? $article->article->view->media_cover : $medias[0]->media;
	
	$this->widget('application.libraries.core.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'collection_id',
				'value'=>$model->collection_id,
			),
			array(
				'name'=>'publish',
				'value'=>$model->publish == '1' ? CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
				'type'=>'raw',
			),
			array(
				'name'=>'cat_id',
				'value'=>$model->cat_id ? $model->category->category_name : '-',
			),
			array(
				'name'=>'title_i',
				'value'=>$model->article_id ? $model->article->title : '-',
			),
			array(
				'name'=>'cover_i',
				'value'=>$media ? $media : '-',
			),
			array(
				'name'=>'file_i',
				'value'=>$model->article->media_file ? $model->article->media_file : '-',
			),
			array(
				'name'=>'article_id',
				'value'=>$model->article_id ? $model->article->body : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'publisher_id',
				'value'=>$model->publisher_id ? $model->publisher->publisher_name : '-',
			),
			array(
				'name'=>'publish_year',
				'value'=>!in_array($model->publish_year, array('0000','1970')) ? $model->publish_year : '-',
			),
			array(
				'name'=>'publish_location',
				'value'=>$model->publish_location ? $model->publish_location : '-',
			),
			array(
				'name'=>'isbn',
				'value'=>$model->isbn ? $model->isbn : '-',
			),
			array(
				'name'=>'pages',
				'value'=>$model->pages ? $model->pages : '-',
			),
			array(
				'name'=>'series',
				'value'=>$model->series ? $model->series : '-',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
			),
			array(
				'name'=>'creation_id',
				'value'=>$model->creation->displayname ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
			),
			array(
				'name'=>'modified_id',
				'value'=>$model->modified->displayname ? $model->modified->displayname : '-',
			),
		),
	)); ?>
</div>