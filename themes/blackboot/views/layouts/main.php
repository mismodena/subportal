<?php
	Yii::app()->clientscript
		// use it when you need it!
		/*
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap-responsive.css' )
		->registerCoreScript( 'jquery' )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-transition.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-alert.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-dropdown.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-scrollspy.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tab.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tooltip.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-popover.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-button.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-collapse.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-carousel.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-typeahead.js', CClientScript::POS_END )
		*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta name="language" content="en" />
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- Le styles -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
<!-- Le fav and touch icons -->
    <script type="text/javascript">
           /* $(document).ready(function(){
                var i=1;
                //.portlet-content一定要加上去，不然会影响分页下带.active的元素
                $(".portlet-content .active").each(function(){
                    $(this).nextUntil(".active").css('display', 'none');
                    $(this).attr('value',i);
                    if($.cookie('a'+i)==i){
                        //alert('cookie=='+i);
                        $(this).nextUntil(".active").css('display', 'block');
                        $(this).children('a').children('i').removeClass('icon-play').addClass('icon-download-alt');
                        $(this).addClass('hasclick');
                    }
                    i++;
                });
                $(".active").each(function(){
                    $(this).click(function(){
                        if($(this).hasClass('hasclick')){
                            $(this).nextUntil(".active").css('display', 'none');
                            $(this).children('a').children('i').removeClass('icon-download-alt').addClass('icon-play');
                            $(this).removeClass('hasclick');
                            var val=$(this).val();
                            $.cookie('a'+val,'0');
                        }else{
                            $(this).nextUntil(".active").css('display', 'block');
                            $(this).children('a').children('i').removeClass('icon-play').addClass('icon-download-alt');
                            $(this).addClass('hasclick');
                            var val=$(this).val();
                            $.cookie('a'+val,val);
                        }
                    });
                });
            });*/
        </script>
</head>

