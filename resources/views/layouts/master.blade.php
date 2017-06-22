<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  @isset($title)<title>{{ $title }}</title>@endisset
  @isset($description)<meta name="description" content="{{ $description }}">@endisset
  @isset($keywords)<meta name="keywords" content="{{ $keywords }}">@endisset
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  @stack('head')
  @stack('css')
  <!--[if lt IE 9]>
  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src=//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js></script>
  <![endif]-->
  @include('partials.google-analytics')
</head>
@hasSection('body-class')
<body class="@yield('body-class')">
@else
<body>
@endif
@yield('body')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@stack('js')
</body>
</html>
