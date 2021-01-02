@extends('layouts.app')
@section('title', 'Kanji Example Action Page')
@section('content')
<h1> Kanji Example Action </h1>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
@if(isset($kanjiEx))

    <form class="action-form" action="{{ route('kanji.update', $kanjiEx->id) }}" action="POST">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label for="id" class="col-sm-2 col-form-label">ID</label>
            <div class="col-sm-10  floatLeft">
                <label for="" style="padding-right:50px;">{{ $kanjiEx->id }}</label>
               
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-4">
                <select name="category" class="form-select" id="category">
                    <option value="1" {{ $kanjiEx->cateId == 1 ? 'selected' : '' }}>新完全マスタ</option>
                    <option value="2" {{ $kanjiEx->cateId == 2 ? 'selected' : '' }}>総まとめ</option>
                    <option value="3" {{ $kanjiEx->cateId == 3 ? 'selected' : '' }}>耳から覚える</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-6">
                <select name="chapter_name[]" id="chapter" class="form-control select2">
                    <option value="{{ $kanjiEx->chapter }}" selected="selected">{{ $kanjiEx->chapterName }}</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kani</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="kanji" value="{{ $kanjiEx->kanji }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">On Read</label>
            <div class="col-sm-10" id="useControl">
                <input type="text" class="form-control" name="onRead" value="{{ $kanjiEx->onRead }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Kun Read</label>
            <div class="col-sm-10" id="meanControl">
                <input type="text" class="form-control" name="kunRead" value="{{ $kanjiEx->kunRead }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Other Read</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="otherRead" value="{{ $kanjiEx->otherRead }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="mean" value="{{ $kanjiEx->mean }}" />
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
    <form class="action-form" action="{{ route('kanji-example.store') }}" action="POST">
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
                        <input type="text" class="form-control" name="chapter" placeholder="chapter" style="margin-bottom:5px;">
                    </div>
                    <div class="col-sm-10 float-end">
                        <input type="text" class="form-control col-sm-10" name="chapter_name" placeholder="Chapter Name">
                    </div>

                </div>
                <div id="old" class="col-sm-8">
                    <select name="chapter_name[]" id="chapter" class="form-control select2"></select>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kani</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="kanji" placeholder="Kanji word" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">On Read</label>
            <div class="col-sm-10" id="useControl">
                <input type="text" class="form-control" name="onRead" placeholder="Onyomi read" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Kun Read</label>
            <div class="col-sm-10" id="meanControl">
                <input type="text" class="form-control" name="kunRead" placeholder="Kunyomi read" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Other Read</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="otherRead" placeholder="other read" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="mean" placeholder="Kanji mean" />
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
                url: "{{ route("getKanjiExChapterExist") }}",
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