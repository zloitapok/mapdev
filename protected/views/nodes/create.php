<?php
$this->breadcrumbs=array(
	'Nodes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Nodes', 'url'=>array('index')),
	array('label'=>'Manage Nodes', 'url'=>array('admin')),
);
?>

<h1>Create Nodes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>