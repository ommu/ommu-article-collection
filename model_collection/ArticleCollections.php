<?php
/**
 * ArticleCollections
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 26 October 2016, 06:57 WIB
 * @link https://github.com/ommu/ommu-article-collection
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_article_collections".
 *
 * The followings are the available columns in table 'ommu_article_collections':
 * @property string $collection_id
 * @property integer $publish
 * @property integer $cat_id
 * @property string $article_id
 * @property string $publisher_id
 * @property string $publish_year
 * @property string $publish_location
 * @property string $isbn
 * @property string $pages
 * @property string $series
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 */
class ArticleCollections extends CActiveRecord
{
	use GridViewTrait;

	public $defaultColumns = array();
	public $author_i;
	public $subject_i;
	
	// Variable Search
	public $article_search;
	public $publisher_search;
	public $published_date_search;
	public $author_search;
	public $subject_search;
	public $media_search;
	public $view_search;
	public $like_search;
	public $downlaod_search;
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleCollections the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_article_collections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_id', 'required'),
			array('publish, cat_id', 'numerical', 'integerOnly'=>true),
			array('article_id, publisher_id, creation_id, modified_id', 'length', 'max'=>11),
			array('publish_year', 'length', 'max'=>4),
			array('publish_location', 'length', 'max'=>64),
			array('isbn', 'length', 'max'=>32),
			array('article_id, publisher_id, publish_year, publish_location, isbn, pages, series,
				author_i, subject_i', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('collection_id, publish, cat_id, article_id, publisher_id, publish_year, publish_location, isbn, pages, series, creation_date, creation_id, modified_date, modified_id,
				article_search, publisher_search, published_date_search, author_search, subject_search, media_search, view_search, like_search, downlaod_search, creation_search, modified_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'view' => array(self::BELONGS_TO, 'ViewArticleCollections', 'collection_id'),
			'category' => array(self::BELONGS_TO, 'ArticleCollectionCategory', 'cat_id'),
			'article' => array(self::BELONGS_TO, 'Articles', 'article_id'),
			'publisher' => array(self::BELONGS_TO, 'ArticleCollectionPublisher', 'publisher_id'),
			'authors' => array(self::HAS_MANY, 'ArticleCollectionAuthors', 'collection_id'),
			'subjects' => array(self::HAS_MANY, 'ArticleCollectionSubjects', 'collection_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'collection_id' => Yii::t('attribute', 'Collection'),
			'publish' => Yii::t('attribute', 'Publish'),
			'cat_id' => Yii::t('attribute', 'Category'),
			'article_id' => Yii::t('attribute', 'Article'),
			'publisher_id' => Yii::t('attribute', 'Publisher'),
			'publish_year' => Yii::t('attribute', 'Publish Year'),
			'publish_location' => Yii::t('attribute', 'Publish Location'),
			'isbn' => Yii::t('attribute', 'ISBN/ISSN/ISMN'),
			'pages' => Yii::t('attribute', 'Pages'),
			'series' => Yii::t('attribute', 'Series'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'author_i' => Yii::t('attribute', 'Authors'),
			'subject_i' => Yii::t('attribute', 'Subjects'),
			'article_search' => Yii::t('attribute', 'Collection'),
			'publisher_search' => Yii::t('attribute', 'Publisher'),
			'published_date_search' => Yii::t('attribute', 'Published Date'),
			'author_search' => Yii::t('attribute', 'Authors'),
			'subject_search' => Yii::t('attribute', 'Subjects'),
			'media_search' => Yii::t('attribute', 'Photos'),
			'view_search' => Yii::t('attribute', 'Views'),
			'like_search' => Yii::t('attribute', 'Likes'),
			'downlaod_search' => Yii::t('attribute', 'Downloads'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
			'title_i' => Yii::t('attribute', 'Title'),
			'cover_i' => Yii::t('attribute', 'Media (Image)'),
			'file_i' => Yii::t('attribute', 'File (Download)'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		// Custom Search
		$criteria->with = array(
			'view' => array(
				'alias' => 'view',
			),
			'article' => array(
				'alias' => 'article',
				'select' => 'title, published_date',
			),
			'article.tags' => array(
				'alias' => 'tags',
				'select' => 'tag_id',
				'together'=>true,
			),
			'publisher' => array(
				'alias' => 'publisher',
				'select' => 'publisher_name',
			),
			'creation' => array(
				'alias' => 'creation',
				'select' => 'displayname',
			),
			'modified' => array(
				'alias' => 'modified',
				'select' => 'displayname',
			),
		);

		$criteria->compare('t.collection_id', strtolower($this->collection_id), true);
		if(Yii::app()->getRequest()->getParam('type') == 'publish')
			$criteria->compare('t.publish', 1);
		elseif(Yii::app()->getRequest()->getParam('type') == 'unpublish')
			$criteria->compare('t.publish', 0);
		elseif(Yii::app()->getRequest()->getParam('type') == 'trash')
			$criteria->compare('t.publish', 2);
		else {
			$criteria->addInCondition('t.publish', array(0,1));
			$criteria->compare('t.publish', $this->publish);
		}
		if(Yii::app()->getRequest()->getParam('category'))
			$criteria->compare('t.cat_id', Yii::app()->getRequest()->getParam('category'));
		else
			$criteria->compare('t.cat_id', $this->cat_id);
		if(Yii::app()->getRequest()->getParam('article'))
			$criteria->compare('t.article_id', Yii::app()->getRequest()->getParam('article'));
		else
			$criteria->compare('t.article_id', $this->article_id);
		if(Yii::app()->getRequest()->getParam('publisher'))
			$criteria->compare('t.publisher_id', Yii::app()->getRequest()->getParam('publisher'));
		else
			$criteria->compare('t.publisher_id', $this->publisher_id);
		$criteria->compare('t.publish_year', strtolower($this->publish_year), true);
		$criteria->compare('t.publish_location', strtolower($this->publish_location), true);
		$criteria->compare('t.isbn', strtolower($this->isbn), true);
		$criteria->compare('t.pages', strtolower($this->pages), true);
		$criteria->compare('t.series', strtolower($this->series), true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		if(Yii::app()->getRequest()->getParam('creation'))
			$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation'));
		else
			$criteria->compare('t.creation_id', $this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		if(Yii::app()->getRequest()->getParam('modified'))
			$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified'));
		else
			$criteria->compare('t.modified_id', $this->modified_id);
		
		if(Yii::app()->user->level == 2) {
			$location = ArticleLocationUser::model()->find(array(
				'select' => 'location_id, user_id',
				'condition' => 'user_id = :user',
				'params' => array(
					':user' => Yii::app()->user->id,
				),
			));
			if($location != null) {
				$tags = $location->location->tags;
				if(!empty($tags)) {
					$items = array();
					foreach($tags as $key => $val)
						$items[] = $val->tag_id;
					$criteria->addInCondition('tags.tag_id', $items);
				}
			} else
				$criteria->compare('article.creation_id',Yii::app()->user->id);
		}
		
		$criteria->compare('article.title', strtolower($this->article_search), true);
		$criteria->compare('publisher.publisher_name', strtolower($this->publisher_search), true);
		if($this->published_date_search != null && !in_array($this->published_date_search, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(article.published_date)', date('Y-m-d', strtotime($this->published_date_search)));
		$criteria->compare('view.authors', $this->author_search);
		$criteria->compare('view.subjects', $this->subject_search);
		$criteria->compare('article.view.medias', $this->media_search);
		$criteria->compare('article.view.views', $this->view_search);
		$criteria->compare('article.view.likes', $this->like_search);
		$criteria->compare('article.view.downloads', $this->downlaod_search);
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('ArticleCollections_sort'))
			$criteria->order = 't.collection_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		} else {
			//$this->defaultColumns[] = 'collection_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'cat_id';
			$this->defaultColumns[] = 'article_id';
			$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'publish_year';
			$this->defaultColumns[] = 'publish_location';
			$this->defaultColumns[] = 'isbn';
			$this->defaultColumns[] = 'pages';
			$this->defaultColumns[] = 'series';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() 
	{
		$setting = ArticleCollectionSetting::model()->findByPk(1, array(
			'select' => 'gridview_column',
		));
		$gridview_column = unserialize($setting->gridview_column);		
		if(empty($gridview_column))
			$gridview_column = array();
		
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			if(!Yii::app()->getRequest()->getParam('category')) {
				$this->defaultColumns[] = array(
					'name' => 'cat_id',
					'value' => '$data->category->category_name',
					'filter'=> ArticleCollectionCategory::getCategory(),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'article_search',
				'value' => '$data->article->title',
			);
			if(!Yii::app()->getRequest()->getParam('publisher')) {
				$this->defaultColumns[] = array(
					'name' => 'publisher_search',
					'value' => '$data->publisher->publisher_name',
				);
			}
			if(in_array('publish_year', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'publish_year',
					'value' => '!in_array($data->publish_year, array(\'0000\',\'1970\')) ? $data->publish_year : \'-\'',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if(in_array('publish_location', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'publish_location',
					'value' => '$data->publish_location',
				);
			}
			if(in_array('creation_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'creation_search',
					'value' => '$data->creation->displayname',
				);
			}
			if(in_array('creation_date', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'creation_date',
					'value' => 'Yii::app()->dateFormatter->formatDateTime($data->creation_date, \'medium\', false)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => $this->filterDatepicker($this, 'creation_date'),
				);
			}
			if(in_array('published_date_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'published_date_search',
					'value' => 'Yii::app()->dateFormatter->formatDateTime($data->article->published_date, \'medium\', false)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=> $this->filterDatepicker($this, 'published_date_search'),
				);
			}
			if(in_array('author_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'author_search',
					'value' => 'CHtml::link($data->view->authors ? $data->view->authors : 0, Yii::app()->controller->createUrl("collection/authors/manage", array(\'collection\'=>$data->collection_id,\'plugin\'=>\'collection\')))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if(in_array('subject_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'subject_search',
					'value' => 'CHtml::link($data->view->subjects ? $data->view->subjects : 0, Yii::app()->controller->createUrl("collection/subjects/manage", array(\'collection\'=>$data->collection_id,\'plugin\'=>\'collection\')))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if(in_array('media_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'media_search',
					'value' => 'CHtml::link($data->article->view->medias ? $data->article->view->medias : 0, Yii::app()->controller->createUrl("o/media/manage", array(\'article\'=>$data->article_id)))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if(in_array('view_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'view_search',
					'value' => 'CHtml::link($data->article->view->views ? $data->article->view->views : 0, Yii::app()->controller->createUrl("o/views/manage", array(\'article\'=>$data->article_id)))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if(in_array('like_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'like_search',
					'value' => 'CHtml::link($data->article->view->likes ? $data->article->view->likes : 0, Yii::app()->controller->createUrl("o/like/manage", array(\'article\'=>$data->article_id)))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if(in_array('downlaod_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'downlaod_search',
					'value' => 'CHtml::link($data->article->view->downloads ? $data->article->view->downloads : 0, Yii::app()->controller->createUrl("o/download/manage", array(\'article\'=>$data->article_id)))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if(!Yii::app()->getRequest()->getParam('type')) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'publish\', array(\'id\'=>$data->collection_id,\'plugin\'=>\'collection\')), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => $this->filterYesNo(),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id, array(
				'select' => $column,
			));
			if(count(explode(',', $column)) == 1)
				return $model->$column;
			else
				return $model;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {		
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;	
			else
				$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		
		if($this->isNewRecord) {			
			//input author
			if(trim($this->author_i) != '') {
				$author_i = Utility::formatFileType($this->author_i, true, '#');
				if(!empty($author_i)) {
					foreach($author_i as $key => $val) {
						$author = new ArticleCollectionAuthors;
						$author->collection_id = $this->collection_id;
						$author->author_id = 0;
						$author->author_i = $val;
						$author->save();
					}
				}
			}
			
			//input subject
			if(trim($this->subject_i) != '') {
				$subject_i = Utility::formatFileType($this->subject_i);
				if(!empty($subject_i)) {
					foreach($subject_i as $key => $val) {
						$subject = new ArticleCollectionSubjects;
						$subject->collection_id = $this->collection_id;
						$subject->tag_id = 0;
						$subject->tag_input = $val;
						$subject->save();
					}
				}
			}
		}
	}

}