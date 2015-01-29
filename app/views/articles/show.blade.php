@extends('_layouts.default')

@section('main')
<article class="am-article">
  <div class="am-g am-g-fixed">
  	<div class="am-u-sm-12">
  	  <br/>
  	  <div class="am-article-hd">
  	    <h1 class="am-article-title">{{{ $article->title }}}</h1>
  	    <p class="am-article-meta">Author: <a href="{{ URL::to('user/' . $article->user->id . '/articles') }}" style="cursor: pointer;">{{{ $article->user->nickname }}}</a> Datetime: {{ $article->updated_at->format('Y/m/d H:i') }}</p>
  	  </div>
  	  <div class="am-article-bd">
  	  	<blockquote>
  	  	  Tags:
  	  	  @foreach ($article->tags as $tag)
  	  	  	<a href="{{ URL::to('tag/' . $tag->id . '/articles') }}" class="am-badge am-badge-success am-radius">{{ $tag->name }}</a>
  	  	  @endforeach
  	  	</blockquote>  	      
  	    </p>
  	    <p>{{ $article->resolved_content }}</p>
  	  </div>
  	  <br/>
  	</div>
  </div>
</article>
@stop