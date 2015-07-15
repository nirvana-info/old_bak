<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-9-16
 * Time: 10:18am
 */

/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
    'Register',
);
?>

<h1>Sign In</h1>

<p>Please fill out the following form with your register information:</p>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'register-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <hr>

    <h3>Personal Information</h3>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'password_repeat'); ?>
        <?php echo $form->passwordField($model,'password_repeat',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'password_repeat'); ?>
    </div>

    <hr>

    <h3>Company Information</h3>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'phone'); ?>
        <?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'country'); ?>
        <?php echo $form->textField($model,'country',array('size'=>20,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'country'); ?>
    </div>

    <hr>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Sign In'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->