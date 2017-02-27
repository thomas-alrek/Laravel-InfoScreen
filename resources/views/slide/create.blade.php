@extends('layouts.main')

@section('title')
Create Slide
@endsection

@section('content')
<div class="container-fluid pagination-centered vertical-center">
    <h1>Create slide</h1>
    <form action="{{ url('/slide') }}" method="post">
        {{ csrf_field() }}
        <div id="slide-container" class="jumbotron">
            <div class="form-group">
                <label for="title">Slide title</label>
                <input class="form-control" id="title" name="title" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="body">Slide content</label>
                <textarea class="form-control" id="content" name="body"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="form-control btn-default" id="save" name="save" >Save</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="{{ url('/js/image.js') }}"></script>
<script>
    $(document).ready(function(){
        tinymce.init({
            selector:'textarea',
            height : "480",
	    paste_data_images: true,
	    images_upload_handler: function (blobInfo, success, failure) {
	        success("data:" + blobInfo.blob().type + ";base64," + blobInfo.base64());
            }
        });
    });
</script>
@endsection
