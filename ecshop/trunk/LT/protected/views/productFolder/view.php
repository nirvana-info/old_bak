<?php
/* @var $this ProductFolderController */
/* @var $model ProductFolder */

$this->breadcrumbs=array(
	'Product Folders'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProductFolder', 'url'=>array('index')),
	array('label'=>'Create ProductFolder', 'url'=>array('create')),
	array('label'=>'Update ProductFolder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductFolder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductFolder', 'url'=>array('admin')),
);
?>

<h1>View ProductFolder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'parent_id',
		'company_id',
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id',
	),
)); ?>
