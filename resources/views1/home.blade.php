
@extends('default')


@section('content')
    i am the home page
    <?php $a  = Auth::user()->name ;
    echo $a ; ?>;
@stop