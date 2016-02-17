<?php

?>

@extends('app')

@section('pageTitle')

{{$name}}

@stop

@section('pageClass') team-franchise-page @stop

@section('content')

<div class="visible-xs-block visible-sm-block">
  {!! $narrowGrid !!}
</div>
<div class="visible-md-block visible-lg-block">
  {!! $grid !!}
</div>


@stop
