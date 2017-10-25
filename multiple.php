<?php
if(isset($_POST['submit'])){
    if(count($_FILES['upload']['name']) > 0) {
        //Loop through each file
        for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
            //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //security type check

            $allowed =  array('gif','png' ,'jpg');
            $ext = pathinfo($_FILES['upload']['name'][$i], PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed)) {
                echo 'Votre image' . ' ' . $_FILES['upload']['name'][$i] . ' ' . 'a un type non pris en compte.<br>';
            }
            else {
                //Max size check
                if ($_FILES['upload']['size'][$i] > 1052360) {

                    echo 'Votre image' . ' ' . $_FILES['upload']['name'][$i] . ' ' . 'est trop volumineuse.<br>';
                }
                else {
                    //Make sure we have a filepath
                    if ($tmpFilePath != "") {

                        //save the filename
                        $shortname = $_FILES['upload']['name'][$i];

                        //save the url and the file
                        $filePath = "/var/www/html/files/image" . uniqid() . '-' . $_FILES['upload']['name'][$i];

                        //Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $filePath)) {

                            $files[] = $shortname;
                            //insert into db
                            //use $shortname for the filename
                            //use $filePath for the relative url to the file
                            echo 'Votre image' . ' ' . $_FILES['upload']['name'][$i] . ' ' . 'a bien été uploadé.<br>';
                        }
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<form action="" enctype="multipart/form-data" method="post">

    <div>
        <label for='upload'>Add Attachments:</label>
        <input id='upload' name="upload[]" type="file" multiple="multiple" />
    </div>

    <p><input type="submit" name="submit" value="Submit"></p>

</form>


<!-- Affichage des images  -->

<?php

$dir    = '/var/www/html/files/';
$files1 = preg_grep('~\.(jpeg|jpg|png)$~', scandir($dir));

foreach($files1 as $filename) {
    $file = $filename;

    for ($i=0; $i<1; $i++) {
        $title = 'image' . uniqid() . '.' . pathinfo($file,PATHINFO_EXTENSION);
    }

    ?>

    <div class="container col-md-3">
        <div class="row">
            <div class="thumbnail">
                <?php
                echo '<a href="'.str_replace('.tb', '', $file).'">
                    <img src="'.$file.'" alt="yo" style="width:100px; height: 100px;" />
                    </a>';
                ?>
            </div>
            <div class="caption">
                <h3><?php echo $title ?></h3>
                <p align="center">
                    <?php
                    echo '<a class="btn btn-primary btn-block" href="'.str_replace('.tb', '', $file).'">Open</a>';
                    ?>
                </p>
                <p align="center">
                    <a class="btn btn-primary btn-block" href="delete.php?chemin=<?php echo $dir.$file ?>">Delete</a>
                </p>
            </div>
        </div>
    </div>

<?php } ?>





<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
