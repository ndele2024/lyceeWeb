<?php
require_once 'dialog/boutonretour.php';
$langue="F";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="dialog/images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="dialog/images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYGBUSS / login</title>
    <link href="dialog/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="./bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/styleshare.css">
    <link rel="stylesheet" href="./style/styleGestionNotes.css">
    <script language="javascript" type="text/javascript" src="dialog/js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="dialog/js/ajax.js"> </script>
    
</head>
<body>
    <div class="my-10">
        <?php echo boutonretour("index_login.php", $langue); ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm m-0">
                <div class="zoneimage w-100">
                    <img src="./ressources/maintenance1.png" alt="maintenance" class="img">
                </div>
            </div>

        </div>
    </div>

    <script src="./js/allscript.js"></script>
</body>
</html>