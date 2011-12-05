<?php $this->pageTitle=Yii::app()->name; ?>
<?php
Yii::app()->getClientScript()->registerScriptFile( 'http://maps.google.com/maps/api/js?sensor=false' );
Yii::app()->getClientScript()->registerScriptFile( Yii::app()->request->baseUrl . '/js/site.js' );

$points =  CJavaScript::encode(array('points' => $points));

Yii::app()->getClientScript()->registerScript('map', "
        jQuery(document).ready(function() {
                var centerLat = 47.8388;
                var centerLng = 35.1395669999999;
                initialize(centerLat, centerLng);
        });
");

Yii::app()->getClientScript()->registerScript('points', "
        jQuery(document).ready(function() {
                fillMarkersPool(".$points.");
        });
");
?>
<!--<div style="text-align: center; margin: 0 0 10px 0;">
        <?php echo CHtml::label('Search on the map', 'mapSearch'); ?>&nbsp;
        <?php echo CHtml::textField('mapSearch', '', array('id'=>'mapSearch', 'style'=>'width: 300px;')); ?>&nbsp;
        <a id="runSearch">Search</a>
</div>-->

<div id="right-block">
        <div id="title">
                <div class="to-right"><a id="toggle-right-block" href="#">Свернуть</a></div>
                <div class="to-left"><a id="toggle-search" href="#">Поиск</a></div>
                <div class="center">
                        <div>
                                МЕНЮ
                        </div>
                        <form id="searchSmb">
                                <?php echo CHtml::textField('mapSearch', '', array('id'=>'mapSearch')); ?>
                        </form>
                </div>
        </div>
        <div id="body">
                <?php foreach ($categories as $c) : ?>
                
                <div class="category">
                        <span class="to-right counter">
                                (<?php echo count($c['nodes']); ?>)
                        </span>
                        <div class="title">
                                <a href="#"><?php echo $c['name']; ?></a>
                        </div>
                        <div class="body">
                                <?php foreach($c['nodes'] as $n_id=>$n_title) : ?>
                                <span node_id="<?php echo $n_id; ?>" class="node">
                                        <a href="#"><?php echo $n_title; ?></a>
                                </span>
                                <?php endforeach; ?>
                                <div class="clear-left"></div>
                        </div>
                </div>
                <?php endforeach; ?>
        </div>
</div>

<div id="map_canvas" style="width:100%;height:0px;"></div>

