<?php 
session_start(); //cross &#215;  o sign &#9675;&#9675;
include("game-machine.php");
$map = (array) null;
$level;
$myPos;
$win = false;
$lose =false;
$full = false;
if(isset($_REQUEST["pos"]) && isset($_SESSION['map'])){
    $req = $_REQUEST["pos"];
    $request = explode(',', $req);
    $level = $_SESSION['level'];
    $myPos = $_SESSION['myPos'];
    $map = $_SESSION['map'];
    $player= "o";
    if($player==$myPos){
        $player= "x";
    }
    $map[(int) $request[0]][(int) $request[1]] = $player;
    if(checkMap($map, $myPos)==-1){
        $win = true;
        $realMap = (array) null;
        for($i=0; $i<3; $i++){
            for($j=0; $j<3; $j++){
                if($map[$i][$j]=="o"){
                    $realMap[$i][$j] = '<span class="red">&#9675;</span>';
                }elseif($map[$i][$j]=="x"){
                    $realMap[$i][$j] = '<span class="blue">&#215;</span>';
                }else{
                    $realMap[$i][$j] = '<span></span>';
                }
            }
        }
        $realMap[3][0] = $win;
        $realMap[3][1] = $lose;
        $realMap[3][2] = $full;
        echo json_encode($realMap);
        session_destroy();
        die();
    }
    $map = do_next($map, $myPos, $level);
    if(checkMap($map, $myPos)==1){
        $lose = true;
        $realMap = (array) null;
        for($i=0; $i<3; $i++){
            for($j=0; $j<3; $j++){
                if($map[$i][$j]=="o"){
                    $realMap[$i][$j] = '<span class="red">&#9675;</span>';
                }elseif($map[$i][$j]=="x"){
                    $realMap[$i][$j] = '<span class="blue">&#215;</span>';
                }else{
                    $realMap[$i][$j] = '<span></span>';
                }
            }
        }
        $realMap[3][0] = $win;
        $realMap[3][1] = $lose;
        $realMap[3][2] = $full;
        echo json_encode($realMap);
        session_destroy();
        die();
    }
    $numFill = 0; 
    for($i = 0; $i<3 ; $i++){
        for($j = 0; $j < 3; $j++){
            if($map[$i][$j] != 'n'){
                $numFill += 1;
            }
        }
    }
    if($numFill == 9){
        $full = true;
        $realMap = (array) null;
        for($i=0; $i<3; $i++){
            for($j=0; $j<3; $j++){
                if($map[$i][$j]=="o"){
                    $realMap[$i][$j] = '<span class="red">&#9675;</span>';
                }elseif($map[$i][$j]=="x"){
                    $realMap[$i][$j] = '<span class="blue">&#215;</span>';
                }else{
                    $realMap[$i][$j] = '<span></span>';
                }
            }
        }
        $realMap[3][0] = $win;
        $realMap[3][1] = $lose;
        $realMap[3][2] = $full;
        echo json_encode($realMap);
        session_destroy();
        die();
    }
}else{
    $req = $_REQUEST['setting'];
    $request = explode(',', $req);
    $_SESSION['level'] = (int) $request[0];
    $_SESSION['myPos'] = "o";
    if($_SESSION['myPos'] == $request[1]){
        $_SESSION['myPos'] = "x";
    }
    $map = createMap();
    if($request[2]!="off"){
        $map = do_next($map, $_SESSION['myPos'], $_SESSION['level']);
    }
}
$_SESSION['map'] = $map;
$realMap = $map;
for($i=0; $i<3; $i++){
    for($j=0; $j<3; $j++){
        if($map[$i][$j]=="o"){
            $realMap[$i][$j] = '<span class="red">&#9675;</span>';
        }elseif($map[$i][$j]=="x"){
            $realMap[$i][$j] = '<span class="blue">&#215;</span>';
        }else{
            $realMap[$i][$j] = '<span></span>';
        }
    }
}
$realMap[3][0] = $win;
$realMap[3][1] = $lose;
$realMap[3][2] = $full;
echo json_encode($realMap);
?>
