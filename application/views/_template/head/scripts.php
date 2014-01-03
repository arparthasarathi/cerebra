		<script type="text/javascript" src="<? echo base_url(); ?>assets/scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<? echo base_url(); ?>assets/scripts/jquery.cookie.js"></script>
		<script type="text/javascript" src="<? echo base_url(); ?>assets/scripts/jquery.pjax.js"></script>
		<script type="text/javascript" src="<? echo base_url(); ?>assets/scripts/bootstrap.min.js"></script>
		
    	<script type="text/javascript" src="<? echo base_url(); ?>assets/scripts/responsiveslides.min.js"></script>	
		<script type="text/javascript">
			var base_url = "<? echo base_url(); ?>";			
		</script>
		
		<script type="text/javascript" src="<? echo base_url(); ?>assets/scripts/jquery.autocomplete.min.js"></script>
    	<script data-main="<? echo base_url(); ?>/assets/scripts/main" src="<? echo base_url(); ?>assets/scripts/require.js"></script>	
    	<script type="text/javascript">
    		var collegelist = [
			<? foreach ($colleges as $college) { ?>
				{ value: "<? echo $college['coll_name']; ?>" },
			<? } ?>
			];

			var degreelist = [
			<? foreach ($degrees as $degree) { ?>
				{ value: "<? echo $degree['degree']; ?>" },
			<? } ?>
			];

			var courselist = [
			<? foreach ($courses as $course) { ?>
				{ value: "<? echo $course['course']; ?>" },
			<? } ?>
			];

			var profiletype = <? echo $log->type; ?>;

			

    	</script>
		<script type="text/javascript" src="<? echo base_url(); ?>assets/scripts/application.js"></script>
		<? echo "\r\n"; ?>