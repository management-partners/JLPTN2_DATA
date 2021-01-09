@extends('layouts.app')
@section('title', 'Kanji Look And Learn Action Page')
@section('content')
<h1> Kanji Look And Learn Action </h1>
@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@elseif(Session::has('fail'))
    <div class="alert alert-danger">
        {{ Session::get('fail') }}
    </div>
@endif
@if(isset($lookandlearn))

    <form class="action-form" action="{{ route('lookandlearn.update',) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label for="id" class="col-sm-2 col-form-label">ID</label>
            <div class="col-sm-10  floatLeft">
                <label for="" style="padding-right:50px;"></label>
                @if($kanji->exampleId != 0)
                    {{-- <a href="{{ route('getKanjiEx', $kanji->id) }}">
                    Example
                    </a> --}}
                @endif

            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-4">
                <input type="text" class="form-control-plaintext" readonly value="Look And Learn">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-6">
                <select name="chapter_name" id="chapter" class="form-control select2">
                    <option value="" selected="selected"></option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kani</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="kanji" value="" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="formFile" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" id="formFile">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kani-VN</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="hanviet" value="" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10" id="descriptionControl">
                <textarea name="description" id="description" class="form-control ckeditor"></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">On Read</label>
            <div class="col-sm-10" id="useControl">
                <input type="text" class="form-control" name="onRead" value="" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Kun Read</label>
            <div class="col-sm-10" id="meanControl">
                <input type="text" class="form-control" name="kunRead" value="" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Other Read</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="otherRead" value="" />
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
    <form class="action-form" action="{{ route('lookandlearn.store') }}" method="POST">
        @method('POST')
        @csrf
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-4">
                <input type="text" class="form-control-plaintext" readonly value="Look And Learn">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-10 floatLeft">
                <div class="col-sm-8 floatLeft">
                    <input class="form-check-input" type="checkbox" value="" id="newChapter">
                    <label class="form-check-label" for="newChapter">
                        New Chapter
                    </label>
                </div>
                <div id="new" class="col-auto">
                    <div class="col-sm-2 float-start">
                        <input type="text" class="form-control" name="chapter" placeholder="chapter" style="margin-bottom:5px;">
                    </div>
                    <div class="col-sm-9 float-start" style="margin-left: 5px;">
                        <input type="text" class="form-control col-sm-10" name="chapter_name" placeholder="Chapter Name">
                    </div>

                </div>
                <div id="old" class="col-sm-8">
                    <select name="chapter" id="chapter" class="form-control select2"></select>
                    <input type="hidden" name="op_chapter_name" id="op_chapter_name">
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
            <label for="formFile" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" id="formFile">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kani-VN</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="hanviet" value="" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10" id="descriptionControl">
                <textarea name="description" id="description" class="form-control ckeditor"></textarea>
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
    #descriptionControl .ck-content {
        min-height: 100px;
    }
</style>
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

<script type="text/javascript">
    ClassicEditor
        .create(document.querySelector('#description'), {
            language: 'ja'

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

        $('#chapter').select2({
            placeholder: "Choose chapter...",
            minimumInputLength: 0,
            theme: "classic",
            ajax: {
                url: "{{ route("getKanjiChapterExist") }}",
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
            $("#op_chapter_name").val(e.currentTarget.textContent)
        });
    });
</script>
@endsection