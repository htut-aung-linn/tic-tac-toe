<?php 
session_start(); //cross &#215;  o sign &#9675;&#9675;
include("game-machine.php");
$map = (array) null;
$level;
$myPos;
if(isset($_REQUEST["pos"]) && isset($_SESSION['map'])){
    $req = (int) $_REQUEST["pos"];
    $level = $_SESSION['level'];
    $myPos = $_SESSION['myPos'];
    $map = $_SESSION['map'];
    $map = do_next($map, $_SESSION['myPos'], $_SESSION['level']);
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
    $_SESSION['map'] = $map;
}
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
?>

<div id="broad">
    <div class="row">
        <div class="space top left" id="1"><button class="inside" id="btn-1"><?php echo $realMap[0][0];?></button></div>
        <div class="space top center" id="2"><button class="inside" id="btn-2"><?php echo $realMap[0][1];?></</button></div>
        <div class="space top right" id="3"><button class="inside" id="btn-3"><?php echo $realMap[0][2];?></</button></div>
    </div>
    <div class="row">
        <div class="space middle left" id="1"><button class="inside" id="btn-4"><?php echo $realMap[1][0];?></</button></div>
        <div class="space middle center" id="2"><button class="inside" id="btn-5"><?php echo $realMap[1][1];?></</button></div>
        <div class="space middle right" id="3"><button class="inside" id="btn-6"><?php echo $realMap[1][2];?></</button></div>
    </div>
    <div class="row">
        <div class="space bottom left" id="1"><button class="inside" id="btn-7"><?php echo $realMap[2][0];?></</button></div>
        <div class="space bottom center" id="2"><button class="inside" id="btn-8"><?php echo $realMap[2][1];?></</button></div>
        <div class="space bottom right" id="3"><button class="inside" id="btn-9"><?php echo $realMap[2][2];?></</button></div>
    </div>
</div>