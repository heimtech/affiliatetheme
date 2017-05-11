<?php
global $affiliseo_options;
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php bloginfo( 'url' ); ?>">
	<div class="input-group-custom full-size">
		<input type="text" class="form-control-custom col10" placeholder="<?php echo $affiliseo_options['text_suchformular_header_input']; ?>" name="s" id="s">
		<div class="col2">
			<button class="btn-search pull-right" type="submit" id="searchsubmit">
				<i class='fa fa-search'></i>
			</button>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</form>