<?php
/**
 * AdminController
 * @var $this AdminController
 * @var $model ArticleCollections
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Add
 *	Edit
 *	View
 *	RunAction
 *	Delete
 *	Publish
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 26 October 2016, 06:58 WIB
 * @link https://github.com/ommu/ommu-article-collection
 *
 *----------------------------------------------------------------------------------------------------------
 */

class AdminController extends Controller
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
				$arrThemes = Utility::getCurrentTemplate('admin');
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
				'actions'=>array('manage','add','edit','view','runaction','delete','publish'),
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
	public function actionManage($category=null, $publisher=null) 
	{
		$pageTitle = Yii::t('phrase', 'Collections');
		if($category != null) {
			$data = ArticleCollectionCategory::model()->findByPk($category);
			$pageTitle = Yii::t('phrase', 'Collections: Category $category_name', array ('$category_name'=>$data->category_name));
		}
		if($publisher != null) {
			$data = ArticleCollectionPublisher::model()->findByPk($publisher);
			$pageTitle = Yii::t('phrase', 'Collections: Publisher $publisher_name', array ('$publisher_name'=>$data->publisher_name));
		}
		
		$model=new ArticleCollections('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ArticleCollections'])) {
			$model->attributes=$_GET['ArticleCollections'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

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
		$model=new ArticleCollections;
		$article=new Articles;
		$publisher=new ArticleCollectionPublisher;
		$setting = ArticleSetting::model()->findByPk(1, array(
			'select' => 'meta_keyword, type_active, headline, media_file_type, upload_file_type',
		));
		$media_file_type = unserialize($setting->media_file_type);
		if(empty($media_file_type))
			$media_file_type = array();
		$upload_file_type = unserialize($setting->upload_file_type);
		if(empty($upload_file_type))
			$upload_file_type = array();

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$this->performAjaxValidation($article);
		$this->performAjaxValidation($publisher);

		if(isset($_POST['ArticleCollections'])) {
			$model->attributes=$_POST['ArticleCollections'];
			$article->attributes=$_POST['Articles'];
			$publisher->attributes=$_POST['ArticleCollectionPublisher'];
			$article->scenario = 'formStandard';
			
			$article->validate();
			$publisher->validate();
			
			if($model->validate() && $article->validate() && $publisher->validate()) {
				$article->publish = $model->publish;
				
				//if($model->publisher_id != '' && $model->publisher_id != 0) {
					$publisherFind = ArticleCollectionPublisher::model()->find(array(
						'select' => 'publisher_id, publisher_name',
						'condition' => 'publisher_name = :publisher',
						'params' => array(
							':publisher' => $publisher->publisher_name,
						),
					));
					if($publisherFind != null)
						$model->publisher_id = $publisherFind->publisher_id;
					else {
						if($publisher->save())
							$model->publisher_id = $publisher->publisher_id;
					}
				//}
				
				if($article->save()) {
					$model->article_id = $article->article_id;
					
					if($model->save()) {
						Yii::app()->user->setFlash('success', Yii::t('phrase', 'Collections success created.'));
						$this->redirect(array('edit','id'=>$model->collection_id, 'plugin'=>'collection'));
					}
				}
			}
		}

		$this->pageTitle = Yii::t('phrase', 'Create Collection');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add', array(
			'model'=>$model,
			'article'=>$article,
			'publisher'=>$publisher,
			'setting'=>$setting,
			'media_file_type'=>$media_file_type,
			'upload_file_type'=>$upload_file_type,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id) 
	{
		$model=$this->loadModel($id);
		$article = Articles::model()->findByPk($model->article_id);
		$publisher = ArticleCollectionPublisher::model()->findByPk($model->publisher_id);
		$setting = ArticleSetting::model()->findByPk(1, array(
			'select' => 'meta_keyword, type_active, headline, media_file_type, upload_file_type',
		));
		$media_file_type = unserialize($setting->media_file_type);
		if(empty($media_file_type))
			$media_file_type = array();
		$upload_file_type = unserialize($setting->upload_file_type);
		if(empty($upload_file_type))
			$upload_file_type = array();

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$this->performAjaxValidation($article);
		$this->performAjaxValidation($publisher);
			
		if(!$model->getErrors()) {
			$publisher_id = $model->publisher_id;
			$publisher_name = $publisher->publisher_name;
		}

		if(isset($_POST['ArticleCollections'])) {
			$model->attributes=$_POST['ArticleCollections'];
			$article->attributes=$_POST['Articles'];
			$publisher->attributes=$_POST['ArticleCollectionPublisher'];
			$article->scenario = 'formStandard';
			
			$article->validate();
			$publisher->validate();
			
			if($model->validate() && $article->validate() && $publisher->validate()) {				
				$article->publish = $model->publish;
				
				if($publisher_id != $model->publisher_id || $publisher_name != $publisher->publisher_name) {
					//if($model->publisher_id != '' && $model->publisher_id != 0) {
						$publisherFind = ArticleCollectionPublisher::model()->find(array(
							'select' => 'publisher_id, publisher_name',
							'condition' => 'publisher_name = :publisher',
							'params' => array(
								':publisher' => $publisher->publisher_name,
							),
						));
						if($publisherFind != null)
							$model->publisher_id = $publisherFind->publisher_id;
						else {
							if($publisher->save())
								$model->publisher_id = $publisher->publisher_id;
						}
					//}
				}
				
				if($article->save()) {
					$model->article_id = $article->article_id;
			
					if($model->save()) {
						Yii::app()->user->setFlash('success', Yii::t('phrase', 'Collections success updated.'));
						$this->redirect(array('edit','id'=>$model->collection_id, 'plugin'=>'collection'));
					}
				}
			}
		}

		$this->pageTitle = Yii::t('phrase', 'Update Collection: $collection_name', array('$collection_name'=>$model->article->title));
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit', array(
			'model'=>$model,
			'article'=>$article,
			'publisher'=>$publisher,
			'setting'=>$setting,
			'media_file_type'=>$media_file_type,
			'upload_file_type'=>$upload_file_type,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$model=$this->loadModel($id);

		$this->pageTitle = Yii::t('phrase', 'View Collection: $collection_name', array('$collection_name'=>$model->article->title));
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_view', array(
			'model'=>$model,
		));
	}	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRunAction() {
		$id       = $_POST['trash_id'];
		$criteria = null;
		$actions  = Yii::app()->getRequest()->getParam('action');

		if(count($id) > 0) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $id);

			if($actions == 'publish') {
				ArticleCollections::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				ArticleCollections::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				ArticleCollections::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				ArticleCollections::model()->deleteAll($criteria);
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!Yii::app()->getRequest()->getParam('ajax')) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
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
				if($model->delete()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage', array('plugin'=>'collection')),
						'id' => 'partial-article-collections',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Collections success deleted.').'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage', array('plugin'=>'collection'));
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Delete Collection: $collection_name', array('$collection_name'=>$model->article->title));
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionPublish($id) 
	{
		$model=$this->loadModel($id);
		
		if($model->publish == 1) {
			$title = Yii::t('phrase', 'Unpublish');
			$replace = 0;
		} else {
			$title = Yii::t('phrase', 'Publish');
			$replace = 1;
		}
		$pageTitle = Yii::t('phrase', '{title} Collection: $collection_name', array('{title}'=>$title, '$collection_name'=>$model->article->title));

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->publish = $replace;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage', array('plugin'=>'collection')),
						'id' => 'partial-article-collections',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Collections success updated.').'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage', array('plugin'=>'collection'));
			$this->dialogWidth = 350;

			$this->pageTitle = $pageTitle;
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_publish', array(
				'title'=>$title,
				'model'=>$model,
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = ArticleCollections::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-collections-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
