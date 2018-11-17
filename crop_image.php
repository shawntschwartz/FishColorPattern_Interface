<?php 
	include 'snippets/header.php';
	include 'snippets/main.php';

	$current_image = $_GET['image'];
	$scaled_width = $_GET['swidth'];
	$scaled_height = $_GET['sheight'];
?>

	<p class="lead">You are currently cropping <strong><em><?php echo $current_image; ?></em></strong>
		<br />
		<em>New Scaled Dimensions: <?php echo round($scaled_width); ?> x <?php echo round($scaled_height); ?></em>
	</p>

	<script>

		$(function($){
			var jcrop_api; // Holder for the API
		initJcrop();

		function initJcrop(){
		  $('.requiresjcrop').hide();

		  $('#cropbox').Jcrop({
		  	trueSize: [<?php echo $scaled_width; ?>, <?php echo $scaled_height; ?>],
		  	bgColor: '',
		  	bgOpacity: .4
		  },function(){

		    $('.requiresjcrop').show();

		    jcrop_api = this;
		    jcrop_api.animateTo([100,100,400,300]);

		  });

		};

		jcrop_api.setOptions({allowResize: false});
		jcrop_api.setOptions({minSize: [150, 150], maxSize: [150, 150]});
		// jcrop_api.setOptions({bgColor: ''});
		jcrop_api.focus();

		});


	    $(function(){
			$('#cropbox').Jcrop({
				aspectRatio: 1,
				onSelect: updateCoords
			});
		});

	  	function updateCoords(c){
	    	$('#x').val(c.x);
	    	$('#y').val(c.y);

	    	$('#w').val(c.w);
	    	$('#h').val(c.h);

	    	console.log(c.x);
	    	console.log(c.y);

	    	console.log(c.w);
	    	console.log(c.h);
	  	};

		  function checkCoords(){
		  	if (parseInt($('#w').val())) return true;
		    alert('Please select a crop region then press submit.');
		    return false;
		  };

	</script>
	<img src="<?php echo $current_image; ?>" id="cropbox" width="<?php echo $scaled_width; ?>" height="<?php echo $scaled_height; ?>" />
	<br />
	<form action="execute_crop.php?image=<?php echo $current_image; ?>&swidth=<?php echo $scaled_width; ?>&sheight=<?php echo $scaled_height; ?>" method="post" target="_blank" onsubmit="return checkCoords();">
		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		<input type="submit" value="Subsample Fish &raquo;" class="btn btn-primary btn-lg" />
	</form>