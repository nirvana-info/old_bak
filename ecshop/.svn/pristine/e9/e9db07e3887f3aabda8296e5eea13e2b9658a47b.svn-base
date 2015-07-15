<?php

/**
 * This is the model class for table "{{ebay_listing}}".
 *
 * The followings are the available columns in table '{{ebay_listing}}':
 * @property integer $id
 * @property integer $store_id
 * @property integer $company_id
 * @property integer $ebay_listing_id
 * @property integer $ebay_entity_type_id
 * @property integer $ebay_attribute_set_id
 * @property integer $is_active
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Store $store
 * @property EbayEntityType $ebayEntityType
 * @property EbayAttributeSet $ebayAttributeSet
 */
class eBayListing extends NIActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_listing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('store_id, company_id, ebay_listing_id, ebay_entity_type_id, ebay_attribute_set_id', 'required'),
			array('store_id, company_id, ebay_listing_id, ebay_entity_type_id, ebay_attribute_set_id, is_active, create_time_utc, create_user_id, update_time_utc, update_user_id', 'numerical', 'integerOnly'=>true),
			array('note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, store_id, company_id, ebay_listing_id, ebay_entity_type_id, ebay_attribute_set_id, is_active, note, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
			'eBayEntityType' => array(self::BELONGS_TO, 'EbayEntityType', 'ebay_entity_type_id'),
			'eBayAttributeSet' => array(self::BELONGS_TO, 'EbayAttributeSet', 'ebay_attribute_set_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'store_id' => 'Store',
			'company_id' => 'Company',
			'ebay_listing_id' => 'Ebay Listing',
			'ebay_entity_type_id' => 'Ebay Entity Type',
			'ebay_attribute_set_id' => 'Ebay Attribute Set',
			'is_active' => 'Is Active',
			'note' => 'Note',
			'create_time_utc' => 'Create Time Utc',
			'create_user_id' => 'Create User',
			'update_time_utc' => 'Update Time Utc',
			'update_user_id' => 'Update User',
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
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('ebay_listing_id',$this->ebay_listing_id);
		$criteria->compare('ebay_entity_type_id',$this->ebay_entity_type_id);
		$criteria->compare('ebay_attribute_set_id',$this->ebay_attribute_set_id);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('create_time_utc',$this->create_time_utc);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time_utc',$this->update_time_utc);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return eBayListing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
