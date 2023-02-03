<?php
include_once "base.php";

$movie=$Movie->find($_POST['id']);

if($movie['sh']==1){
    $movie['sh']=0;
}else{
    $movie['sh']=1;
}
//可用三元運算式寫
//$movie['sh']=($movie['sh']==1)?0:1;
$Movie->save($movie);