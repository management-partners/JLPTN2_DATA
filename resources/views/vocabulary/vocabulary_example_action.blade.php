@extends('layouts.app')
@section('title', 'Vocabulary Example Action Page')
@section('content')
<h1> Vocabulary Example Action </h1>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
@if(isset($voca))

    <form class="action-form" action="{{ route('vocabulary-example.update', $voca->id) }}" action="POST">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label for="id" class="col-sm-2 col-form-label">ID</label>
            <div class="col-sm-10  floatLeft">
                <label for="" style="padding-right:50px;">{{ $voca->id }}</label>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-4">
                <select name="category" class="form-select" id="category">
                    <option value="1" {{ $voca->cateId == 1 ? 'selected' : '' }}>新完全マスタ</option>
                    <option value="2" {{ $voca->cateId == 2 ? 'selected' : '' }}>総まとめ</option>
                    <option value="3" {{ $voca->cateId == 3 ? 'selected' : '' }}>耳から覚える</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-6">
                <select name="chapter_name[]" id="chapter" class="form-control select2">
                    <option value="{{ $voca->chapter }}" selected="selected">{{ $voca->chapterEx }}</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">Content</label>
            <div class="col-sm-10" id="useControl">
                <input type="text" class="form-control" name="content" value="{{ $voca->content }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Read</label>
            <div class="col-sm-10" id="meanControl">
                <input type="text" class="form-control" name="onRead" value="{{ $voca->onRead }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="mean" value="{{ $voca->mean }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary col-sm-12">Edit</button>
            </div>

        </div>
    </form>
@else
    <form class="action-form" action="{{ route('vocabulary-example.store') }}" action="POST">
        @csrf
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-4">
                <select name="category" class="form-select" id="category">
                    <option value="1">新完全マスタ</option>
                    <option value="2">総まとめ</option>
                    <option value="3">耳から覚える</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-10 floatLeft">
                <div class="col-sm-2 floatLeft">
                    <input class="form-check-input" type="checkbox" value="" id="newChapter">
                    <label class="form-check-label" for="newChapter">
                        New Chapter
                    </label>
                </div>
                <div id="new" class="col-auto">
                    <div class="col-sm-2 float-start">
                        <input type="text" class="form-control" placeholder="chapter" name="chapter" style="margin-bottom:5px;">
                    </div>
                    <div class="col-sm-9 float-start" style="margin-left:5px;">
                        <input type="text" class="form-control" name="chapter_name" placeholder="Chapter Name">
                    </div>

                </div>
                <div id="old" class="col-sm-8">
                    <select name="chapter_name[]" id="chapter" class="form-control select2"></select>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Content</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="content" placeholder="Example Content" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">Read</label>
            <div class="col-sm-10" id="useControl">
                <input type="text" class="form-control" name="onRead" placeholder="Read" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="mean" placeholder="Example Mean" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary col-sm-12">Create</button>
            </div>
        </div>
    </form>
@endif

@endsection
@section('script')
<script>
    $(document).ready(function() {

        $("#newChapter").change(function() {
            var $input = $(this);
            if ($input.is(":checked")) {
                $("#new").show();
                $("#old").hide();
            } else {
                $("#new").hide()
                $("#old").show()
            }
        }).change();

    });
</script>
<script>
    $(document).ready(function() {

        $('#chapter').select2({
            placeholder: "Choose chapter...",
            minimumInputLength: 0,
            theme: "classic",
            ajax: {
                url: "{{ route("getVocabularyChapterExist") }}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        key: params.term,
                        cate: $("#category").val(),
                        type: 'public'
                    }

                    // Query parameters will be ?key=[term]&type=public
                    return query;
                },
                processResults: function(data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });
    });
</script>
@endsection