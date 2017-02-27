@extends('layouts.main')

@section('title')
Slides
@endsection

@section('content')
<div class="container-fluid pagination-centered vertical-center">
    <h1>Slides</h1>
    <a class="btn btn-info" href="{{ url('/slide/create') }}">+ Create slide</a>
<hr>
    <ul class="jumbotron">
        @foreach( $slides as $slide)
        <div class="row">
            <form action="{{ URL::route('slide.destroy',$slide->id) }}" method="POST">
                <h4>
		    {{ $slide->title }}
                </h4>
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<a class="btn btn-default" href="{{ url('/slide') }}/{{ $slide->id }}/edit">Edit slide</a>
                <button class="btn btn-danger">Delete slide</button>
            </form>
        </div>
        <hr>
        @endforeach
    </ul>
</div>
@endsection
