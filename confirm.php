<?php
$p="";
if (isset($_GET['pseudo'])) {
	$p = htmlspecialchars($_GET['pseudo']);
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Confirme</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<style type="text/css">
	html, body{
		margin: 0;
		padding: 0;
		height: 100%;
        width: 100%;
	}
	body{
		display: flex;
		background-position: center;
		background-image: url('wolk.jpg');
		background-size: cover;
	}
	.center{
		height: 300px;
		width: 500px;
		margin: auto;
		box-shadow: -1px -2px 14px 1px rgb(194, 200, 212);
        background-color: #4eedf545;
	}
	h3, h4, a{
		text-align: center;
		text-decoration: none;
	}
	@media all and (max-width: 500px){
		.center{
			width: 90%;
		}
	}
</style>
<body>
<div class="center">
	<h3>Please confirme your account.</h3>
	<h4>Haven't received your email yet? <a id='retry' href="#">Retry.</a></h4>

</div>
<script type="text/javascript">
	document.getElementById('retry').addEventListener('click', function(){
  $.post(
  "reconfirm.php",
    {
        pseudo : <?php echo $p; ?>
    },
                function(data){

                },

            'text'
         );
});
</script>
</body>
</html>