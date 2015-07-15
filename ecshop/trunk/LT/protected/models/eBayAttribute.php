<?php

/**
 * This is the model class for table "{{ebay_attribute}}".
 *
 * The followings are the available columns in table '{{ebay_attribute}}':
 * @property integer $id
 * @property string $name
 * @property integer $backed_type
 * @property string $frontend_input
 * @property string $frontend_label
 * @property string $note
 * @property integer $create_time_utc
 * @property integer $create_admin_id
 * @property integer $update_time_utc
 * @property integer $update_admin_id
 *
 * The followings are the available model relations:
 * @property EbayEntityAttribute[] $ebayEntityAttributes
 * @property EbayEntityContainer[] $ebayEntityContainers
 * @property EbayEntityDatetime[] $ebayEntityDatetimes
 * @property EbayEntityDeciaml[] $ebayEntityDeciamls
 * @property EbayEntityInt[] $ebayEntityInts
 * @property EbayEntityText[] $ebayEntityTexts
 * @property EbayEntityVarchar[] $ebayEntityVarchars
 */
class eBayAttribute extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ebay_attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, backed_type', 'required'),
			array('backed_type', 'numerical', 'integerOnly'=>true),
			array('name, frontend_input, frontend_label, note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, backed_type, frontend_input, frontend_label, note, create_time_utc, create_admin_id, update_time_utc, update_admin_id', 'safe', 'on'=>'search'),
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
			/*'eBayEntityAttributes' => array(self::HAS_MANY, 'eBayEntityAttribute', 'attribute_id'),*/
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
			'backed_type' => 'Backed Type',
			'frontend_input' => 'Frontend Input',
			'frontend_label' => 'Frontend Label',
			'note' => 'Note',
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
		$criteria->compare('backed_type',$this->backed_type);
		$criteria->compare('frontend_input',$this->frontend_input,true);
		$criteria->compare('frontend_label',$this->frontend_label,true);
		$criteria->compare('note',$this->note,true);
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
	 * @return eBayAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
