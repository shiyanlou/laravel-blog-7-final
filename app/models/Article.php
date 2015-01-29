<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Article extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['title', 'content'];

	public function tags()
	{
		return $this->belongsToMany('Tag');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}