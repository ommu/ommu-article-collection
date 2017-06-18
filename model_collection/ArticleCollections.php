<?php
/**
 * ArticleCollections
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 October 2016, 06:57 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
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
	public $defaultColumns = array();
	public $author_input;
	public $subject_input;
	
	// Variable Search
	public $article_search;
	public $publisher_search;
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
				author_input, subject_input', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('collection_id, publish, cat_id, article_id, publisher_id, publish_year, publish_location, isbn, pages, series, creation_date, creation_id, modified_date, modified_id,
				article_search, publisher_search, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'cat_id' => Yii::t('attribute', 'Cat'),
			'article_id' => Yii::t('attribute', 'Article'),
			'publisher_id' => Yii::t('attribute', 'Publisher'),
			'publish_year' => Yii::t('attribute', 'Publish Year'),
			'publish_location' => Yii::t('attribute', 'Publish Location'),
			'isbn' => Yii::t('attribute', 'Isbn'),
			'pages' => Yii::t('attribute', 'Pages'),
			'series' => Yii::t('attribute', 'Series'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'author_input' => Yii::t('attribute', 'Authors'),
			'subject_input' => Yii::t('attribute', 'Subjects'),
			'article_search' => Yii::t('attribute', 'Collection'),
			'publisher_search' => Yii::t('attribute', 'Publisher'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
		);
		/*
			'Collection' => 'Collection',
			'Publish' => 'Publish',
			'Cat' => 'Cat',
			'Article' => 'Article',
			'Publisher' => 'Publisher',
			'Publish Year' => 'Publish Year',
			'Publish Location' => 'Publish Location',
			'Isbn' => 'Isbn',
			'Pages' => 'Pages',
			'Series' => 'Series',
			'Creation Date' => 'Creation Date',
			'Creation' => 'Creation',
			'Modified Date' => 'Modified Date',
			'Modified' => 'Modified',
		
		*/
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
			'article' => array(
				'alias'=>'article',
				'select'=>'title',
			),
			'article.tags' => array(
				'alias'=>'tags',
				'select'=>'tag_id',
				'together'=>true,
			),
			'publisher' => array(
				'alias'=>'publisher',
				'select'=>'publisher_name',
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname',
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname',
			),
		);

		$criteria->compare('t.collection_id',strtolower($this->collection_id),true);
		if(isset($_GET['type']) && $_GET['type'] == 'publish')
			$criteria->compare('t.publish',1);
		elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish')
			$criteria->compare('t.publish',0);
		elseif(isset($_GET['type']) && $_GET['type'] == 'trash')
			$criteria->compare('t.publish',2);
		else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		if(isset($_GET['category']))
			$criteria->compare('t.cat_id',$_GET['category']);
		else
			$criteria->compare('t.cat_id',$this->cat_id);
		if(isset($_GET['article']))
			$criteria->compare('t.article_id',$_GET['article']);
		else
			$criteria->compare('t.article_id',$this->article_id);
		if(isset($_GET['publisher']))
			$criteria->compare('t.publisher_id',$_GET['publisher']);
		else
			$criteria->compare('t.publisher_id',$this->publisher_id);
		$criteria->compare('t.publish_year',strtolower($this->publish_year),true);
		$criteria->compare('t.publish_location',strtolower($this->publish_location),true);
		$criteria->compare('t.isbn',strtolower($this->isbn),true);
		$criteria->compare('t.pages',strtolower($this->pages),true);
		$criteria->compare('t.series',strtolower($this->series),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation']))
			$criteria->compare('t.creation_id',$_GET['creation']);
		else
			$criteria->compare('t.creation_id',$this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified']))
			$criteria->compare('t.modified_id',$_GET['modified']);
		else
			$criteria->compare('t.modified_id',$this->modified_id);
		
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
		
		$criteria->compare('article.title',strtolower($this->article_search), true);
		$criteria->compare('publisher.publisher_name',strtolower($this->publisher_search), true);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['ArticleCollections_sort']))
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
	protected function afterConstruct() {
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
			if(!isset($_GET['category'])) {
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
			$this->defaultColumns[] = array(
				'name' => 'publisher_search',
				'value' => '$data->publisher->publisher_name',
			);
			$this->defaultColumns[] = 'publish_year';
			$this->defaultColumns[] = 'publish_location';
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->collection_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
					),
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
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
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
			if(trim($this->author_input) != '') {
				$author_input = Utility::formatFileType($this->author_input, true, '#');
				if(!empty($author_input)) {
					foreach($author_input as $key => $val) {
						$author = new ArticleCollectionAuthors;
						$author->collection_id = $this->collection_id;
						$author->author_id = 0;
						$author->author_input = $val;
						$author->save();
					}
				}
			}
			
			//input subject
			if(trim($this->subject_input) != '') {
				$subject_input = Utility::formatFileType($this->subject_input);
				if(!empty($subject_input)) {
					foreach($subject_input as $key => $val) {
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