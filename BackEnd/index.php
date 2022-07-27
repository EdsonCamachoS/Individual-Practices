<?php 
    //echo ("Hello world");
    //print ("Hello again");

    //$var1=10;
    //$var2=20;
    //$var3=30;

    //echo $var1;
    //echo $var2;
    //echo $var3;

    //echo($var1+$var2+$var3);
    //echo("La suma de ".$var1." mas "  .$var1. " es ".($var1+$var2)." <br> ".$var3);
    //$x="<h1>Este es un titulo</h1>";
    //echo $x;

    header("Content-Type: application/json; chartset-UTF-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers,Authorization, X-Requested-With");
   
    $data = array(
        "data"=>[
            array("id"=>"1", "contact"=>"Daniela","Phone"=>"4492197896", "date"=>"2022/07/08", "status"=>"Activo"),
            array("id"=>"2", "contact"=>"Emmanuel", "Phone"=>"4499725871", "date"=>"2022/08/26", "status"=>"No activo")
        ]
    );
    
    echo json_encode($data);
?>