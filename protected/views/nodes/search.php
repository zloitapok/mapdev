<?php
$this->breadcrumbs=array(
	'Nodes' => Yii::app()->request->baseUrl . '/nodes/',
        'Search',
);

$this->menu=array(
	array('label'=>'Create Nodes', 'url'=>array('create')),
	array('label'=>'Manage Nodes', 'url'=>array('admin')),
);
?>

<h1>Search results</h1>
<div>You searched: <u><?=$this->search_request?></u></div>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
