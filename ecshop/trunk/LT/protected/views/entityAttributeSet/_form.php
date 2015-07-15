<?php
/* @var $this EntityAttributeSetController */
/* @var $model EntityAttributeSet */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'entity-attribute-set-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="container">
        <div class="row left span-2">
            <?php echo $form->labelEx($model,'name', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="row buttons prepend-1 left">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
    </div>

    <div class="container" style="width: 100%">
        <div class="left" style="width: 340px;">
            <div class="row">
                <?php echo CHtml::label("Available Attributes: ", false, array('style'=>'')); ?>
            </div>
            <div class="row">
                <?php
                    $entityAttributes = EntityAttribute::model()->findAll(
                        array(
                            'condition'=>'company_id=:company_id',
                            'params'=>array(':company_id'=> Yii::app()->session['user']->company_id),
                        )
                    );
                    if(!empty($model->EntityAttributes))
                    {
                        $tempList = array();
                        foreach($entityAttributes as $attirbuteAll)
                        {
                            $findMatch = false;
                            foreach($model->EntityAttributes as $attirbuteHas)
                            {
                                if($attirbuteAll->id == $attirbuteHas->id)
                                {
                                    $findMatch = true;
                                    continue;
                                }
                            }
                            if(!$findMatch) $tempList[] = $attirbuteAll;
                        }
                        $entityAttributes = $tempList;
                    }
                    echo $form->dropDownList($model,'name', CHtml::listData($entityAttributes,'id','name'), array('style'=>'width: 90%; height: 150px;', 'multiple'=>'multiple'));?>
            </div>
            <div class="row">
                &nbsp;
            </div>
            <div class="row">
                <?php echo CHtml::label("Add New Attribute: ", false, array('style'=>'')); ?>
            </div>
            <div class="row">
                <?php $this->renderPartial('_attributeform', array('form'=>$form, 'model'=>new EntityAttribute())); ?>
            </div>
        </div>
        <div class="left" style="width: 40px; padding-top: 80px;">
            <?php echo CHtml::button("=>", array('onclick'=>'', 'style'=>'margin-left: -11px;')); ?><br />
            <?php echo CHtml::button("<=", array('onclick'=>'', 'style'=>'margin-left: -11px;')); ?>
        </div>
        <div class="left" style="width: 340px;">
            <div class="row">
                <?php echo CHtml::label("Selected Attributes: ", false, array('style'=>'')); ?>
            </div>
            <div class="row">
                <?php echo $form->dropDownList($model,'name', CHtml::listData($model->EntityAttributes,'id','name'), array('style'=>'width: 90%; height: 330px;', 'multiple'=>'multiple'));?>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->