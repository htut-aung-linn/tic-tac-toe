<?php 
/*  map 3 * 3
    state o, x, and null
    who round? (o Or x)
    My game is developed with Depth-first method
*/
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

    if($m[0][0]==$mp && $m[1][1]== $mp && $m[2][2] == $mp && !($m[0][0]=='n' || $m[1][1]== 'n' || $m[2][2] == 'n')){
        return 1;
    }
    if($m[0][0]!= $mp && $m[1][1] != $mp && $m[2][2] != $mp  && !($m[0][0]=='n' || $m[1][1]== 'n' || $m[2][2] == 'n')){
        return -1;
    }
    
    if($m[0][2]!= $mp && $m[1][1] != $mp && $m[2][0] != $mp && !($m[0][2]=='n' || $m[1][1]== 'n' || $m[2][0] == 'n')){
        return -1;
    }
    if($m[0][2]== $mp && $m[1][1] == $mp && $m[2][0] == $mp && !($m[0][2]=='n' || $m[1][1]== 'n' || $m[2][0] == 'n')){
        return 1;
    }
    return 0;
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
        $this->findStrategy();
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
                    $newStratey = new Strategy($newMap, $this->myPos, $turn);
                    array_push($this->strategy, $newStratey);
                    if($check == 0){
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
    /**
     * finding good soltioin
     */

    public function getStrategy($level){ // {array} strategy object
        if($this->strategy != (array) null){
            $HighWinScore = -9;
            $highPos = -1;
            $pos = -1;
            for($i = 0; $i < sizeof($this->strategy); $i++){
                if(checkMap($this->strategy[$i]->map, $this->myPos)==1){
                    return $this->strategy[$i]->map;
                }
                $possible = $this->strategy[$i]->possible;
                if($possible > $HighWinScore){
                    $HighWinScore = $possible;
                    $pos = $i;
                }
                if($level>0 && !$this->defend($this->strategy[$i])){
                        $highPos = $pos;
                }
                //echo '<br>';
                //echo var_dump($this->defend($this->strategy[$i]));
                //echo var_dump($this->strategy[$i]->possible);
            }
            //echo "highpre" .$highPos;
            if($level>0 && $highPos > -1){
                //echo "high" .$highPos;
                return $this->strategy[$highPos]->map;
            }
            return $this->strategy[$pos]->map;
        }else{
            return $this->map;
        }
    }

    /**
     * defend system
     */
    public function defend($gussStrategy){
        for($i = 0; $i < sizeof($gussStrategy->strategy); $i++){
            if(checkMap($gussStrategy->strategy[$i]->map, $this->myPos) == -1){
                return true; // if you do as gussStrategy, It will lose.
            }
        }
        return false;
    }  
    
}
//fill symbol randomly 
function random_do($m, $mp){ //map, myPos(x of o)
    $posx ;
    $posy ; 
    do{
        $posx = rand(0,2);
        $posy = rand(0,2);
    }while($m[$posy][$posx] != 'n');
    $m[$posy][$posx] = $mp;
    return $m;
}

/**
 * initilizing map
 */


function do_next($map, $mp, $level){
    $newMap ;
    $numFill = 0; //number of unit that is not 'n';
    for($i = 0; $i<3 ; $i++){
        for($j = 0; $j < 3; $j++){
            if($map[$i][$j] != 'n'){
                $numFill += 1;
            }
        }
    }
    if($numFill==0 && $level>0){
        $map[1][1] = $mp;
        return $map;
    }
    elseif($map[1][1]=='n' && $numFill>0){
        $map[1][1] = $mp;
        return $map;
    }elseif($numFill>1){
        $myCon = new Strategy($map,$mp, $mp);
        $newMap = $myCon -> getStrategy($level);
        return $newMap;
    }else{
        $newMap = random_do($map, $mp);
        return $newMap;
    }
}
/*
$map = createMap();
$map[0][1] = 'x';
$map = do_next($map, 'o');
$map = do_next($map, 'x');
$map = do_next($map, 'o');
$map = do_next($map, 'x');
$map = do_next($map, 'o');
$map = do_next($map, 'x');
$map = do_next($map, 'o');
//session_destroy();
*/
 
?>