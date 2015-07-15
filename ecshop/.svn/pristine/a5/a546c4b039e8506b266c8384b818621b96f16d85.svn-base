<?php

/**
 * This is the model class for table "lt_company".
 *
 * The followings are the available columns in table 'lt_company':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $country
 * @property integer $owner_id
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 */
class Company extends NIActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{company}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('owner_id', 'numerical', 'integerOnly'=>true),
			array('name, phone, country', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, phone, country, owner_id, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
            'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
            'users' => array(self::HAS_MANY, 'User', 'company_id'),
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
			'phone' => 'Phone',
			'country' => 'Country',
			'owner_id' => 'Owner',
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('owner_id',$this->owner_id);
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
	 * @return Company the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
