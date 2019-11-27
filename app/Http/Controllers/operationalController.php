<?php

namespace App\Http\Controllers;

use ExpressionControlAximatic;
use Illuminate\Http\Request;

include("app/ExpressionControl2.php");
include("app/Http/Controllers/ExpressionControlAxiomatic.php");

class operationalController extends Controller
{
    //

    public function onFormOperational(Request $req){
        $ec = new ExpressionControl();
        $ans = $ec->start($req->input()['equ']);
        print_r($ans);
        return view("operational")->with(["expression" => $req->input()['equ'], "answer" => $ans[0], "string" => $ans[1]]);
    }

    public function onFormDenotational(Request $req){
        $ec = new ExpressionControl();
        $ans = $ec->start($req->input()['equ']);
        print_r($ans);
        return view("operational")->with(["expression" => $req->input()['equ'], "answer" => $ans[0], "string" => $ans[1]]);
    }

    public function onFormAxiomatic(Request $req){
        $ec = new ExpressionControlAximatic();
        $ans = $ec->start($req->input()['equ'], $req->input()['con']);
        print_r($ans);
        return view("axiomatic")->with(["expression" => $req->input()['equ'], "answer" => $ans, "string" => false]);
    }
}
