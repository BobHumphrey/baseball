<?php
$home = env('BH_HOME');
?>

<footer>
  <div class="container">
    <div class="logo-row row">
      <a href="{{ $home }}"><img class="footer-logo" src="/images/logo-80.png"></a>
    </div>
    <div class="bh-row row">
      <a href="{{ $home }}">BOB HUMPHREY</a>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="footer-title footer-title-top">ABOUT</div>
        <a href="{{ $home }}/about.html">About</a><br>
        <br>
        <div class="footer-title footer-title-top">SKILLS</div>
        <a href="{{ $home }}/skills.html">Skills</a><br>
        <br>
        <div class="footer-title footer-title-top">WORK</div>
        <a href="{{ $home }}/work/personal.html">Personal Projects</a><br>
        <a href="{{ $home }}/work/randall.html">Randall Library Projects</a><br>
        <a href="{{ $home }}/work/roadway.html">Roadway Express Projects</a><br>
      </hr>
    </div>
    <div class="col-md-3">
      <div class="footer-title footer-title-top">PERSONAL PROJECTS</div>
      <a href="http://photography.bobhumphrey.org/">Tumblr Photos</a><br>
    </div>
    <div class="col-md-3">
      <div class="footer-title footer-title-top">RESOURCES</div>
      <a href="{{ $home }}/resources/ebooks.html">Ebooks</a><br>
      <a href="{{ $home }}/resources/laravel.html">Laravel</a><br>
      <a href="{{ $home }}/resources/miscellaneous.html">Miscellaneous</a><br>
      <a href="{{ $home }}/resources/news.html">News</a><br>
      <a href="{{ $home }}/resources/tools.html">Tools</a><br>
    </div>
    <div class="col-md-3">
      <div class="footer-title footer-title-top">REFERENCE</div>
      <a href="{{ $home }}/reference/http.html">HTTP 1.1</a><br>
      <a href="{{ $home }}/reference/object-oriented.html">Object Oriented PHP</a><br>
      <a href="{{ $home }}/reference/website-deployment.html">Website Deployment</a><br>
    </div>
  </div>
</div>
</footer>

<!--
blade - {{ $home}}
ejs - <%= home %>
-->
