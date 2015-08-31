<?
	include_once("include/dbinclude.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>交友網站</title>
    <!-- Bootstrap Core CSS -->
    <link href="include/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="include/css/style.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="include/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="include/js/bootstrap.min.js"></script>
    <script src="include/js/ajax.js"></script>
</head>

<body>

    <div id="wrapper">
        <!-- Sidebar -->
        <? include_once("temp/nav.php"); ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <header>
        	<section>
        		<? include_once("temp/header.php"); ?>
        	</section>
        </header>
        <div id="main">
        	<section>
        	<? include_once("temp/register.php"); ?>
        	</section>
        </div>
        <footer>
        	<section>
        		<? include_once("temp/footer.php"); ?>
        	</section>
        </footer>
        <!-- /#page-content-wrapper -->

    </div>
    <? Message(); ?>
    <!-- /#wrapper -->
</body>

</html>
