<?php
/* @var $this ProductFolderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Folders',
);

$this->menu=array(
	array('label'=>'Create ProductFolder', 'url'=>array('create')),
	array('label'=>'Manage ProductFolder', 'url'=>array('admin')),
);
?>

<h1>Product Folders</h1>


<?php $this->widget('ext.ztree.zTree',array(
    'treeNodeNameKey'=>'name',
    'treeNodeKey'=>'id',
    'treeNodeParentKey'=>'parent_id',
    'options'=>array(
        'expandSpeed'=>"",
        'showLine'=>true,
    ),
    'model'=>"ProductFolder",
    'data'=>ProductFolder::model()->getAllFolders()
)); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
