# algoritma-stemming-nazief-adriani

<!DOCTYPE html>
<html>
<head>
	<title>STEMMING</title>
</head>
<body>
<h3>PENCARIAN KATA DASAR</h3>
<form method="post" action="/stemming">
{{ csrf_field() }}
<input type="text" name="kata" id="kata" size="20">
<input class="btnForm" type="submit" name="submit" value="Submit"/>
</form>
<?php
if(isset($kata)){
    echo $kata;
}

// if(isset($_POST['kata'])){
// 	$teksAsli = $_POST['kata'];
// 	echo "Teks asli : ".$teksAsli.'<br/>';
// 	$stemming = Enhanced_CS($teksAsli);
// 	echo "Kata dasar : ".$stemming.'<br/>';
// }
?>
</body>
</html>