<?php
include("../../config.php");
if (isset($_POST['songId'])) {
    $songId = $_POST['songId'];
    $query = mysqli_query($con, "UPDATE songs set plays = plays + 1 where id ='$songId'");
    
}


?>