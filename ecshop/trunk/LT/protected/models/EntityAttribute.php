<?php

/**
 * This is the model class for table "{{entity_attribute}}".
 *
 * The followings are the available columns in table '{{entity_attribute}}':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $type
 * @property integer $is_hidden
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property EntityAttributeSet[] $ltEntityAttributeSets
 */
class EntityAttribute extends NIActiveRecord
{
    //const for type
    const TYPE_INTEGER=1;
    const TYPE_FLOAT=2;
    const TYPE_STRING=3;
    const TYPE_BOOLEAN=4;
    const TYPE_DATETIME=5;
    const TYPE_TEXT=6;
    const TYPE_STRUCTURE=7;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{entity_attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, company_id', 'required'),
			array('company_id, type, is_hidden, create_time_utc, create_user_id, update_time_utc, update_user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, company_id, type, is_hidden, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'EntityAttributeSets' => array(self::MANY_MANY, 'EntityAttributeSet', '{{entity_attribute_set_option}}(attribute_id, attribute_set_id)'),
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
			'company_id' => 'Company',
			'type' => 'Type',
			'is_hidden' => 'Is Hidden',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('is_hidden',$this->is_hidden);
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
	 * @return EntityAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Get attribute value types
     * @return array
     */
    public function getTypeOptions()
    {
        return array(
            self::TYPE_INTEGER=>"Interger",
            self::TYPE_FLOAT=>'Float',
            self::TYPE_BOOLEAN=>'Yes/No',
            self::TYPE_DATETIME=>'DateTime',
            self::TYPE_STRING=>'Varchar',
            self::TYPE_TEXT=>'Text',
            self::TYPE_STRUCTURE=>'Structure to hold other attributes',
        );
    }
}
