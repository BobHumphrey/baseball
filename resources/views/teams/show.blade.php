<?php
$name = $team->name;
$standingsUrl = action('TeamsController@standings', ['year' => $year]);
$franchiseUrl = action('TeamsController@franchise', ['franchise' => $team->franchID]);
$winner = '';
if ($team->WSWin == 'Y') {
  $winner = 'World Series Winner';
}
elseif ($team->LgWin == 'Y') {
  $winner = 'League Pennant Winner';
}
elseif ($team->WCWin == 'Y') {
  $winner = 'League Wild Card Winner';
}
elseif ($team->DivWin == 'Y') {
  $winner = 'Division Winner';
}
?>

@extends('app')

@section('pageTitle')

{{$year}} {{$name}}

@stop

@section('pageClass') team-page @stop

@section('content')

@if ($winner)
  <b> {{ $winner }} </b><br>
@endif

<div class="team-totals">
  <span><b>League: </b>{{$team->lgID}}</span>
  <span><b>Division: </b>{{$team->divID}}</span>
  <span><b>Rank: </b>{{$team->Rank}}</span>
  <span><b>Wins: </b>{{$team->W}}</span>
  <span><b>Losses: </b>{{$team->L}}</span>
  <span><b>Attendance: </b>{{number_format($team->attendance)}}</span>
  <span><a href="{{ $standingsUrl }}">{{ $year }} Standings</a></span>
  <span><a href="{{ $franchiseUrl }}">Franchise</a></span>
</div>
<br>

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
