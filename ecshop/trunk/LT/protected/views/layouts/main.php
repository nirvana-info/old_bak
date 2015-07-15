<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <!-- start of custom CSS file -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/css/dropdown/dropdown.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/css/dropdown/dropdown.vertical.rtl.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dropdownmenu/css/dropdown/themes/default/default.ultimate.css" />
    <!-- end of custom CSS file -->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header" class="container">
		<div id="logo" class="left"><?php echo CHtml::encode(Yii::app()->name); ?></div>
        <div class="right"><h5 class="append-1 prepend-top" style="vertical-align: text-bottom;">
                <?php if(Yii::app()->user->isGuest): ?>
                    <?php echo CHtml::link("SignIn",array('/site/register'));?>&nbsp;|&nbsp;<?php echo CHtml::link("Login",array('/site/login'));?>
                <?php else: ?>
                    <?php echo CHtml::encode(Yii::app()->user->name." (".Yii::app()->session['company']->name.")"); ?>&nbsp;|&nbsp;<?php echo CHtml::link("Logout",array('/site/logout'));?>
                <?php endif;?>
        </h5></div>
	</div><!-- header -->

	<div id="menu-top">
		<?php $this->widget('zii.widgets.CMenu',array(
            'activeCssClass'=>'active',
            'activateParents'=>true,
            'htmlOptions'=>array('id'=>'nav','class'=>'dropdown dropdown-horizontal'),
            'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
                array(
                    'label'=>'Product',
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'items'=>array(
                        array('label'=>'Manage Folder', 'url'=>array('/ProductFolder')),
                        array('label'=>'Manage Attribute', 'url'=>array('/EntityAttributeSet')),
                    ),
                ),
                array(
                    'label'=>'eBay',
                    'visible'=>!Yii::app()->user->isGuest,
                    'url'=>array('/eBay')
                ),
                array(
                    'label'=>'System',
                    'itemOptions'=>array('class'=>'dir'),
                    'visible'=>!Yii::app()->user->isGuest,
                    'items'=>array(
                        array('label'=>'Manage User', 'url'=>array('/User')),
                        array('label'=>'Manage Store', 'url'=>array('/Store')),
                        array('label'=>'Company Information', 'url'=>array('/Company')),
                    ),
                ),
                array(
                    'label'=>'Help',
                    'itemOptions'=>array('class'=>'dir'),
                    'items'=>array(
                        array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                        array('label'=>'Contact', 'url'=>array('/site/contact')),
                    ),
                ),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?><br/>
        <?php $result = @CDbConnection::getStats(); echo "SQL executed: {$result[0]}, Time usage: {$result[1]}"?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
