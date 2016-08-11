<form action="save.php" method="post">
<?php
if($_GET["name"]){
?>
<textarea rows="30" cols="80" name="content">
<?php
	if($myfile = fopen($_GET["name"], "r")){
		echo fread($myfile,filesize($_GET["name"]));
		fclose($myfile);
	}else{
		echo "Unable to open file!";
	} 
?>
</textarea><br/><br/>
<?php
}else{
?>
<textarea rows="30" cols="80" name="content">
Type here your content.
</textarea><br/><br/>
<?php
}

if($_GET["name"]){
	echo "<input type='text' name='name' value='".$_GET["name"]."'><input type='submit' value='save'>";
}else{
?>
<input type="text" name="name"><input type="submit" value="save">
<?php	
}
?>
</form>
<form action="edit.php">
<input type="text" name="name"><input type="submit" value="load">
</form>

<div style="right: 80px; top: 10px; position: fixed;">
	<ul>
<?php

	foreach(scandir(".") as $file) {
		
		echo "<li><a href='edit.php?name=".$file."'>".$file."</a></li>";
		
	}
?>
	</ul>
</div>