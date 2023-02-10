<?php 
/*  map 3 * 3
    state o, x, and null
    who round? (o Or x)
    My game is developed with Breadth-first method
*/
session_start();
$map = (array) null;

function createMap(){
    $map = (array) null;
    $value = "n";
    for($i = 0; $i<3 ; $i++){
        $row = (array) null;
        for($j = 0; $j < 3; $j++){
            array_push($row, $value);
        }
        array_push($map, $row);
    }
    return $map;
}

function checkMap($m, $mp){
    foreach($m as $row){
        if($row[0] == 'n' || $row[1] == 'n' || $row[2] == 'n'){
            continue;
        }
        if($row[0] == $mp && $row[1] == $mp && $row[2] == $mp){
            return 1;
        }
        if($row[0] != $mp && $row[1] != $mp && $row[2] != $mp){
            return -1;  
        }
    }
    for($i =0; $i< 3; $i++){
        if($m[0][$i]== 'n'|| $m[1][$i] == 'n' || $m[2][$i] == 'n'){
            continue;
        }

        if($m[0][$i]== $mp && $m[1][$i] == $mp && $m[2][$i] == $mp){
            return 1;
        }

        if($m[0][$i]!= $mp && $m[1][$i] != $mp && $m[2][$i] != $mp ){
            return -1;
        }
    }
    if($m[0][0]=='n' || $m[1][1]== 'n' || $m[2][2] == 'n'){
        return 0;
    }
    if($m[0][0]==$mp && $m[1][1]== $mp && $m[2][2] == $mp){
        return 1;
    }
    if($m[0][0]!= $mp && $m[1][1] != $mp && $m[2][2] != $mp){
        return -1;
    }
    if($m[0][2]=='n' || $m[1][1]== 'n' || $m[2][0] == 'n'){
        return 0;
    }
    if($m[0][2]== $mp && $m[1][1] == $mp && $m[2][0] == $mp){
        return 1;
    }
    if($m[0][2]!= $mp && $m[1][1] != $mp && $m[2][0] != $mp){
        return -1;
    }
    return 0;
}
/**
 * initilizing map
 */
if(isset($_SESSION['map'])){
    $map = $_SESSION['map'];
}else{
    $_SESSION['map'] = $map = createMap();
}

class Strategy{
    private $myPos; // x or o
    private $map;
    public $strategy;
    private $turn;
    public $possible;
    function __construct($m, $mp, $t){
        $this->map = $m;
        $this->myPos = $mp;
        $this->strategy = (array) null;
        $this->turn = $t;
        $this->possible =0;
    }
    
    public function findStrategy(){
        for($i = 0; $i<3 ; $i++){
            for($j = 0; $j < 3; $j++){
                $value = $this->map[$i][$j];
                if($value == "n"){
                    $newMap = $this->map;
                    $newMap[$i][$j] = $this->turn;
                    $turn = "o";
                    if($this->turn == "o"){
                        $turn = "x";
                    }
                    $check = checkMap($newMap, $this->myPos);
                    if($check == 0){
                        $newStratey = new Strategy($newMap, $this->myPos, $turn);
                        array_push($this->strategy, $newStratey);
                        $this->possible += $newStratey->findStrategy();
                    }else{
                        $this->possible += $check;
                        //echo var_dump($newMap);
                        return $this->possible;
                    }
                    
                }
            }
        }
        //echo var_dump($this-> strategy);
    }
    
}

$myCon = new Strategy($map,"x", "o");
echo '<pre>';
$myCon->findStrategy();
foreach($myCon->strategy[0]->strategy[0]->strategy[2]->strategy as $model){
    echo 'p '.$model->possible.'<br>';
}
echo 'hello';

?>