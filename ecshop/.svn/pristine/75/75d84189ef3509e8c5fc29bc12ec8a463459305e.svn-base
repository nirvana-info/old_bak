<?php
/* @var $this StoreController */
/* @var $model Store */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'store-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="container">
        <div class="row left span-4">
            <?php echo $form->labelEx($model,'name'); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
    </div>

    <div class="container">
        <div class="row left span-4">
            <?php echo $form->labelEx($model,'platform'); ?>
        </div>
        <div class="row left">
            <?php echo $form->dropDownList($model,'platform', $model->getPlatformOptions()); ?>
            <?php echo $form->error($model,'platform'); ?>
        </div>
    </div>

    <div class="container">
        <div class="row left span-4">
            <?php echo $form->labelEx($model,'is_active'); ?>
        </div>
        <div class="row left">
            <?php echo $form->dropDownList($model,'is_active', $model->getIsActiveOptions()); ?>
            <?php echo $form->error($model,'is_active'); ?>
        </div>
    </div>

    <div class="container">
        <div class="row left span-4">
            &nbsp;
        </div>
        <div class="row left">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->