<?php
/* @var $this ProductFolderController */
/* @var $model ProductFolder */

$this->breadcrumbs=array(
	'Product Folders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProductFolder', 'url'=>array('index')),
	array('label'=>'Create ProductFolder', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-folder-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Folders</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-folder-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'parent_id',
		'company_id',
		'create_time_utc',
		'create_user_id',
		/*
		'update_time_utc',
		'update_user_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
