<?php
?>

@extends('app')

@section('pageTitle')

Franchises

@stop

@section('content')

<p>* indicates active franchise</p>

<div class="row">
  <div class="col-md-4">
    @foreach ($recordsCol1 as $record)
    <?php
    if ($record->active == 'Y') {
      $activeIndicator = ' *';
    }
    else {
      $activeIndicator = '';
    }
    ?>
    <a href="teams/franchise/{{$record->franchID}}">
      {{$record->franchName}}{{$activeIndicator}}
    </a> <br>
    @endforeach
  </div>
  <div class="col-md-4">
    @foreach ($recordsCol2 as $record)
    <?php
    if ($record->active == 'Y') {
      $activeIndicator = ' *';
    }
    else {
      $activeIndicator = '';
    }
    ?>
    <a href="teams/franchise/{{$record->franchID}}">
      {{$record->franchName}}{{$activeIndicator}}
    </a> <br>
    @endforeach
  </div>
  <div class="col-md-4">
    @foreach ($recordsCol3 as $record)
    <?php
    if ($record->active == 'Y') {
      $activeIndicator = ' *';
    }
    else {
      $activeIndicator = '';
    }
    ?>
    <a href="teams/franchise/{{$record->franchID}}">
      {{$record->franchName}}{{$activeIndicator}}
    </a> <br>
    @endforeach
  </div>
</div>

@stop
