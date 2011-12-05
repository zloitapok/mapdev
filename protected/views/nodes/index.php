<?php
$this->breadcrumbs=array(
	'Nodes',
);

$this->menu=array(
	array('label'=>'Create Nodes', 'url'=>array('create')),
	array('label'=>'Manage Nodes', 'url'=>array('admin')),
);

?>

<h1>Nodes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
