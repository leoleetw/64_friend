<?
	 $filename = "../temp/about.html";
	 if($_POST["action"]=="update"){
			file_put_contents($filename, $_POST["content"]);
	 }
   $myhtml = file_get_contents($filename);
?>
<form id="form1" method="post" action="edit_about.php">
    <textarea id="content" name="content" style="width:100%"><? echo $myhtml; ?></textarea>
    <input type="hidden" id="action" name="action" value="update">
    <input type="submit" id="submit_btn" value="修改">
</form>

<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>