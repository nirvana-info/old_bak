<?php

/**
 * This is the model class for table "{{ebay_attribute_set}}".
 *
 * The followings are the available columns in table '{{ebay_attribute_set}}':
 * @property integer $id
 * @property string $name
 * @property integer $entity_type_id
 * @property integer $sort_order
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 *
 * The followings are the available model relations:
 * @property EbayAttributeGroup[] $ebayAttributeGroups
 * @property EbayEntityType $entityType
 * @property EbayEntityAttribute[] $ebayEntityAttributes
 * @property EbayListing[] $ebayListings
 */
class eBayAttributeSet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_attribute_set}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, entity_type_id', 'required'),
			array('entity_type_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, entity_type_id, sort_order, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'eBayAttributeGroups' => array(self::HAS_MANY, 'eBayAttributeGroup', 'attribute_set_id'),
			'eBayEntityType' => array(self::BELONGS_TO, 'eBayEntityType', 'entity_type_id'),
			'eBayEntityAttributes' => array(self::MANY_MANY, 'eBayAttribute', '{{ebay_entity_attribute}}(attribute_set_id, attribute_id)'),
			/*'ebayListings' => array(self::HAS_MANY, 'EbayListing', 'ebay_attribute_set_id'),*/
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'entity_type_id' => 'Entity Type',
			'sort_order' => 'Sort Order',
			'create_time_utc' => 'Create Time Utc',
			'create_admin_id' => 'Create Admin',
			'update_time_utc' => 'Update Time Utc',
			'update_admin_id' => 'Update Admin',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('entity_type_id',$this->entity_type_id);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('create_admin_id',$this->create_admin_id);
		$criteria->compare('update_time_utc',$this->update_time_utc);
		$criteria->compare('update_admin_id',$this->update_admin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return eBayAttributeSet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
