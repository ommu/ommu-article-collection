<?php
/**
 * Article Collections (article-collections)
 * @var $this AdminController
 * @var $model ArticleCollections
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
		$model->collection_id,
	);
?>

<div class="box">
	<?php 
	$medias = $model->article->medias;
	$media = $model->article->view->media_cover ? $article->article->view->media_cover : $medias[0]->media;
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'collection_id',
				'value'=>$model->collection_id,
			),
			array(
				'name'=>'publish',
				'value'=>$this->quickAction(Yii::app()->controller->createUrl('publish', array('id'=>$model->collection_id)), $model->publish),
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
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->creation_date) : '-',
			),
			array(
				'name'=>'creation_search',
				'value'=>$model->creation->displayname ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->modified_date) : '-',
			),
			array(
				'name'=>'modified_search',
				'value'=>$model->modified->displayname ? $model->modified->displayname : '-',
			),
		),
	)); ?>
</div>