<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#"><?php echo Yii::app()->name ?></a>
				<div class="nav-collapse">
					<?php /*$this->widget('zii.widgets.CMenu',array(
						'htmlOptions' => array( 'class' => 'nav' ),
						'activeCssClass'	=> 'active',
						'items'=>array(
							array('label'=>'Home', 'url'=>array('/site/index')),
							array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
							array('label'=>'Contact', 'url'=>array('/site/contact')),
							array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
							array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
						),
					)); */?>
					
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	
	<div class="cont">
	<div class="container-fluid">
	  <?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'homeLink'=>false,
				'tagName'=>'ul',
				'separator'=>'',
				'activeLinkTemplate'=>'<li><a href="{url}">{label}</a> <span class="divider">/</span></li>',
				'inactiveLinkTemplate'=>'<li><span>{label}</span></li>',
				'htmlOptions'=>array ('class'=>'breadcrumb')
			)); ?>
		<!-- breadcrumbs -->
	  <?php endif?>
	<!-- left menu starts -->
            <div class="span2 main-menu-span">
                    <!--<div id="sidebar">-->
            <?php
               /* $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>'',
                ));
                $this->widget('bootstrap.widgets.TbMenu', array(
                    'type'=>'tabs',
                    'stacked'=>true,
                    'items'=>array(
                        array('label'=>'','icon'=>'menu','url'=>''),
                        array('label'=>'用户管理','icon'=>'play','url'=>'','active'=>true),
                        array('label'=>'用户列表','url'=>'./index.php?r=admin/dhAdmin/admin'),
                        array('label'=>'添加用户','url'=>'./index.php?r=admin/dhAdmin/create'),
                        array('label'=>'商品管理','icon'=>'play','url'=>'','active'=>true),
                        array('label'=>'分类列表','url'=>'./index.php?r=admin/dhAdmin/admin'),
                        array('label'=>'添加分类','url'=>'./index.php?r=admin/dhAdmin/create'),
                        array('label'=>'商品列表','url'=>'./index.php?r=admin/dhAdmin/admin'),
                        array('label'=>'添加商品','url'=>'./index.php?r=admin/dhAdmin/create'),
                        array('label'=>'文章管理','icon'=>'play','url'=>'','active'=>true),
                        array('label'=>'分类列表','url'=>'./index.php?r=admin/dhAdmin/admin'),
                        array('label'=>'添加分类','url'=>'./index.php?r=admin/dhAdmin/create'),
                        array('label'=>'文章列表','url'=>'./index.php?r=admin/dhAdmin/admin'),
                        array('label'=>'添加文章','url'=>'./index.php?r=admin/dhAdmin/create'),
                        array('label'=>'网站管理','icon'=>'play','url'=>'','active'=>true),
                        array('label'=>'系统参数','url'=>'./index.php?r=admin/dhWebconfig/admin'),
                        array('label'=>'添加分类','url'=>'./index.php?r=admin/dhWebconfig/create'),
                        array('label'=>'文章列表','url'=>'./index.php?r=admin/dhAdmin/admin'),
                        array('label'=>'添加文章','url'=>'./index.php?r=admin/dhAdmin/create'),
                    ),
                    'htmlOptions'=>array('class'=>'mymenu'),
                ));
                $this->endWidget();*/
            ?>
            <!--</div><!-- sidebar -->
                <?php
                $this->widget('bootstrap.widgets.TbMenu', array(
                    'type'=>'tabs',
                    'stacked'=>true,
                    //'type'=>'list',
                    'items'=>array(
                        array('label'=>'Home', 'icon'=>'home', 'url'=>array('/site/index')),
                        array('label'=>'Department', 'items'=>array(
                            array('label'=>'Submenu', 'url'=>array('/site/logout'),
                                    ),
                                array('label'=>'Admin Mngt','icon'=>'globe','url'=>'admin'),
                                array('label'=>'Departments','icon'=>' icon-th-large','url'=>'admin'), //onlick list all the department in certain table

                            ),),
                        array('label'=>'Logout', 'icon'=>'icon-off', 'url'=>array('/site/logout')),
                )));
                
                ?> 

                    <!--<div class="well nav-collapse sidebar-nav">
                            <ul class="nav nav-tabs nav-stacked main-menu">
                                    <li class="nav-header hidden-tablet">Inventory</li>
                                    <li><a  href='<?php //Yii::app()->createUrl('user/index')?>'><i class="icon-list"></i><span class="hidden-tablet"> Receipt Entry</span></a></li>
                                    <li><a  href="<?php //Yii::app()->controller->createUrl('user/create')?>"><i class="icon-list"></i><span class="hidden-tablet"> Order Entry</span></a></li>						
                                    <li><a  href="<?php //Yii::app()->controller->createUrl('user/admin')?>"><i class="icon-list"></i><span class="hidden-tablet"> IC Transfer</span></a></li>
                                    <li><a  href="<?php //Yii::app()->controller->createUrl('user/admin')?>"><i class="icon-list"></i><span class="hidden-tablet"> Shipment</span></a></li>
                            </ul>
                            <label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="hidden"></label>
                    </div>--><!--/.well -->
            </div><!--/span-->
            <!-- left menu ends -->
            <div id="content" class="span10">
            <?php echo $content ?>
            </div>
	
	
	
	</div><!--/.fluid-container-->
	</div>
	
	
	
	<div class="footer">
	  <div class="container">
		<div class="row">
			<div id="footer-copyright" class="col-md-6">
				About us | Contact us | Terms & Conditions
			</div> <!-- /span6 -->
			<div id="footer-terms" class="col-md-6">
				Copyright © 2015, INDOMO MULIA. Supported by <a href="http://www.yiiframework.com" target="_blank">YiiBootstrap</a>.
			</div> <!-- /.span6 -->
		 </div> <!-- /row -->
	  </div> <!-- /container -->
	</div>
</body>
</html>
