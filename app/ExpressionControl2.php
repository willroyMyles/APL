<?php

use App\Http\Controllers\PagesController;

class ExpressionControl{

    private $stack;
    private $string = "";

    function __contructor(){}

    public function addToString($variable){
        $this->string = $this->string. $variable."<br>";
    }

    function evaluateNumber($num1, $op, $num2){
        $val = 0;
        if($op == '+') $val = $num1 + $num2;
        if($op == '-') $val = $num1 - $num2;
        if($op == '/') $val = $num1 / $num2;
        if($op == '*') $val = $num1 * $num2;

        echo $val. "   value returned!!! <br>";
        return $val;
    }

    function removeNulls($array){
        $arr =[];
        for($i =0 ; $i < count($array); $i++){
            if($array[$i] == null) continue;
            array_push($arr, $array[$i]);
        }
        return $arr;
    }

    function evaluateSigns($array){
        //evaluate large signs first
        $this->addToString(implode($array));
        for($i =0 ; $i < count($array); $i++){
            if($array[$i] == null) continue;
            
            if($array[$i] == '*' || $array[$i] == '/'){
                $val = $this->evaluateNumber($array[$i-1],$array[$i],$array[$i+1]);
                $array[$i]=$val;
                $array[$i-1] = null;
                $array[$i+1] = null;
            }
            $array = $this->removeNulls($array);

        }

        for($i =0 ; $i < count($array); $i++){
            if($array[$i] == null) continue;
            
            if($array[$i] == '+' || $array[$i] == '-'){
                $val = $this->evaluateNumber($array[$i-1],$array[$i],$array[$i+1]);
                $array[$i]=$val;
                $array[$i-1] = null;
                $array[$i+1] = null;
            }
            $array = $this->removeNulls($array);

        }
        if(count($array) > 1) $array = $this->evaluateSigns($array);
        if((gettype($array) == "double")==1) return $array; 
        return $array[0];
    }

   
    function countBracketsToArray($array, $offset, $return = false){
        $currentArray =[];
        $bracketCount =0;
        for($i = $offset; $i < count($array); $i++){
            if($array[$i] == null) continue;

            if($array[$i] == '('){
                $bracketCount++;
                $array[$i] = null;
            }

            if($bracketCount > 1) {
                $array[$i]= '(';
                $array= $this->countBracketsToArray($array, $i);
                $bracketCount--;

            }

            if($bracketCount!=0 && $array[$i] != ')' && $array[$i] != null){
               
                array_push($currentArray, $array[$i]);
                $array[$i] = null;
            }

            if( $array[$i] == ')') {
                $bracketCount--;
                $currentArray = $this->removeNulls($currentArray);
                $array[$i] = $this->evaluateSigns($currentArray);
                $currentArray = [];
                //evaluate inner bracket

                if($return) return $array;
            }
            if($bracketCount < 0) return "argument not in proper form";
        }
        if($bracketCount != 0) return "argument not in proper form";

        
        $array = $this->removeNulls($array);
        echo implode($array)."<br>";
        $ans = $this->evaluateSigns($array);

        echo $ans . "this may be the answer <br>";

        return $ans;

    }
    
 
    function orderValues($expression, $justAnswer = false){
        //sort expression into parts by brackets
        $stringArray = str_split($expression, 1);
        $this->addToString($expression);
        $ans = $this->countBracketsToArray($stringArray, 0);
        if($justAnswer) return $ans;
        return [$ans, $this->string];
    }

    function start($expression){
        $ec = new ExpressionControl();
        $answer = $ec->orderValues($expression);
        return $answer;
    }
}



?>