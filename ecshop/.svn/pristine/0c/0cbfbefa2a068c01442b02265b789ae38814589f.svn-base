<?php

/**
 * This is the model class for table "{{ebay_entity_type}}".
 *
 * The followings are the available columns in table '{{ebay_entity_type}}':
 * @property integer $id
 * @property string $name
 * @property string $entity_table
 * @property string $entity_model
 * @property string $attribute_table
 * @property string $attribute_model
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 *
 * The followings are the available model relations:
 * @property EbayAttributeSet[] $ebayAttributeSets
 * @property EbayEntityAttribute[] $ebayEntityAttributes
 * @property EbayEntityContainer[] $ebayEntityContainers
 * @property EbayEntityDatetime[] $ebayEntityDatetimes
 * @property EbayEntityDeciaml[] $ebayEntityDeciamls
 * @property EbayEntityInt[] $ebayEntityInts
 * @property EbayEntityText[] $ebayEntityTexts
 * @property EbayEntityVarchar[] $ebayEntityVarchars
 * @property EbayListing[] $ebayListings
 */
class eBayEntityType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_entity_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, entity_table, entity_model, attribute_table, attribute_model', 'required'),
			array('name, entity_table, entity_model, attribute_table, attribute_model', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, entity_table, entity_model, attribute_table, attribute_model, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			'eBayAttributeSets' => array(self::HAS_MANY, 'eBayAttributeSet', 'entity_type_id'),
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
			'entity_table' => 'Entity Table',
			'entity_model' => 'Entity Model',
			'attribute_table' => 'Attribute Table',
			'attribute_model' => 'Attribute Model',
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
		$criteria->compare('entity_table',$this->entity_table,true);
		$criteria->compare('entity_model',$this->entity_model,true);
		$criteria->compare('attribute_table',$this->attribute_table,true);
		$criteria->compare('attribute_model',$this->attribute_model,true);
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
	 * @return eBayEntityType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
