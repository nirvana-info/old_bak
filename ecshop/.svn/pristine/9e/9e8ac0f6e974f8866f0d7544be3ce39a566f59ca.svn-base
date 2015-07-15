<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-15
 * Time: 2:00pm
 */

/* @var $this EntityAttributeSetController */
/* @var $model EntityAttribute */
/* @var $form CActiveForm */
?>

<div>
    <div style="width: 100%;clear: both;">
        <div class="row left span-2">
            <?php echo $form->labelEx($model,'name', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row left span-2">
            <?php echo $form->labelEx($model,'type', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->dropDownList($model,'type', $model->getTypeOptions(), array('empty'=>'Please select a Type')); ?>
            <?php echo $form->error($model,'type'); ?>
        </div>
        <div class="row">
            <?php echo CHtml::button("Add New Atribute", array('onclick'=>'verifyAttribute();')); ?><br />
            <?php echo CHtml::checkBox("add_to_selected", true, array()); ?>
            <?php echo CHtml::label("add to selected attribute", false, array('style'=>'display: inline;')); ?>
        </div>
    </div>
</div>

<script>
    function verifyAttribute()
    {

    }
</script>