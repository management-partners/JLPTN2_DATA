@extends('layouts.app')
@section('title', 'Grammar Example Page')
@section('content')
<h1> Grammar Example Action </h1>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
@if(isset($grammarEx))

    <form class="action-form" action="{{ route('grammar-example.update', $grammarEx->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-6">
                <select name="category" id="category" class="form-control">
                    <option value="1" {{ $grammarEx->cateId == 1 ? 'selected' : '' }}>新完全マスタ</option>
                    <option value="2" {{ $grammarEx->cateId == 2 ? 'selected' : '' }}>総まとめ</option>
                    <option value="3" {{ $grammarEx->cateId == 3 ? 'selected' : '' }}>耳から覚える</option>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="chapter" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-6">
                <select name="chapter" id="chapter" class="form-control select2">
                    <option value="{{ $grammarEx->chapter }}" selected="selected">{!! $chapter_name !!}</option>
                </select>
                <input type="hidden" id="chapter_name" name="chapter_name" value="{!! $chapter_name !!}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Grammar</label>
            <div class="col-sm-6">
                <select id="grammar" name="grammar" class="form-select select2">
                    <option value="{{ $grammarEx->productId }}" selected="selected">{!! $grammar_name !!}</option>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="exContent" class="col-sm-2 col-form-label">Example Content</label>
            <div class="col-sm-10" id="exContent">
                <textarea name="title" id="title" class="form-control ckeditor">{{ $grammarEx->title }}</textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">Use</label>
            <div class="col-sm-10" id="useControl">
                <textarea name="toRead" id="toRead" class="form-control ckeditor">{{ $grammarEx->toRead }}</textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="meanControl">
                <textarea name="mean" id="mean" class="form-control ckeditor">
                {{ $grammarEx->mean }}
                </textarea>
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
    <form class="action-form" action="{{ route('grammar-example.store') }}" method="POST">
        @csrf

        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-6">
                <select name="category" id="category" class="form-control">
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
                        <input type="text" class="form-control" name="chapter" placeholder="chapter" style="margin-bottom:5px;">
                    </div>
                    <div class="col-sm-9 float-start" style="margin-left:5px;">
                        <input type="text" class="form-control col-sm-10" name="chapter_name" placeholder="Chapter Name">
                    </div>

                </div>
                <div id="old" class="col-sm-8">
                    <select name="chapter" id="chapter" class="form-control select2">
                        <option value="{{ $fixChapter[0] }}" selected="selected">{{ $fixChapter[1] }}</option>
                    </select>
                    <input type="hidden" name="chapter_name" value="{{ $fixChapter[1] }}">
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Grammar</label>
            <div class="col-sm-6">
                <select id="grammar" name="grammar" class="form-select select2">
                    <option value="{{ $fixGrammar[0] }}" selected="selected">{{ $fixGrammar[1] }}</option>
                </select>
                <input type="hidden" name="grammar_name" value="{{ $fixGrammar[1] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="exContent" class="col-sm-2 col-form-label">Example Content</label>
            <div class="col-sm-10" id="exContent">
                <textarea name="title" id="title" class="form-control ckeditor"></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">Read</label>
            <div class="col-sm-10" id="useControl">
                <textarea name="toRead" id="toRead" class="form-control ckeditor"></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="meanControl">
                <textarea name="mean" id="mean" class="form-control ckeditor"></textarea>
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

@section('style')
<style rel="stylesheet">
    #useControl .ck-content {
        min-height: 100px;
    }

    #exContent .ck-content {
        min-height: 100px;
    }

    #meanControl .ck-content {
        min-height: 150px;
    }
</style>
@endsection
@section('script')
<script type="text/javascript">
    ClassicEditor
        .create(document.querySelector('#title'), {
            language: 'ja'
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.use = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
    ClassicEditor
        .create(document.querySelector('#toRead'), {
            language: 'ja'
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.use = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
    ClassicEditor
        .create(document.querySelector('#mean'), {
            language: 'ja'
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.use = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
</script>
<script>
    $(document).ready(function() {
        $('#grammar').select2({
            placeholder: "Choose grammar...",
            minimumInputLength: 0,
            theme: "classic",
            ajax: {
                url: "{{ route("getGrammar") }}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        key: params.term,
                        chapter: $("#chapter").val(),
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
            },
        });

    });
</script>
<script>
    $(document).ready(function() {

        $('#chapter').select2({
            placeholder: "Choose chapter...",
            minimumInputLength: 0,
            theme: "classic",
            ajax: {
                url: "{{ route("getChapterExist") }}",
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
        }).on("change", function(e) {
            $("#chapter_name").val(e.currentTarget.textContent)
        });
    });
</script>
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
@endsection