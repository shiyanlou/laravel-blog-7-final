<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	$articles = Article::with('user', 'tags')->orderBy('created_at', 'desc')->paginate(Config::get('custom.page_size'));
	$tags = Tag::where('count', '>', '0')->orderBy('count', 'desc')->orderBy('updated_at', 'desc')->take(10)->get();
	return View::make('index')->with('articles', $articles)->with('tags', $tags);
});

Route::get('login', function()
{
	return View::make('login');
});

Route::post('login', array('before' => 'csrf', function()
{
	$rules = array(
		'email'       => 'required|email',
		'password'    => 'required|min:6',
		'remember_me' => 'boolean',
	);
	$validator = Validator::make(Input::all(), $rules);
	if ($validator->passes())
	{
		if (Auth::attempt(array(
			'email'    => Input::get('email'),
			'password' => Input::get('password'),
			'block'    => 0), (boolean) Input::get('remember_me')))
		{
			return Redirect::intended('home');
		} else {
			return Redirect::to('login')->withInput()->with('message', array('type' => 'danger', 'content' => 'E-mail or password error or be locked'));
		}
	} else {
		return Redirect::to('login')->withInput()->withErrors($validator);
	}
}));

Route::get('home', array('before' => 'auth', function()
{
	return View::make('home')->with('user', Auth::user())->with('articles', Article::with('tags')->where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get());
}));

Route::get('logout', array('before' => 'auth', function()
{
	Auth::logout();
	return Redirect::to('/');
}));

Route::get('register', function()
{
	return View::make('users.create');
});

Route::post('register', array('before' => 'csrf', function()
{
	$rules = array(
		'email' => 'required|email|unique:users,email',
		'nickname' => 'required|min:4|unique:users,nickname',
		'password' => 'required|min:6|confirmed',
	);
	$validator = Validator::make(Input::all(), $rules);
	if ($validator->passes())
	{
		$user = User::create(Input::only('email', 'password', 'nickname'));
		$user->password = Hash::make(Input::get('password'));
		if ($user->save())
		{
			return Redirect::to('login')->with('message', array('type' => 'success', 'content' => 'Register successfully, please login'));
		} else {
			return Redirect::to('register')->withInput()->with('message', array('type' => 'danger', 'content' => 'Register failed'));
		}
	} else {
		return Redirect::to('register')->withInput()->withErrors($validator);
	}
}));

Route::get('user/{id}/edit', array('before' => 'auth', 'as' => 'user.edit', function($id)
{
	if (Auth::user()->is_admin or Auth::id() == $id) {
		return View::make('users.edit')->with('user', User::find($id));
	} else {
		return Redirect::to('/');
	}
}));

Route::put('user/{id}', array('before' => 'auth|csrf', function($id)
{
	if (Auth::user()->is_admin or (Auth::id() == $id)) {
		$user = User::find($id);
		$rules = array(
			'password' => 'required_with:old_password|min:6|confirmed',
			'old_password' => 'min:6',
		);
		if (!(Input::get('nickname') == $user->nickname))
		{
			$rules['nickname'] = 'required|min:4||unique:users,nickname';
		}
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes())
		{
			if (!(Input::get('old_password') == '')) {
				if (!Hash::check(Input::get('old_password'), $user->password)) {
					return Redirect::route('user.edit', $id)->with('user', $user)->with('message', array('type' => 'danger', 'content' => 'Old password error'));
				} else {
					$user->password = Hash::make(Input::get('password'));
				}
			}
			$user->nickname = Input::get('nickname');
			$user->save();
			Notification::success('Modify successfully');
			return Redirect::route('user.edit', $id);
		} else {
			return Redirect::route('user.edit', $id)->withInput()->with('user', $user)->withErrors($validator);	
		}
	} else {
		return Redirect::to('/');
	}
}));

Route::group(array('prefix' => 'admin', 'before' => 'auth|isAdmin'), function()
{
	Route::get('users', function()
	{
		return View::make('admin.users.list')->with('users', User::all())->with('page', 'users');
	});

	Route::get('articles', 'AdminController@articles');

	Route::get('tags', 'AdminController@tags');
});

Route::model('user', 'User');

Route::group(array('before' => 'auth|csrf|isAdmin'), function()
{
	Route::put('user/{user}/reset', function(User $user)
	{
		$user->password = Hash::make('123456');
		$user->save();
		return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => 'Reset password successfully'));
	});

	Route::delete('user/{user}', function(User $user)
	{
		$user->block = 1;
		$user->save();
		return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => 'Lock user successfully'));
	});

	Route::put('user/{user}/unblock', function(User $user)
	{
		$user->block = 0;
		$user->save();
		return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => 'Unlock user successfully'));
	});
});

Route::post('article/preview', array('before' => 'auth', 'uses' => 'ArticleController@preview'));

Route::resource('article', 'ArticleController');

Route::get('user/{user}/articles', 'UserController@articles');

Route::post('article/{id}/preview', array('before' => 'auth', 'uses' => 'ArticleController@preview'));

Route::get('tag/{id}/articles', 'TagController@articles');

Route::resource('tag', 'TagController');