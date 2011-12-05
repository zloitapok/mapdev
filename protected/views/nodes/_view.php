<div class="view" style="position: relative;">
        
        <div style="float:left; margin: 0 20px 0 0;">
                <?php $photo_url = $data->photo ? $data->photo : '/images/no-photo.jpg'; ?>
                
                <?php echo CHtml::link(CHtml::image($photo_url, 'no photo avaliable', array('style'=>'width:200px; height:165px;', 'class'=>'image')), array('view', 'id'=>$data->id)); ?>
                
                <?php
                if ($data->lat && $data->lng)
                {
                        $this->widget('application.components.widgets.WGoogleStaticMap',array(
                                'center'=>implode(',', array($data->lat, $data->lng)), // Or you can use text eg. Dundee, Scotland
                                'alt'=>$data->title, // Alt text for image (optional)
                                'zoom'=>15, // Google map zoom level
                                'width'=>200, // image width
                                'height'=>165, // image Height
                                'markers'=>array(
                                        array(
                                                'style'=>array('color'=>'green'),
                                                'locations'=>array(implode(',', array($data->lat, $data->lng))), // Or use lat/long pairs
                                        ),
                                ),
                                'linkUrl'=>array('nodes/' . $data->id), // Where the image should link (optional)
                                'linkOptions'=>array('target'=>'_self'), // HTML options for link tag (optional)
                                'maptype'=>'hybrid',
                                'imageOptions'=>array('class'=>'map-image'), // HTML options for img tag (optional)
                        ));
                }
                ?>
                
        </div>
        
        <div class="to-right">
                <b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
                <?php echo CHtml::encode($data->createdBy->username); ?>
                <br />
        </div>
        
	<h3 class="title"><?php echo CHtml::encode($data->title); ?></h3>
	<br />
        
        <?php
        $tags = array();
        foreach(explode(',', $data->tags) as $t)
        {
                $tags[] = CHtml::link(CHtml::encode($t), '/nodes/search/?search_request=' . $t);
        }
        $tags = implode(', ', $tags);
        ?>
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?>:</b>
	<?php echo $tags; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phones')); ?>:</b>
	<?php echo CHtml::encode($data->phones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('services')); ?>:</b>
	<?php echo CHtml::encode($data->services); ?>
	<br />
        
        <?php echo CHtml::link('Learn more...', array('view', 'id'=>$data->id), array('style'=>"position: absolute; bottom:10px; right: 10px;")); ?>
        
        <div style="clear: both;"></div>
        
</div>