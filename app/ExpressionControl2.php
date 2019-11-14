<?php 

class Stack {
    protected $stack;
    protected $limit;
    public function __construct($initial = array()) {
        $this->stack = $initial; // initialize the stack
    }
    public function push($item) {
            array_unshift($this->stack, $item); // prepend item to the start of the array
    }
    public function pop() {
        if ($this->isEmpty()) {
            echo "Stack is empty";
        } else {
            return array_shift($this->stack); // pop item from the start of the array
        }
    }
    public function top() {
        return current($this->stack);
    }
    public function isEmpty() {
        return empty($this->stack);
    }

    public function topThenPop(){
        $var = $this->top();
        $this->Pop();
        return $var;
    }
}

class ExpressionControl{

    private $stack;

    function __contructor(){

    }

    function evaluateNumber($num1, $op, $num2){
        //echo $op;
        $val = 0;
        if($op == '+') $val = $num1 + $num2;
        if($op == '-') $val = $num1 - $num2;
        if($op == '/') $val = $num1 / $num2;
        if($op == '*') $val = $num1 * $num2;
        return $val;
    }

    function removeNulls($array){
        $arr =[];
        echo implode($array)." remove null<br>";

        for($i =0 ; $i < count($array); $i++){
            if($array[$i] == null) continue;
            array_push($arr, $array[$i]);
        }
        return $arr;
    }

    function evaluateSigns($array){

        echo implode($array)." ins in the array <br>";

        //evaluate large signs first
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

    // function caluculateClosingArray($array, $offset){
    //     echo implode($array)." ins in the closing array at start <br>";

    //     $currentArray =[];
    //     //echo implode($currentArray)." ins in the current array at start <br>";

    //     $bracketCount =0;
    //     for($i = $offset; $i < count($array); $i++){
    //         echo implode($array)." ins in the closing array at loop ".$i." <br>";
    //        // echo implode($currentArray)." ins in the current array at loop ".$i." <br>";

    //         if($array[$i] == null) continue;

    //         if($array[$i] == '('){
    //             $bracketCount++;
    //             $array[$i] = null;
    //         }

    //         if($bracketCount > 1) {
    //             $array[$i]= '(';
    //             $array = $this->caluculateClosingArray($array, $i);
    //             $bracketCount--;
    //         }

    //         if($bracketCount!=0 && $array[$i] != ')' && $array[$i] != null){
               
    //             array_push($currentArray, $array[$i]);
    //             $array[$i] = null;
    //         }

    //         if( $array[$i] == ')') {
    //             $bracketCount--;
    //             $currentArray = $this->removeNulls($currentArray);
    //             $array[$i] = $this->evaluateSigns($currentArray);
    //             $currentArray = [];
    //             return $array;
    //             //evaluate inner bracket
    //         }
    //         if($bracketCount < 0) return "argument not in proper form";
    //     }
    // }

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
                echo implode($array)."is returned from closing array ........ <br>";
                //$bracketCount--;
                echo implode($array). " array value <br>";
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
        echo $ans." is the anser";
        return $ans;

    }
    
    function evaluateBrackets($array){
         
        $bracketCount = 0;
        $brackets =[];
        $this->stack = new Stack($brackets);
        for($i =0 ; $i < count($array); $i++){
            //echo implode($array)."   ";

            if($array[$i] == null) continue;

            if($array[$i] == '('){
                $bracketCount++;
                $array[$i] = null;
                continue;
            }

            if($bracketCount > 1) {
                echo implode($brackets);

                $brackets[$i] = $this->evaluateBrackets($array);
                echo implode($brackets);

            }
            
            if($bracketCount!=0 && $array[$i] != ')'){
               
                array_push($brackets, $array[$i]);
                $array[$i] = null;
            }

            if( $array[$i] == ')') {
                $bracketCount--;

                $brackets = $this->removeNulls($brackets);
                $array[$i] = $this->evaluateSigns($brackets);
                //evaluate inner bracket
                
                continue;
            }
            
            
            if($bracketCount < 0) return "argument not in proper form";
        }
        if($bracketCount != 0) return "argument not in proper form";


        $array = $this->removeNulls($array);

        $ans = $this->evaluateSigns($array);
        echo $ans." is the anser";
        return $ans;

    }

    function orderValues($expression){
        //sort expression into parts by brackets
        $stringArray = str_split($expression, 1);
        echo implode($stringArray)."  <br>  ";
        $this->countBracketsToArray($stringArray, 0);

    }
}

$expression = $_POST["equ"];
$ec = new ExpressionControl();
$ec->orderValues($expression);

?>