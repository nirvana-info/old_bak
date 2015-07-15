<?php
/* @var $this EntityAttributeSetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Entity Attribute Sets',
);

$this->menu=array(
	array('label'=>'Create EntityAttributeSet', 'url'=>array('create')),
);
?>

<h1>Entity Attribute Sets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
