<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-9-16
 * Time: 10:09am
 */

class RegisterForm extends CFormModel
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $name;
    public $phone;
    public $country;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('username, password, email, name', 'required'),
            array('password', 'compare'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email' => 'Email Address',
            'username' => 'User Name',
            'password' => 'Password',
            'name' => 'Company Name',
            'phone' => 'Phone Number',
            'Country' => 'Country or Area'
        );
    }

    /**
     * check if email or username has been registered
     */
    public function validation()
    {
        $criteria=new CDbCriteria();
        $criteria->select='id';
        $criteria->condition='username=:username or email=:email';
        $criteria->params=array(':username'=>$this->username, ':email'=>$this->email);
        $result = User::model()->findAll($criteria);
        if($result)
            return false;
        else
            return true;
    }

    /**
     * create new company & user as creator & admin
     */
    public function register()
    {
        $transaction= Yii::app()->db->beginTransaction();
        try
        {
            //create company first
            $company = new Company();
            $company->name = $this->name;
            $company->country = $this->country;
            $company->phone = $this->phone;
            if(!$company->save())
            {
                $transaction->rollback();
                return false;
            }

            //create user
            $user = new User();
            $user->username = $this->username;
            $user->password = $user->encrypt($this->password);
            $user->password_repeat = $this->password_repeat;
            $user->email = $this->email;
            $user->company_id = $company->id;
            $user->create_time_utc = $user->update_time_utc = time();
            if(!$user->save(false))
            {
                $transaction->rollback();
                return false;
            }

            $company->owner_id = $company->create_user_id = $company->update_user_id = $user->id;
            if(!$company->update())
            {
                $transaction->rollback();
                return false;
            }

            $user->create_user_id = $user->update_user_id = $user->id;
            if(!$user->update())
            {
                $transaction->rollback();
                return false;
            }

            //create default product folder
            $defaultProductFolder = new ProductFolder();
            $defaultProductFolder->name = 'Main Folder';
            $defaultProductFolder->parent_id = 0;
            $defaultProductFolder->company_id = $company->id;
            if(!$defaultProductFolder->save())
            {
                $transaction->rollback();
                return false;
            }

            $transaction->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            return false;
        }
    }
} 