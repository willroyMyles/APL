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
        return view("operational");
    }
    public function denotational(){
        return view("denotational");
    }
    public function axiomatic(){
        return view("axiomatic");
    }
    public function about(){
        return view("about");
    }
}
