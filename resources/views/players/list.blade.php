<?php
$countCol1 = count($recordsCol1);
?>

@extends('app')

@section('pageTitle')

Players ({{$name}})

@stop

@section('pageClass') players-page @stop

@section('content')

@if ( $countCol1 )
  <div class="row">
    <div class="col-md-4">
      @foreach ($recordsCol1 as $record)
      <a href="/players/{{$record->playerID}}">
        {{$record->nameLast}}, {{$record->nameFirst}}
      </a> <br>
      @endforeach
    </div>
    <div class="col-md-4">
      @foreach ($recordsCol2 as $record)
      <a href="/players/{{$record->playerID}}">
        {{$record->nameLast}}, {{$record->nameFirst}}
      </a> <br>
      @endforeach
    </div>
    <div class="col-md-4">
      @foreach ($recordsCol3 as $record)
      <a href="/players/{{$record->playerID}}">
        {{$record->nameLast}}, {{$record->nameFirst}}
      </a> <br>
      @endforeach
    </div>
  </div>
@else
  There are no players whose name begins with {{ $name }}.
@endif

@stop
