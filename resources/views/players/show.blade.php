<?php
$name = $player->nameFirst . ' ' . $player->nameLast;
?>

@extends('app')

@section('pageTitle')

{{$name}}

@stop

@section('pageClass') player-page @stop

@section('content')

<h3>Batting</h3>
<div class="visible-xs-block visible-sm-block">
  {!! $battingGrids['narrowGrid'] !!}
</div>
<div class="visible-md-block visible-lg-block">
  {!! $battingGrids['grid'] !!}
</div>

@if ($pitchingGrids['count'])
<h3>Pitching</h3>
<div class="visible-xs-block visible-sm-block">
  {!! $pitchingGrids['narrowGrid'] !!}
</div>
<div class="visible-md-block visible-lg-block">
  {!! $pitchingGrids['grid'] !!}
</div>
@endif

<h3>Fielding</h3>
<div class="visible-xs-block visible-sm-block">
  {!! $fieldingGrids['narrowGrid'] !!}
</div>
<div class="visible-md-block visible-lg-block">
  {!! $fieldingGrids['grid'] !!}
</div>


@stop
