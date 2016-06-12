<div class="wrap" ng-app="StarlingApp">
	<section ng-view></section>

	<footer>

		<!-- <link rel="stylesheet" type="text/css" href="<?=$plugins_url . 'app/assets/css/style.css'?>"/> -->
		<link rel="stylesheet" type="text/css" href="<?=$plugins_url . 'scripts/css/libs/semantic.min.css'?>"/>
		<link rel="stylesheet" type="text/css" href="<?=$plugins_url . 'scripts/css/main.css'?>"/>

		<script type="text/javascript">window.jQuery || document.write('<script'+' src="<?=$plugins_url . 'scripts/js/libs/jquery.min.js'?>"></'+'script>');</script>

		<script src="<?=$plugins_url . 'scripts/js/libs/angular.min.js'?>"></script>
		<script src="<?=$plugins_url . 'scripts/js/libs/angular-route.min.js'?>"></script>
		<script src="<?=$plugins_url . 'scripts/js/libs/semantic.min.js'?>"></script>


		<script type="text/javascript">
			var baseUrl = "<?=$plugins_url?>",
					adminUrl = "<?=get_admin_url()."admin-ajax.php";?>",
					siteUrl = "<?=site_url('/')?>";
			</script>

		<script src="<?=$plugins_url . 'app/app.js'?>"></script>
		<script src="<?=$plugins_url . 'app/controllers.js'?>"></script>
		<script src="<?=$plugins_url . 'app/services.js'?>"></script>


		</footer>
</div>
