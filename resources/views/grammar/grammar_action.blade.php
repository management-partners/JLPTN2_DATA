@extends('layouts.app')
@section('title', 'Grammar Page')
@section('content')
<h1> Grammar Action </h1>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
@if(isset($grammar))

    <form class="action-form" action="{{ route('grammar.update', $grammar->id) }}" action="POST">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">ID</label>
            <div class="col-sm-10  floatLeft">
                <label for="" style="padding-right:50px;">{{ $grammar->id }}</label>
                <a href="{{ route('get-ex', $grammar->exampleId) }}">
                    Example
                </a>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-4">
                <select name="category" class="form-control">
                    <option value="1" {{ $grammar->cateId == 1 ? 'selected' : '' }}>新完全マスタ</option>
                    <option value="2" {{ $grammar->cateId == 2 ? 'selected' : '' }}>総まとめ</option>
                    <option value="3" {{ $grammar->cateId == 3 ? 'selected' : '' }}>耳から覚える</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-6">
                <select name="chapter" class="form-control">
                    @foreach($lstChapter as $chap)
                        <option value="{{ $chap->chapter }}" {{ $grammar->chapter == $chap->chapter ? 'selected' : '' }}>
                            {{ $chap->chapter . ' 」「 ' . $chap->chapterName }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Structs</label>
            <div class="col-sm-10" id="structsControl">
                <textarea name="structs" id="structs" class="form-control ckeditor">{{ $grammar->structs }}</textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">Use</label>
            <div class="col-sm-10" id="useControl">
                <textarea name="use" id="use" class="form-control ckeditor">{{ $grammar->toUse }}</textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="meanControl">
                <textarea name="mean" id="mean" class="form-control ckeditor">
                {{ $grammar->mean }}
                </textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10" id="descriptionControl">
                <textarea name="description" id="description" class="form-control ckeditor">
                {{ $grammar->description }}
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
    <form class="action-form" action="{{ route('grammar.create') }}" action="POST">
        @csrf
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Categoty</label>
            <div class="col-sm-4">
                <select name="category" class="form-control">
                    <option value="1">新完全マスタ</option>
                    <option value="2">総まとめ</option>
                    <option value="3">耳から覚える</option>
                </select>
            </div>
        </div>
        {{-- <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control col-sm-3" id="chapter" placeholder="Chaper number"
                        style="width:20%; margin-bottom:1%;">
                    <input type="text" class="form-control col-sm-9" id="chapter" placeholder="chapter Name">

                </div>
            </div> --}}
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
                    <select name="chapter_name[]" id="chapter" class="form-control select2"></select>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Structs</label>
            <div class="col-sm-10" id="structsControl">
                <textarea name="structs" id="structs" class="form-control ckeditor"></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">Use</label>
            <div class="col-sm-10" id="useControl">
                <textarea name="use" id="use" class="form-control ckeditor"></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="meanControl">
                <textarea name="mean" id="mean" class="form-control ckeditor"></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10" id="descriptionControl">
                <textarea name="description" id="description" class="form-control ckeditor"></textarea>
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

    #structsControl .ck-content {
        min-height: 100px;
    }

    #meanControl .ck-content {
        min-height: 150px;
    }

    #descriptionControl .ck-content {
        min-height: 150px;
    }
</style>
@endsection
@section('script')
<script type="text/javascript">
    ClassicEditor
        .create(document.querySelector('#structs'), {
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
        .create(document.querySelector('#use'), {
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
    ClassicEditor
        .create(document.querySelector('#description'), {
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
                url: "{{ route("getGrammarChapterExist") }}",
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