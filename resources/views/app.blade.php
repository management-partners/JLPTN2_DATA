@extends('layouts.app')
@section('title', 'Home Page')
@section('content')
    <div class="row">
        <div class="col-sm text-center" style="background-color: #C8FE2E; padding: 5%">
            <h3>Grammar</h3>
            <div class="col-md-4 float-start">
                <a href="{{ URL::route('grammar.index') }}">
                    <i class="fab fa-accessible-icon fa-7x"></i><br />
                    <span class="menu-text"> Grammar </span>
                </a>
            </div>
            <div class="col-md-8 float-end  text-center">
                <a href="{{ URL::route('grammar-example.index') }}">
                    <i class="fas fa-bug fa-7x"></i><br />
                    <span class="menu-text"> Grammar Example </span>
                </a>
            </div>
        </div>
        <div class="col-sm text-center" style="background-color:#00FF00; padding: 5%">
            <h3>Kanji</h3>
            <div class="col-md-4 float-start">
                <a href="{{ URL::route('kanji.index') }}">
                    <i class="fas fa-carrot fa-7x"></i><br />
                    <span class="menu-text"> Kanji </span>
                </a>
            </div>
            <div class="col-md-8 float-end">
                <a href="{{ URL::route('grammar-example.index') }}">
                    <i class="fas fa-bug fa-7x"></i><br />
                    <span class="menu-text"> Kanji Example</span>
                </a>
            </div>
        </div>
        
    </div>
    <div class="row">
        
        <div class="col-sm text-center" style="background-color: #00FF00; padding: 5%">
            <h3>Vocabulary</h3>
            <div class="col-md-4 float-start">
                <a href="{{ URL::route('vocabulary.index') }}">
                    <i class="fas fa-cannabis fa-7x"></i><br />
                    <span class="menu-text"> Vocabulary </span>
                </a>
            </div>
            <div class="col-md-8 float-end">
                <a href="{{ URL::route('vocabulary-example.index') }}">
                    <i class="fas fa-bug fa-7x"></i><br />
                    <span class="menu-text"> Vocabulary Example </span>
                </a>
            </div>
        </div>
        <div class="col-sm text-center" style="background-color: #C8FE2E; padding: 5%">
            <h3>Look And Learn</h3>
            <div class="col-md-4 float-start">
                <a href="{{ URL::route('lookandlearn.index') }}">
                    <i class="fas fa-cannabis fa-7x"></i><br />
                    <span class="menu-text"> Look And Learn </span>
                </a>
            </div>
            <div class="col-md-8 float-end">
                <a href="{{ URL::route('lookandlearn-example.index') }}">
                    <i class="fas fa-bug fa-7x"></i><br />
                    <span class="menu-text"> Look And Learn Example </span>
                </a>
            </div>
        </div>
    </div>
@endsection
