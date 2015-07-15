<?php
/* @var $this EntityAttributeSetController */
/* @var $model EntityAttributeSet */

$this->breadcrumbs=array(
	'Entity Attribute Sets'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EntityAttributeSet', 'url'=>array('index')),
	array('label'=>'Create EntityAttributeSet', 'url'=>array('create')),
    array('label'=>'Delete EntityAttributeSet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Update EntityAttributeSet <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>