@extends('layouts.app')
@section('title', 'Vocabulary Example Page')
@section('content')
<h1> Vocabulary Example Page </h1>
<div class="card">
    <div class="card-header"> Filter</div>
    <div class="card-body">
        <form action="{{ route("vocabulary-example.index") }}">
            <div class="col-sm-3 float-start">
                <select name="category" class="form-select" id="category" onChange="this.form.submit()">
                    <option value="1" {{ $searchCate == 1 ? 'selected' : '' }}>新完全マスタ</option>
                    <option value="2" {{ $searchCate == 2 ? 'selected' : '' }}>総まとめ</option>
                    <option value="3" {{ $searchCate == 3 ? 'selected' : '' }}>耳から覚える</option>
                </select>
            </div>
            <div class="col-sm-3 float-start space-chapter">
                @if(!isset($searchChapter))
                    <select name="chapter" id="chapter" class="form-select select2" onChange="this.form.submit()">

                    </select>
                @else
                    <select name="chapter" id="chapter" class="form-select select2" onChange="this.form.submit()">
                        <option value="{{ $searchChapter }}" selected="selected">{{ $searchChapterName }}</option>
                    </select>
                @endif
            </div>
            <div class="col-sm-4 float-start space-chapter">
                @if(!isset($searchVoca))
                    <select name="voca" id="voca" class="form-select select2" onChange="this.form.submit()"></select>
                @else
                    <select name="voca" id="voca" class="form-select select2" onChange="this.form.submit()">
                        <option value="{{ $searchVoca }}" selected="selected">{{ $searchVocaName }}</option>
                    </select>
                @endif
            </div>
        </form>
    </div>
</div>
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(Session::has('fail'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ Session::get('fail') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Category</th>
            <th scope="col">Chapter</th>
            <th scope="col">Content</th>
            <th scope="col">Read</th>
            <th scope="col">Mean</th>
            <th scope="col" class="col-action">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lstVocabularyEx as $lst)
            <tr>
                <td>{{ $lst->id }}</td>
                <td>{{ $lst->category }}</td>
                <td>{{ $lst->chapterEx }}</td>
                <td>
                    <a href="{{ URL::route('vocabulary-example.show', $lst->id) }}">
                        {{ $lst->content }}
                    </a>

                </td>
                <td>{{ $lst->onRead }}</td>
                <td>{{ $lst->mean }}</td>
                <td>
                    <div class="action-example">
                        <form action="{{ route('vocabulary-example.create') }}" method="POST">
                            <input type="hidden" name="id" value="{{ $lst->id }}">
                            <input type="hidden" name="cateId" value="{{ $lst->cateId }}">
                            <input type="hidden" name="cateName" value="{{ $lst->category }}">
                            <input type="hidden" name="chapter" value="{{ $lst->chapter }}">
                            <input type="hidden" name="chapterName" value="{{ $lst->chapterEx }}">
                            @method("GET")
                            @csrf
                            <button type="submit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Create Kanji example">
                                <i class="fab fa-jira"></i>
                            </button>
                        </form>

                    </div>
                    <div class="action-edit">
                        <a href="{{ route('vocabulary-example.edit', $lst->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Vocabulary example">
                            <i class="fas fa-pen-square fa-3x"></i>
                        </a>
                    </div>
                    <div class="action-delete">
                        <form action="{{ route('vocabulary-example.destroy', $lst->id) }}" method="POST" onSubmit="Do you want delete?">
                            @method("DELETE")
                            @csrf
                            <button class="btn btn-danger" onClick="return confirm('Do you want delete?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Vocabulary example">
                                <i class="fas fa-trash-alt "></i>
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
@endsection

@section('script')
<script>
$(document).ready(function(){
    $("#category").on('change', function(){
        $("#chapter").val(null).trigger("change")
        $("#voca").val(null).trigger("change")
    });
});
</script>
<script>
    $(document).ready(function() {
        $('#chapter').select2({
            placeholder: "Choose chapter...",
            minimumInputLength: 0,
            allowClear: true,
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
            $("#voca").val(null).trigger("change")
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#voca').select2({
            placeholder: "Choose vocabulary...",
            minimumInputLength: 0,
            allowClear: true,
            theme: "classic",
            ajax: {
                url: "{{ route("getVocabularyExExist") }}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        key: params.term,
                        cate: $("#category").val(),
                        chapter: $("#chapter").val(),
                        type: 'public'
                    }
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