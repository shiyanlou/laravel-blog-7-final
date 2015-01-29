@extends('_layouts.default')

@section('main')
<div class="am-g am-g-fixed">
  <div class="am-u-sm-12">
  	<br/>
  	@if (Session::has('message'))
	<div class="am-alert am-alert-{{ Session::get('message')['type'] }}" data-am-alert>
	  <p>{{ Session::get('message')['content'] }}</p>
	</div>
	@endif
  	<table class="am-table am-table-hover am-table-striped ">
	  <thead>
	  <tr>
	    <th>ID</th>
	    <th>E-mail</th>
	    <th>Nickname</th>
	    <th>Management</th>
	  </tr>
	  </thead>
	  <tbody>
	  @foreach ($users as $user)
		<tr>
	  	<td>{{ $user->id }}</td>
	  	<td>{{ $user->email }}</td>
	  	<td><a href="{{ URL::to('user/' . $user->id . '/articles') }}">{{{ $user->nickname }}}</a></td>
	    <td>
		  <a href="{{ URL::to('user/'. $user->id . '/edit') }}" class="am-btn am-btn-xs am-btn-primary"><span class="am-icon-pencil"></span> Edit</a>
		  {{ Form::open(array('url' => 'user/' . $user->id . '/reset', 'method' => 'PUT', 'style' => 'display: inline;')) }}
		  	<button type="button" class="am-btn am-btn-xs am-btn-warning" id="reset{{ $user->id }}"><span class="am-icon-mail-reply"></span> Reset</button>
		  {{ Form::close() }}
		  @if ($user->block)
	      {{ Form::open(array('url' => 'user/' . $user->id . '/unblock', 'method' => 'PUT', 'style' => 'display: inline;')) }}
		  	<button type="button" class="am-btn am-btn-xs am-btn-danger" id="unblock{{ $user->id }}"><span class="am-icon-unlock"></span> Unblock</button>
		  {{ Form::close() }}
		  @else
		  {{ Form::open(array('url' => 'user/' . $user->id, 'method' => 'DELETE', 'style' => 'display: inline;')) }}
		  	<button type="button" class="am-btn am-btn-xs am-btn-danger" id="delete{{ $user->id }}"><span class="am-icon-lock"></span> Block</button>
		  {{ Form::close() }}
		  @endif
	    </td>
	  </tr>
	  @endforeach
	  </tbody>
	</table>
  </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
  <div class="am-modal-dialog">
    <div class="am-modal-bd">
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>No</span>
      <span class="am-modal-btn" data-am-modal-confirm>Yes</span>
    </div>
  </div>
</div>
<script>
  $(function() {
    $('[id^=reset]').on('click', function() {
      $('.am-modal-bd').text('Sure you want to reset the password for 123456?');
      $('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function(options) {
          $(this.relatedTarget).parent().submit();
        },
        onCancel: function() {
        }
      });
    });

    $('[id^=delete]').on('click', function() {
      $('.am-modal-bd').text('Sure you want to lock it?');
      $('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function(options) {
          $(this.relatedTarget).parent().submit();
        },
        onCancel: function() {
        }
      });
    });

    $('[id^=unblock]').on('click', function() {
      $('.am-modal-bd').text('Sure you want to unlock it?');
      $('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function(options) {
          $(this.relatedTarget).parent().submit();
        },
        onCancel: function() {
        }
      });
    });
  });
</script>
@stop