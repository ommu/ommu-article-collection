<?php
/**
 * ViewArticleCollectionPublisher
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 December 2016, 06:18 WIB
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
 * This is the model class for table "_view_article_collection_publisher".
 *
 * The followings are the available columns in table '_view_article_collection_publisher':
 * @property string $publisher_id
 * @property string $collections
 * @property string $collection_publish
 * @property string $collection_unpublish
 */
class ViewArticleCollectionPublisher extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewArticleCollectionPublisher the static model class
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
		return '_view_article_collection_publisher';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'publisher_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publisher_id', 'length', 'max'=>11),
			array('collections', 'length', 'max'=>21),
			array('collection_publish, collection_unpublish', 'length', 'max'=>23),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('publisher_id, collections, collection_publish, collection_unpublish', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'publisher_id' => Yii::t('attribute', 'Publisher'),
			'collections' => Yii::t('attribute', 'Collections'),
			'collection_publish' => Yii::t('attribute', 'Collection Publish'),
			'collection_unpublish' => Yii::t('attribute', 'Collection Unpublish'),
		);
		/*
			'Publisher' => 'Publisher',
			'Collections' => 'Collections',
			'Collection Publish' => 'Collection Publish',
			'Collection Unpublish' => 'Collection Unpublish',
		
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

		$criteria->compare('t.publisher_id',strtolower($this->publisher_id),true);
		$criteria->compare('t.collections',strtolower($this->collections),true);
		$criteria->compare('t.collection_publish',strtolower($this->collection_publish),true);
		$criteria->compare('t.collection_unpublish',strtolower($this->collection_unpublish),true);

		if(!isset($_GET['ViewArticleCollectionPublisher_sort']))
			$criteria->order = 't.publisher_id DESC';

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
			$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'collections';
			$this->defaultColumns[] = 'collection_publish';
			$this->defaultColumns[] = 'collection_unpublish';
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
			$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'collections';
			$this->defaultColumns[] = 'collection_publish';
			$this->defaultColumns[] = 'collection_unpublish';
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

}