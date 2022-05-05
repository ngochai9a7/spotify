<?php
include("includes/includedFiles.php");
?>
<div class ="entityInfo">

    <div class = "centerSections">
        <div class = "userInfo">
            <h1><?php echo $userLoggedIn->getFirstAndLastName();?></h1>
        </div>
    </div>
    <div class = "buttonItems">
    <button class= "button" onclick ="openPage('updateDetails.php')">USER DETAILS </button>
    <button class= "button" onclick ="logout()">LOG OUT</button>
    </div>

</div>
    