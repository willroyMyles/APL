<?php

session_start();

class Stack {
    protected $stack;
    protected $limit;
    public function __construct($limit = 10, $initial = array()) {
        $this->stack = $initial; // initialize the stack
        $this->limit = $limit; // stack can only contain this many items
    }
    public function push($item) {
        if (count($this->stack) < $this->limit) {
            array_unshift($this->stack, $item); // prepend item to the start of the array
        } else {
            echo "Stack is full";
        }
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

interface INode {
    public function getValue();
}

class Node implements INode {
    public $val;
    public $left = null, $right = null;

    function __construct() {
    }

    public function setValue($val){
        $this->val = $val;
    }

    public function getValue() {
        return $this->val;
    }

    public function addLeft($node){
        $this->left = $node;
    }
    public function addRight($node){
        $this->right = $node;
    }
    public function getLeft(){
        return $this->left;
    }
    public function getRight(){
        return $this->right;
    }
}




class ExpressionControl{
    public $topValue = -1;
    public $root;
    public $stack;

    function __construct() {
        $this->root = new Node();
        $this->stack = new Stack();
    }

    //check symbol
    public function value($val){
        if($val == '+' ||
        $val == '-' ||
        $val == '/' ||
        $val == '*')   return true;
     return false;
        
    }

    function inOrder($node){
        $string ='';
   
        if($node != null){
            //print t value
            // $string += strval($node->val);
            
            $this->inOrder($node->getleft());
            echo $node->val;
            $this->inOrder($node->getRight());
           

        }
        return $string;
    }

   

    function newNode($val){
        $node = new Node();
        $node->setValue($val);
        return $node;
    }

    function push($val){
        $this->stack->push($val);
        $this->topValue++;
    }

    function pop(){
        $this->topValue--;
        $this->stack->pop();
    }

    function retstring($string){

       return $stringArray = str_split($string, '/[+*\/-]/');
    }

    function makeTree($expression){
        //split string into single characters
        $stringArray = str_split($expression, 1);
        $root = new Node();
        $leaf1 = new Node();
        $leaf2 = new Node();
        
        if($stringArray)
        for($var = 0; $var < count($stringArray); $var++){
            if($this->value($stringArray[$var])){

                // $temp = new Node();
                // $temp->setValue($stringArray[$var]);

                // if()
                // $temp->addLeft($root);
                // $root = $temp;



                $root = $this->newNode($stringArray[$var]);
                $this->stack->push($root);
            }else{

                //if number






                $root = $this->newNode($stringArray[$var]);

                $leaf1 = $this->stack->top();
                $this->stack->pop();
                $leaf2 = $this->stack->top();
                $this->stack->pop();

                $root->addLeft($leaf2);
                $root->addRight($leaf1);
                $this->stack->push($root);
            }            
        }

        $root = $this->stack->top();
        $this->stack->pop();
        return $root;

    }
}

$expression = $_POST["equ"];
$ec = new ExpressionControl();
$root = $ec->makeTree($expression);
$string = $ec->inOrder($root);
echo $string;
?>