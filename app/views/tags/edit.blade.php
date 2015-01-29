@extends('_layouts.default')

@section('main')
<div class="am-g am-g-fixed">
  <div class="am-u-sm-12">
  	<h1>Edit Tag</h1>
  	<hr/>
  @if (Session::has('message'))
    <div class="am-alert am-alert-{{ Session::get('message')['type'] }}" data-am-alert>
      <p>{{ Session::get('message')['content'] }}</p>
    </div>
  @endif
	@if ($errors->has())
	<div class="am-alert am-alert-danger" data-am-alert>
	  <p>{{ $errors->first() }}</p>
	</div>
	@endif
    {{ Form::model($tag, array('url' => URL::route('tag.update', $tag->id), 'method' => 'PUT', 'class' => "am-form")) }}
	    <div class="am-form-group">
        {{ Form::label('name', 'TagName') }}
        {{ Form::text('name', Input::old('name')) }}
	    </div>
	    <p><button type="submit" class="am-btn am-btn-success">
        <span class="am-icon-pencil"></span> Modify</button>
      </p>
	{{ Form::close() }}
  </div>
</div>
@stop