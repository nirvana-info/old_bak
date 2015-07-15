<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->name,
);

$this->menu=array(
	/*array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Create Company', 'url'=>array('create')),*/
	array('label'=>'Update Company', 'url'=>array('update'/*, 'id'=>$model->id*/)),
	/*array('label'=>'Delete Company', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Company', 'url'=>array('admin')),*/
);
?>

<h1>View Company:&nbsp;<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'name',
		'phone',
		'country',
		/*'owner_id',
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id',*/
	),
)); ?>
