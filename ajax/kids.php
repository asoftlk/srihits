<?php
session_start();
if(isset($_POST['webtype'])){
    if($_POST['webtype']=='kids'){
        $_SESSION['kids']=1;
    }
    elseif($_POST['webtype']=='Exit_Kids'){
        $_SESSION['kids']=0;
    }
}

?>