@extends('_layouts.default')

@section('main')
  <div class="am-g am-g-fixed">
    <div class="am-u-lg-6 am-u-md-8">
      <br/>
      {{ Notification::show() }}
      @if ($errors->has())
        <div class="am-alert am-alert-danger" data-am-alert>
          <p>{{ $errors->first() }}</p>
        </div>
      @endif
      {{ Form::model($user, array('url' => 'user/' . $user->id, 'method' => 'PUT', 'class' => 'am-form')) }}
        {{ Form::label('email', 'E-mail:') }}
        <input id="email" name="email" type="email" readonly="readonly" value="{{ $user->email }}"/>
        <br/>
        {{ Form::label('nickname', 'NickName:') }}
        <input id="nickname" name="nickname" type="text" value="{{{ Input::old('nickname', $user->nickname) }}}"/>
        <br/>
        {{ Form::label('old_password', 'OldPassword:') }}
        {{ Form::password('old_password') }}
        <br/>
        {{ Form::label('password', 'NewPassword:') }}
        {{ Form::password('password') }}
        <br/>
        {{ Form::label('password_confirmation', 'ConfirmPassword:') }}
        {{ Form::password('password_confirmation') }}
        <br/>
        <div class="am-cf">
          {{ Form::submit('Modify', array('class' => 'am-btn am-btn-primary am-btn-sm am-fl')) }}
        </div>
      {{ Form::close() }}
      <br/>
    </div>
  </div>
@stop