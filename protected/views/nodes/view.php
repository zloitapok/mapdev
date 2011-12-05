<?php

Yii::app()->getClientScript()->registerScriptFile( 'http://maps.google.com/maps/api/js?sensor=false' );
Yii::app()->getClientScript()->registerScriptFile( Yii::app()->request->baseUrl . '/js/viewNode.js' );

Yii::app()->getClientScript()->registerScript( 'initialize map', "
        jQuery(document).ready(function() {
                var lat = " . $model->lat . ";
                var lng = " . $model->lng . ";
                initialize(lat, lng);
        });
");

$this->breadcrumbs=array(
	'Nodes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Nodes', 'url'=>array('index')),
	array('label'=>'Create Nodes', 'url'=>array('create')),
	array('label'=>'Update Nodes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Nodes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Nodes', 'url'=>array('admin')),
);
?>

<h1>View Nodes #<?php echo $model->id; ?></h1>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
		'create_time',
		'change_time',
		'created_by',
		'keywords',
		'description',
		'tags',
		'lat',
		'lng',
		'photo',
		'phones',
		'address',
//		'status',
	),
)); ?>

<div id="map_canvas" style="width:100%;height:500px;"></div>