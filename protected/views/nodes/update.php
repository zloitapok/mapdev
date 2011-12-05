<?php
$this->breadcrumbs=array(
	'Nodes'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Nodes', 'url'=>array('index')),
	array('label'=>'Create Nodes', 'url'=>array('create')),
	array('label'=>'View Nodes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Nodes', 'url'=>array('admin')),
);
?>

<h1>Update Nodes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>