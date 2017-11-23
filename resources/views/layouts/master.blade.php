<!DOCTYPE html>
<html lang="@yield('lang', app()->getLocale())">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
@hasSection('full-title')
  <title>@yield('full-title')</title>
@else
  <title>@hasSection('title')@yield('title') - @endif<?php ?>@yield('title-suffix', config('app.name'))</title>
@endif
@hasSection('description')
  <meta name="description" content="@yield('description')">
@endif
@hasSection('keywords')
  <meta name="keywords" content="@yield('keywords')">
@endif
  <meta name="format-detection" content="@yield('format-detection', 'telephone=no,date=no,address=no,email=no,url=no')">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="@yield('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no')">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="@yield('apple-mobile-web-app-title', config('app.name'))">
  <link rel="apple-touch-icon" href="@yield('apple-touch-icon', asset_url('assets/apple-touch-icon.png'))">
  <link rel="shortcut icon" type="image/x-icon" href="@yield('favicon', asset_url('favicon.ico'))">
@stack('css')
@stack('head')
  <!--[if lt IE 9]><script src="{{ asset_url('js/ie-html5shiv-respond.js') }}"></script><![endif]-->
</head>
@hasSection('body-class')
<body class="@yield('body-class')">
@else
<body>
@endif
@yield('body')
@include('support::partials.agent-client')
@stack('js')
@include('support::partials.alerts')
</body>
</html>
