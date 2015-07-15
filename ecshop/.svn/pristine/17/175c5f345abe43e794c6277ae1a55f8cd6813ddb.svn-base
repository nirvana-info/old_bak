<?php
/* @var $this EntityAttributeSetController */
/* @var $model EntityAttributeSet */

$this->breadcrumbs=array(
	'Entity Attribute Sets'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List EntityAttributeSet', 'url'=>array('index')),
	array('label'=>'Create EntityAttributeSet', 'url'=>array('create')),
	array('label'=>'Update EntityAttributeSet', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EntityAttributeSet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View EntityAttributeSet #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'company_id',
		'is_hidden',
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id',
	),
)); ?>
