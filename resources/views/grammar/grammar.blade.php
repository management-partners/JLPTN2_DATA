@extends('layouts.app')
@section('title', 'Grammar Page')
@section('content')
<h1> Grammar List </h1>
<div class="create-button">
    <a href="{{ route('grammar.create') }}">
        <span class="menu-text btn btn-primary"> Create New </span>
    </a>
</div>
<div class="card">
    <div class="card-header"> Filter</div>
    <div class="card-body">
        <form action="{{ route("grammar.index") }}">
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
                <input type="hidden" name="chapter_name" id="chapter_name" value="{{ $searchChapterName }}">
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
            <th scope="col" style="width:10%;">Category</th>
            <th scope="col" style="width:10%;">Chapter</th>
            <th scope="col" style="width:10%;">Structs</th>
            <th scope="col" style="width:10%;">Use</th>
            <th scope="col">Mean</th>
            <th scope="col">Description</th>
            <th scope="col" style="width:12%;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lstGrammar as $lst)
            <tr>
                <td>{{ $lst->id }}</td>
                <td>{{ $lst->category }}</td>
                <td>{{ $lst->chapterName }}</td>
                <td>
                    <a href="{{ route('grammar.show', $lst->id) }}">
                        {!! $lst->structs !!}
                    </a>

                </td>
                <td>{!! $lst->toUse !!}</td>
                <td>{!! $lst->mean !!}</td>
                <td>{!! $lst->description !!}</td>
                <td>
                    <div class="action-example">
                        @if($lst->exampleId == 0)
                            <form action="{{ route('grammar-example.create') }}" method="GET">
                                <input type="hidden" name="id" value="{{ $lst->id }}">
                                @csrf
                                <button type="submit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Create Example">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('showEx', $lst->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="View Example">
                                    <i class="fas fa-stream"></i>
                                </button>
                            </form>
                        @endif

                    </div>
                    <div class="action-edit">
                        <a href="{{ route('grammar.edit', $lst->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="View grammar">
                            <i class="fas fa-pen-square fa-3x"></i>
                        </a>
                    </div>
                    <div class="action-delete">
                        <form action="{{ route('grammar.destroy', $lst->id) }}" method="POST">
                            @method("DELETE")
                            @csrf
                            <button class="btn btn-danger" onClick="return confirm('Do you want delete?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete grammar">
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
    $(document).ready(function() {
        $('#chapter').select2({
            placeholder: "Choose chapter...",
            minimumInputLength: 0,
            allowClear: true,
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