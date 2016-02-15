<?php
$name = $team->name;
?>

@extends('app')

@section('pageTitle')

{{$year}} {{$name}}

@stop

@section('content')

<h3>Batting</h3>
<div class="visible-xs-block visible-sm-block">
  {!! $battingGrids['narrowGrid'] !!}
</div>
<div class="visible-md-block visible-lg-block">
  {!! $battingGrids['grid'] !!}
</div>
<h3>Pitching</h3>
<div class="visible-xs-block visible-sm-block">
  {!! $pitchingGrids['narrowGrid'] !!}
</div>
<div class="visible-md-block visible-lg-block">
  {!! $pitchingGrids['grid'] !!}
</div>
<h3>Fielding</h3>
<div class="visible-xs-block visible-sm-block">
  {!! $fieldingGrids['narrowGrid'] !!}
</div>
<div class="visible-md-block visible-lg-block">
  {!! $fieldingGrids['grid'] !!}
</div>


@stop
