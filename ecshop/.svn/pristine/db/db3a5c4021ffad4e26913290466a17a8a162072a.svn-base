<?php

/**
 * This is the model class for table "{{product_folder}}".
 *
 * The followings are the available columns in table '{{product_folder}}':
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $company_id
 * @property integer $create_time_utc
 * @property integer $create_user_id
 * @property integer $update_time_utc
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property Company $company
 */
class ProductFolder extends NIActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_folder}}';
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
			array('parent_id, company_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, parent_id, company_id, create_time_utc, create_user_id, update_time_utc, update_user_id', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'folder_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'parentProductFolder' => array(self::BELONGS_TO, 'ProductFolder', 'parent_id'),
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
			'parent_id' => 'Parent',
			'company_id' => 'Company',
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('company_id',$this->company_id);
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
	 * @return ProductFolder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return array get all folders
     */
    public function getAllFolders()
    {
        $folders = ProductFolder::model()->find("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        $result = array();
        if(!empty($folders))
            foreach($folders as $folder)
            {
                $result[$folder->id] = array(
                    'id' => $folder->id,
                    'name' => $folder->name,
                    'parent_id' => $folder->parent_id,
                );
            }

        return $result;
    }

    /**
     * @param bool $start
     * @return string get cascaded folder name for drop down list
     */
    public function getCascadeFolderNameRec($start=true)
    {
        if(isset($this->parentProductFolder))
        {
            if($start)
                return $this->parentProductFolder->getCascadeFolderNameRec(false).'- - '.$this->name;
            else
                return $this->parentProductFolder->getCascadeFolderNameRec(false).'- - ';
        }
        else
        {
            if($start)
                return $this->name;
            else
                return '| ';
        }
    }
}
