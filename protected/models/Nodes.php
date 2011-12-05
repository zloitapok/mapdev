<?php

/**
 * This is the model class for table "tbl_nodes".
 *
 * The followings are the available columns in table 'tbl_nodes':
 * @property string $id
 * @property string $create_time
 * @property string $change_time
 * @property integer $created_by
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $tags
 * @property double $lat
 * @property double $lng
 * @property string $photo
 * @property string $phones
 * @property string $address
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Users $createdBy
 */
class Nodes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Nodes the static model class
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
		return 'tbl_nodes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, change_time, title, tags', 'required'),
			array('created_by', 'numerical', 'integerOnly'=>true),
			array('lat, lng', 'numerical'),
			array('create_time, change_time', 'length', 'max'=>11),
			array('title', 'length', 'max'=>100),
			array('keywords, description, tags, photo, phones, address', 'length', 'max'=>255),
			array('status', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, create_time, change_time, created_by, title, keywords, description, tags, lat, lng, photo, phones, address, status', 'safe', 'on'=>'search'),
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
			'createdBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'create_time' => 'Create Time',
			'change_time' => 'Change Time',
			'created_by' => 'Created By',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'tags' => 'Tags',
			'lat' => 'Lat',
			'lng' => 'Lng',
			'photo' => 'Photo',
			'phones' => 'Phones',
			'address' => 'Address',
			'status' => 'Status',
		);
	}
        
        static public function getAllTags()
        {
                $model=new Nodes();
                $criteria=new CDbCriteria;
                $criteria->select = array('tags');
                $criteria->condition = "status = 'public'";
                $nodes = $model->findAll($criteria);
                $allTags = array();
                foreach($nodes as $n)
                {
                        $tags = explode(',', $n->tags);
                        foreach ($tags as $tag)
                        {
                                if (key_exists($tag, $allTags))
                                {
                                        $allTags[$tag]++;
                                }
                                else
                                {
                                        $allTags[$tag] = 1;
                                }
                        }
                }
                
                $max = max($allTags);
                foreach ($allTags as $tag=>$count)
                {
                        $allTags[$tag] = $count / $max;
                }
                
                return $allTags;
        }
        
        
        public function getCriteria($search_request)
        {
                if (!$search_request)
                {
                        return new CDbCriteria;
                }
                
                $search_request = str_replace(',', ' ', $search_request);
                $search_request = preg_replace("/  +/"," ",$search_request); 
                $search_words = explode(' ', $search_request);

                $criteria=new CDbCriteria;

                foreach($search_words as $word)
                {
                        if (strlen($word) >= 3)
                        {
                                $criteria->addSearchCondition('title', $word, true, "OR");
                                $criteria->addSearchCondition('tags', $word, true, "OR");
                                $criteria->addSearchCondition('address', $word, true, "OR");
                                $criteria->addSearchCondition('services', $word, true, "OR");
                        }
                }

                $cArray = $criteria->toArray();

                if (empty($cArray['condition']))
                {
                        $criteria->compare('id', 0);
                }

                $criteria->compare('status', 'public', true, "AND"); 
                return $criteria;
        }
        
        public static function getTags($tag_str)
        {
                return explode(',', $tag_str);
        }


        public function fullTextSearch($search_request)
        {
                return new CActiveDataProvider($this, array(
			'criteria'=>$this->getCriteria($search_request),
		));
        }
        
        public function ajaxFullTextSearch($search_request)
        {
                return $this->findAll($this->getCriteria($search_request));
        }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('change_time',$this->change_time,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('lat',$this->lat);
		$criteria->compare('lng',$this->lng);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('phones',$this->phones,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}