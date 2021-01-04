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

    <form class="action-form" action="{{ route('vocabulary-example.update', $voca->id) }}" method="POST">
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
                <select name="chapter" id="chapter" class="form-control select2">
                    <option value="{{ $fixChapter[0] }}" selected="selected">{{ $fixChapter[1] }}</option>
                </select>
                <input type="hidden" name="chapter_name" id="chapter_name" value="{{$fixChapter[1]}}">
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
    <form class="action-form" action="{{ route('vocabulary-example.store') }}" method="POST">
        @csrf
        
        <div class="mb-3 row">
            <label for="structsControl" class="col-sm-2 col-form-label">Vocabulary ID</label>
            <div class="col-sm-10" id="vocaId">
                <input type="text" class="form-control-plaintext" name="vocaId" readonly value="{{ $fixId }}" />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
                <input type="text" class="form-control-plaintext float-start" readonly value="{{ $fixCate[0]}}" style="width:10%;" name="cateId">
                <input type="text" class="form-control-plaintext float-start" readonly value="{{ $fixCate[1] }}" style="width:80%;" name="cateName">

            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Chapter</label>
            <div class="col-sm-10">
                <input type="text" class="form-control-plaintext float-start" readonly value="{{ $fixChapter[0] }}" style="width:10%;" name="chapter">
                <input type="text" class="form-control-plaintext float-start" readonly value="{{ $fixChapter[1] }}" style="width:80%;" name="chapterName">
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

        $('#chapter').select2({
            placeholder: "Choose chapter...",
            minimumInputLength: 0,
            theme: "classic",
            ajax: {
                url: "{{ route("getVocaExChapter") }}",
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
@endsection