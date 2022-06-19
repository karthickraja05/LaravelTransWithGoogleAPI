<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Language File Creator</title>
	<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

	<?php
		$data = json_decode(file_get_contents('language.json'));
	?>

	<div class="container">
	  <h2 style="text-align: center;">Select Language</h2>
	  <p><b>Note:</b></p>
	  <p>Output Files will be created in final_result folder.</p>
	  <p>Before Please give proper folder permission.</p>
	  <p>You Should update Google Trans API Keys. Otherwise it should not trans.</p>
	  <p><input class="form-check-input" type="checkbox" id="selectall"> Select All</p>
	  <form action="create_lang.php" method="post">
	   		<table class="table">
	   		  <tbody>
	   		    <tr>
	   		<?php
	   		$i = 0;
	   		foreach ($data as $key => $value) { 
	   			$i++;
	   		  ?>
	   		
	   		      <td><input class="form-check-input lang_box" type="checkbox" name="lang[]"  value="<?php echo $key; ?>"> <?php echo $value->name; ?> </td>
	   		      
	   		    
	   	  <?php 
	   		if($i == 5){
	   			$i = 0;
	   			echo '</tr><tr>';
	   		}
	   		}  ?>
	   		</tr>
	   		  </tbody>
	   		</table>	
	   	
	   		<button type="submit" class="btn btn-primary">Submit</button>
	  </form>
	</div>


</body>
</html>
<script type="text/javascript">
	$('#selectall').click(function () {
		if ($('#selectall').is(':checked') == true) {
			$('.lang_box').each(function(){ this.checked = true; });
		}else{
	    	$('.lang_box').each(function(){ this.checked = false; });
	    }
	});

	    
</script>