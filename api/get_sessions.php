<?php
include_once "base.php";

$movie=$Movie->find($_GET['id']);
$date=$_GET['date'];

$hr=date("G");

if($date===date("Y-m-d") && $hr>=14){
    $start=floor($hr/2)-5;
}else{
    $start=1;
}

for($i=$start;$i<=5;$i++){

    // $orders=$Order->all(['movie'=>$movie['name'],'date'=>$date,'session'=>$Movie->session[$i]]);
    // $sum=0;
    // foreach($orders as $order){
    //     $seats=unserialize($order['seats']);
    //     $num=count($seats);
    //     $sum+=$num;
    // }


    $sum=$Order->sum('qt',['movie'=>$movie['name'],'date'=>$date,'session'=>$Movie->session[$i]]);
    echo "<option value='{$Movie->session[$i]}'>";
    echo $Movie->session[$i];
    echo "剩餘座位 ".(20-$sum);
    echo "</option>";
}