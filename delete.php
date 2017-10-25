<?php
if ($_GET['chemin']) {
    unlink($_GET['chemin']);
    header('location: multiple.php');
}
