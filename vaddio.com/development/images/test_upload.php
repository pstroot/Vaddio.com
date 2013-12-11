
<form method="POST" action="" enctype="multipart/form-data">	
<input type="hidden" name="MAX_FILE_SIZE" value="20000000">
<input type="file" name="testfile" />
<input type="submit" name="testsubmit" value="GO" />
</form>

<?

echo  "upload_max_filesize = " . (ini_get('upload_max_filesize')) . "<BR>";
echo  "post_max_size = " . (ini_get('post_max_size')) . "<BR>";
echo  "memory_limit = " . (ini_get('memory_limit')) . "<BR>";
echo  "max_execution_time = " . (ini_get('max_execution_time')) . "<BR>";
echo  "max_input_time = " . (ini_get('max_input_time')) . "<BR>";

if(isset($_POST["testsubmit"])){
	print"<pre>";
	print_r($_FILES);
	print"</pre>";
}
?>