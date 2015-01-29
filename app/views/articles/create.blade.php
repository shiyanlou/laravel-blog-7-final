@extends('_layouts.default')

@section('main')
<div class="am-g am-g-fixed">
  <div class="am-u-sm-12">
    <h1>Publish Article</h1>
    <hr/>
  @if ($errors->has())
  <div class="am-alert am-alert-danger" data-am-alert>
    <p>{{ $errors->first() }}</p>
  </div>
  @endif
  {{ Form::open(array('url' => 'article', 'class' => 'am-form')) }}
      <div class="am-form-group">
        <label for="title">Title</label>
        <input id="title" name="title" type="text" value="{{ Input::old('title') }}"/>
      </div>
      <div class="am-form-group">
          <label for="content">Content</label>
          <textarea id="content" name="content" rows="20">{{ Input::old('content') }}</textarea>
          <p class="am-form-help">
            <button id="preview" type="button" class="am-btn am-btn-xs am-btn-primary"><span class="am-icon-eye"></span> Preview</button>
          </p>
        </div>
        <div class="am-form-group">
        <label for="tags">Tags</label>
        <input id="tags" name="tags" type="text" value="{{ Input::old('tags') }}"/>
        <p class="am-form-help">Separate multiple tags with a comma ","</p>
      </div>
      <p><button type="submit" class="am-btn am-btn-success"><span class="am-icon-send"></span> Publish</button></p>
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