@extends('_layouts.default')

@section('main')
<div class="am-g am-g-fixed">
  <div class="am-u-sm-12">
  	<h1>Edit Article</h1>
  	<hr/>
	@if ($errors->has())
	<div class="am-alert am-alert-danger" data-am-alert>
	  <p>{{ $errors->first() }}</p>
	</div>
	@endif
    {{ Form::model($article, array('url' => URL::route('article.update', $article->id), 'method' => 'PUT', 'class' => "am-form")) }}
	    <div class="am-form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', Input::old('title')) }}
	    </div>
	    <div class="am-form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::textarea('content', Input::old('content'), array('rows' => '20')) }}
        <p class="am-form-help">
        	<button id="preview" type="button" class="am-btn am-btn-xs am-btn-primary"><span class="am-icon-eye"></span> Preview</button>
        </p>
      </div>
      <div class="am-form-group">
        {{ Form::label('tags', 'Tags') }}
        {{ Form::text('tags', Input::old('tags')) }}
	      <p class="am-form-help">Separate multiple tags with a comma ","</p>
	    </div>
	    <p><button type="submit" class="am-btn am-btn-success">
        <span class="am-icon-pencil"></span> Modify</button>
      </p>
	{{ Form::close() }}
  </div>
</div>

<div class="am-popup" id="preview-popup">
  <div class="am-popup-inner">
    <div class="am-popup-hd">
      <h4 class="am-popup-title"></h4>
      <span data-am-modal-close
            class="am-close">&times;</span>
    </div>
    <div class="am-popup-bd">
    </div>
  </div>
</div>
<script>
  $(function() {
  	$('#preview').on('click', function() {
  		$('.am-popup-title').text($('#title').val());
  		$.post('preview', {'content': $('#content').val()}, function(data, status) {
  		  $('.am-popup-bd').html(data);
  		});
  		$('#preview-popup').modal();
  	});
  });
</script>
@stop