@extends('layouts.app')

@section('content')
    axiomatic
    <div class="container">
        <div class="row">
            <div class="col-md-3">
               <form action="axiomatic" method="post">
            </div>
            @csrf
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="my-addon">Equation</span>
                    </div>
                    <input type="text" value={{$expression}} class="form-control" name="equ" id="equ" aria-describedby="helpId" placeholder="Enter equation">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="my-addon">condition</span>
                    </div>
                    <input type="text" class="form-control" name="con" id="con" aria-describedby="helpId" placeholder="Enter condition">
                  
                </div>
            </div>
    
        </form>
        </div>
        <div class="row">
            the answer is {{$answer}}
        </div>
        <div class="row">
            {!!$string!!}
        </div>
    </div>
@endsection