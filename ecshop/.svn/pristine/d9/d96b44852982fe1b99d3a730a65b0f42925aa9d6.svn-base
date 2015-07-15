<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-19
 * Time: 10:24pm
 */

abstract class NIAdminActiveRecord
{
    /**
     * Prepares create_time, create_user_id, update_time and
     * update_user_ id attributes before performing validation.
     */
    protected function beforeValidate()
    {

        if ($this->isNewRecord)
        {
            // set the create date, last updated date
            // and the user doing the creating
            //if(!$this->company_id) $this->company_id = Yii::app()->session['user']->company_id;
            $this->create_time_utc=$this->update_time_utc=time();
            //$this->create_user_id = $this->update_user_id = Yii::app()->user->id;
        }
        else
        {
            //not a new record, so just set the last updated time
            //and last updated user id
            $this->update_time_utc=time();
            //$this->update_user_id = Yii::app()->user->id;

        }
        return parent::beforeValidate();
    }
} 