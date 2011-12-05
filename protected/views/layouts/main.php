<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-lightness/jquery-ui.css" media="screen, projection" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        
        <!-- js -->
        <? Yii::app()->getClientScript()->registerScriptFile( Yii::app()->request->baseUrl . '/js/jquery-ui.min.js' ); ?>
        <? Yii::app()->getClientScript()->registerScriptFile( Yii::app()->request->baseUrl . '/js/search.js' ); ?>
        

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

        <div class="container" id="page">

                <div id="mainmenu">
                        <?php $this->widget('zii.widgets.CMenu',array(
                                'items'=>array(
                                        array('label'=>'Home', 'url'=>array('/site/index')),
//                                        array('label'=>'Nodes', 'url'=>array('/nodes/index')),
                                        array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                                        array('label'=>'Contact', 'url'=>array('/site/contact')),
                                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                                ),
                        )); ?>
                </div><!-- mainmenu -->
                
                <?php if(isset($this->breadcrumbs)):?>
                        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                                'links'=>$this->breadcrumbs,
                        )); ?><!-- breadcrumbs -->
                <?php endif?>

                <?php echo $content; ?>

        </div><!-- page -->

</body>
</html>