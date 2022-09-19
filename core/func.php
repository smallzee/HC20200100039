<?php 

function set_flash ($msg,$type){
    $_SESSION['flash'] = '<div class="alert alert-'.$type.' alert-dismissible" role="alert">
          '.$msg.'</div>';
}


function flash(){
    if (isset($_SESSION['flash'])) {
        echo $_SESSION['flash'];
        unset($_SESSION['flash']);
    }
}
