<?php
/**
 * AuthorsController
 * @var $this AuthorsController
 * @var $model ArticleCollectionAuthors
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Add
 *	Delete
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 20 October 2016, 10:12 WIB
 * @link https://github.com/ommu/ommu-article-collection
 *
 *----------------------------------------------------------------------------------------------------------
 */

class AuthorsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		if(!Yii::app()->user->isGuest) {
			if(in_array(Yii::app()->user->level, array(1,2))) {
				$arrThemes = $this->currentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else
				throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','delete'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && in_array(Yii::app()->user->level, array(1,2))',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(array('manage'));
	}

	/**
	 * Manages all models.
	 */
	public function actionManage($collection=null, $author=null) 
	{
		$pageTitle = Yii::t('phrase', 'Authors Data');
		if($collection != null) {
			$data = ArticleCollections::model()->findByPk($collection);
			$pageTitle = Yii::t('phrase', 'Authors Data: Collection $collection_name', array ('$collection_name'=>$data->article->title));
		}
		if($author != null) {
			$data = ArticleCollectionAuthor::model()->findByPk($author);
			$pageTitle = Yii::t('phrase', 'Authors Data: Author $author_name', array ('$author_name'=>$data->author_name));
		}
		
		$model=new ArticleCollectionAuthors('search');
		$model->unsetAttributes();	// clear any default values
		if(isset($_GET['ArticleCollectionAuthors'])) {
			$model->attributes=$_GET['ArticleCollectionAuthors'];
		}

		$columns = $model->getGridColumn($this->gridColumnTemp());

		$this->pageTitle = $pageTitle;
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage', array(
			'model'=>$model,
			'columns' => $columns,
		));
	}	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$model=new ArticleCollectionAuthors;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['collection_id'], $_POST['author_id'], $_POST['author'])) {
			$model->collection_id = $_POST['collection_id'];
			$model->author_id = $_POST['author_id'];
			$model->author_i = $_POST['author'];

			if($model->save()) {
				if(isset($_GET['hook']) && $_GET['hook'] == 'collection')
					$url = Yii::app()->controller->createUrl('delete', array('id'=>$model->id,'hook'=>'collection','plugin'=>'collection'));
				else 
					$url = Yii::app()->controller->createUrl('delete', array('id'=>$model->id,'plugin'=>'collection'));
				echo CJSON::encode(array(
					'data' => '<div>'.$model->author->author_name.'<a href="'.$url.'" title="'.Yii::t('phrase', 'Delete').'">'.Yii::t('phrase', 'Delete').'</a></div>',
				));
			}
		}
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 
	{
		$model=$this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				$model->delete();
				if(isset($_GET['hook']) && $_GET['hook'] == 'collection') {
					echo CJSON::encode(array(
						'type' => 4,
					));
				} else {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage', array('plugin'=>'collection')),
						'id' => 'partial-article-collection-authors',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Collection authors success deleted.').'</strong></div>',
					));
				}
			}

		} else {
			if(isset($_GET['hook']) && $_GET['hook'] == 'collection')
				$url = Yii::app()->controller->createUrl('collection/admin/edit', array('id'=>$model->collection_id,'plugin'=>'collection'));
			else
				$url = Yii::app()->controller->createUrl('manage', array('plugin'=>'collection'));
			
			$this->dialogDetail = true;
			$this->dialogGroundUrl = $url;
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Delete Author $author_name: $collection_title', array('$author_name'=>$model->author->author_name, '$collection_title'=>$model->collection->article->title));
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = ArticleCollectionAuthors::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-collection-authors-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
