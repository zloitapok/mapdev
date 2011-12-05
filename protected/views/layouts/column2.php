<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-19">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-5 last">
		<div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
                        
                <div class="portlet">
                        <div class="portlet-decoration">
                                <div class="portlet-title">Tags</div>
                        </div>
                        <div class="portlet-content">
                                <?foreach(Nodes::getAllTags() as $tag=>$weight):?>
                                        <? $size = 10 + $weight * 10; ?>
                                        <a href="/nodes/search/?search_request=<?=$tag?>" style="color: #0066A4; font-size: <?=$size?>px"><?=$tag?></a>
                                <?endforeach?>
                        </div>
                </div>
                        
                
                        
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>