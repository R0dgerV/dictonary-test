<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">


	<link rel="stylesheet" type="text/css" href="/js/components/bootstrap/dist/css/bootstrap.min.css" media="all" />

	<script src="/js/components/jquery/dist/jquery.min.js" type="text/javascript"></script>

	<script src="/js/components/angular/angular.min.js" type="text/javascript"></script>

	<script src="/js/components/lodash/lodash.min.js" type="text/javascript"></script>

	<script src="/js/components/angular-i18n/angular-locale_ru-ru.js" type="text/javascript"></script>
	<script src="/js/components/angular-messages/angular-messages.min.js" type="text/javascript"></script>

	<script src="/js/components/angular-loading-bar/build/loading-bar.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="/js/components/angular-loading-bar/build/loading-bar.min.css">

	<script src="/js/components/ng-notify/dist/ng-notify.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="/js/components/ng-notify/dist/ng-notify.min.css">

	<script src="/js/components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/js/components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>

	<script src="/js/controllers/app.js" type="text/javascript"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Rodger.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
