@foreach(app('api.token')->generateDataForKey(app('api.client')->defaultAppKey()) as $key => $value)
<meta name="api-{{ $key }}" content="{{ $value }}">
@endforeach
