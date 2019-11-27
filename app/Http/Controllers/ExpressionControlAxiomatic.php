<?php

use App\Http\Controllers\PagesController;

class ExpressionControlAximatic{

    private $stack;
    private $string = "";
    private $addToLeftHandSideString = "";
    function __contructor(){}

    public function addToString($variable){
        $this->string = $this->string. $variable."<br>";
    }

    function evaluateNumber($num1, $op, $num2){
        $val = 0;
        if(preg_match('/[A-Za-z]/',$num1) ){
            if($op == '+') $this->addToLeftHandSideString = $this->addToLeftHandSideString."-".strval($num2);
            if($op == '-') $this->addToLeftHandSideString = $this->addToLeftHandSideString."+".strval($num2);
            if($op == '/') $this->addToLeftHandSideString = $this->addToLeftHandSideString."*".strval($num2);
            if($op == '*') $this->addToLeftHandSideString = $this->addToLeftHandSideString."/".strval($num2);
            return $num1;
        }
        if(preg_match('/[A-Za-z]/',$num2) ){
            if($op == '+') $this->addToLeftHandSideString = $this->addToLeftHandSideString."-".strval($num1);
            if($op == '-') $this->addToLeftHandSideString = $this->addToLeftHandSideString."+".strval($num1);
            if($op == '/') $this->addToLeftHandSideString = $this->addToLeftHandSideString."*".strval($num1);
            if($op == '*') $this->addToLeftHandSideString = $this->addToLeftHandSideString."/".strval($num1);
            return $num2;
        }
        
        if($op == '+') $val = $num1 + $num2;
        if($op == '-') $val = $num1 - $num2;
        if($op == '/') $val = $num1 / $num2;
        if($op == '*') $val = $num1 * $num2;
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

        $ans = $this->evaluateSigns($array);

        return $ans;

    }
    
 
    function orderValues($expression){
        //sort expression into parts by brackets
        $stringArray = str_split($expression, 1);
        $this->addToString($expression);
        $ans = $this->countBracketsToArray($stringArray, 0);

        return [$ans, $this->string];


    }

    function start1($expression){
        $ec = new ExpressionControl();
        $answer = $ec->orderValues($expression);
        return $answer;
    }

function start($expression, $condition ){
    $ec = new ExpressionControlAximatic();
    return $ec->splitBySign($expression, $condition);
}

function splitBySign($expression, $condition){
    //seperate equation by equal sign
    $split = explode("=",$expression);

    //turn into arrays
    $lefthandSide = $split[0];
    $righthandSide = str_split($split[1],1);

   

    //evaluate the right hand side
    $rightHandAnswer = $this->countBracketsToArray($righthandSide, 0);

    //replace the left hand side and hold the operator
    $split = preg_split('/[><]/', $condition);
    $leftCondition = $split[0];
    $rightCondition = $split[1];
    $operator = preg_match('/>/', $condition) ? ">" : "<";

    //equate left hand side with condition
    if($leftCondition===$lefthandSide) $lefthandSide = $rightCondition;
    else $lefthandSide = $leftCondition;

    echo $lefthandSide. " left hand side <br>";

    //add equation to left side
    $lefthandSide = $lefthandSide . $this->addToLeftHandSideString;
   
    echo $lefthandSide. " left hand side expression <br>";
    //change it to array by operators
    $lefthandSide = preg_split('/([+,\-,*,\/])/',$lefthandSide, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    echo implode($lefthandSide). "After regex <br>";

    //run it thru ExpressionControl2 to evaluate answer
    $ec = new ExpressionControl();
    $leftHandAnswer = $ec->countBracketsToArray($lefthandSide,0);

    echo $leftHandAnswer." left hand answer <br>";
    return "{$leftHandAnswer} {$operator} {$rightHandAnswer} ";

}


}



?>