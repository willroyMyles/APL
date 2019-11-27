<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //

    public function home(){
        return view("home");
    }

    public function operational(){
        return view("operational")->with(["expression" => " ", "answer" => false, "string" => false]);

    }
    public function denotational(){
        return view("denotational")->with(["expression"=> " ", "answer" => false, "string" => false]);
    }
    public function axiomatic(){
        return view("axiomatic")->with(["expression"=> "", "answer" => "", "string" => ""]);
    }
    public function about(){
        return view("about");
    }
}
