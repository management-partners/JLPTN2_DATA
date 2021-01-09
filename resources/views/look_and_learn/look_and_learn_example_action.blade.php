@extends('layouts.app')
@section('title', 'Look And Learn Example Action Page')
@section('content')
<h1> Look And Learn Example Action </h1>
@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@elseif(Session::has('fail'))
    <div class="alert alert-danger">
        {{ Session::get('fail') }}
    </div>
@endif
@if(isset($lookandlearnEx))
    <form class="action-form" action="{{ route('lookandlearn-example.update', $lookandlearnEx->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label for="id" class="col-sm-2 col-form-label">Example ID</label>
            <div class="col-sm-10  floatLeft">
                <input type="text" class="form-control-plaintext float-start" readonly value="{{ $lookandlearnEx->id }}" style="width:10%;" name="id">

            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
                <input type="text" class="form-control-plaintext float-start" readonly value="4" style="width:10%;" name="cateId">
                <input type="text" class="form-control-plaintext float-start" readonly value="Look And Learn" style="width:80%;" name="cateName">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-10">
                <input type="text" class="form-control-plaintext float-start" readonly value="{{ $lookandlearnEx->chapter }}" style="width:10%;" name="chapter">
                <input type="text" class="form-control-plaintext float-start" readonly value="{{ $lookandlearnEx->chapterName }}" style="width:80%;" name="chapterName">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kani</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="kanji" value="{{ $lookandlearnEx->kanji }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kani-VN</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="kanji" value="{{ $lookandlearnEx->hanviet }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="useControl" class="col-sm-2 col-form-label">On Read</label>
            <div class="col-sm-10" id="useControl">
                <input type="text" class="form-control" name="onRead" value="{{ $lookandlearnEx->onRead }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="meanControl" class="col-sm-2 col-form-label">Kun Read</label>
            <div class="col-sm-10" id="meanControl">
                <input type="text" class="form-control" name="kunRead" value="{{ $lookandlearnEx->kunRead }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Other Read</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="otherRead" value="{{ $lookandlearnEx->otherRead }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="descriptionControl" class="col-sm-2 col-form-label">Mean</label>
            <div class="col-sm-10" id="descriptionControl">
                <input type="text" class="form-control" name="mean" value="{{ $lookandlearnEx->mean }}" />
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
    <form class="action-form" action="{{ route('lookandlearn-example.store') }}" method="POST">
        @method('POST')
        @csrf
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kanji ID</label>
            <div class="col-sm-10" id="kanji">
                @if($created)
                    <input type="text" class="form-control-plaintext" name="kanjiId" readonly value="" />
                @else
                    <input type="text" class="form-control-plaintext" name="kanjiId" readonly value="" />
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
                <input type="text" class="form-control-plaintext float-start" readonly value="" style="width:10%;" name="cateId">
                <input type="text" class="form-control-plaintext float-start" readonly value="" style="width:80%;" name="cateName">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-10">
                <input type="text" class="form-control-plaintext float-start" readonly value="" style="width:10%;" name="chapter">
                <input type="text" class="form-control-plaintext float-start" readonly value="" style="width:80%;" name="chapterName">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kanji Example</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="kanji" placeholder="Kanji word" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Kani-VN</label>
            <div class="col-sm-10" id="kanji">
                <input type="text" class="form-control" name="kanji" placeholder="Kanji VN" />
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
                url: "{{ route("getLookChapterEx") }}",
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