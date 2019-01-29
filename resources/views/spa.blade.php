<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ config('app.url') }}">
    <meta name="vk_app_id" content="{{ config('pinbonus.vk_app_id') }}">
    @if (isset($vkCode))
        <meta name="vk_code" content="{{ $vkCode }}">
    @endif
    <title>{{ config('app.name') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="app" style="min-height: 100vh; height:100%; display:flex; justify-content: center">
    <div class="spinner-border align-self-center" role="status" style="align-self: center">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<script type="text/javascript" src="{{ mix('js/app.js') }}" async></script>
</body>
</html>
