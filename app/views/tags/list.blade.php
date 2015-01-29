@extends('_layouts.default')

@section('main')
<div class="am-g am-g-fixed">
  <div class="am-u-sm-12">
    <h1>All Tags</h1>
    <hr/>
  	@foreach ($tags as $tag)
    <a href="{{ URL::to('tag/' . $tag->id . '/articles') }}" class="am-badge am-radius {{ array('', 'am-badge-primary', 'am-badge-secondary', 'am-badge-success', 'am-badge-warning', 'am-badge-danger')[rand(0, 5)] }}">{{{ $tag->name }}} {{ $tag->count }}</a>
  	@endforeach
    <br/>
    <br/>
  </div>
</div>
@stop