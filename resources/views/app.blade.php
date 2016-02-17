<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Baseball Statistics</title>
  <link rel="stylesheet" href="/css/all.css">
</head>
<body>
  @include('partials.navbar')
  <section id="content">
    <div id="page-heading">
      <h2>@yield('pageTitle')</h2>
    </div>
    <div class="container @yield('pageClass')">
      @include('partials.alerts')
      @yield('content')
    </div>
  </section>
  @include('partials.footer')
  <script src="/js/all.js"></script>
</body>
</html>
