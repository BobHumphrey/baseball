<?php
$franchisesLink = action('FranchisesController@index');
$franchises = '';
switch($_SERVER['REQUEST_URI']) {
  case '/franchises':
    $galleries = 'active';
    break;
}
?>

<nav class="navbar navbar-default" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#baseball-navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://bobhumphrey.org"><img src="/images/logo-80.png"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="baseball-navbar-collapse">
      <ul class="nav navbar-nav">
        <li>
          <a href="/">
            <span class="nav-item visible-lg-inline">BASEBALL STATS</span>
          </a>
        </li>
      </ul>
      <form class="navbar-form navbar-right" action="/nav/standings" method="get">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Standings (1871-2012)" name="year">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Player Last Name" name="player">
        </div>
        <button type="submit" class="btn btn-primary">Show</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="{{$franchises}}"><a href="{{$franchisesLink}}">FRANCHISES</a></li>
      </ul>





    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
