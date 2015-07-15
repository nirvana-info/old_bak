<?php
/* @var $this EntityAttributeSetController */
/* @var $model EntityAttributeSet */

$this->breadcrumbs=array(
	'Entity Attribute Sets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EntityAttributeSet', 'url'=>array('index')),
	array('label'=>'Manage EntityAttributeSet', 'url'=>array('admin')),
);
?>

<h1>Create EntityAttributeSet</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>