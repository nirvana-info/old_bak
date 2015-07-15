<?php
/* @var $this StoreController */
/* @var $model Store */

$this->breadcrumbs=array(
	'Stores'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Store', 'url'=>array('index')),
	array('label'=>'Create Store', 'url'=>array('create')),
	array('label'=>'Update Store', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Store', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Store', 'url'=>array('admin')),
);
?>

<h1>View Store:&nbsp;<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'name',
        array(
            'name' => 'platform',
            'value' => CHtml::encode($model->getPlatformText())
        ),
        array(
            'name' => 'is_active',
            'value' => CHtml::encode($model->getIsActiveText())
        ),
		/*'company_id',
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id',*/
	),
)); ?>
