@extends('layouts.app')
@section('title', 'Grammar Example Page')
@section('content')
<h1> Grammar Example List </h1>

<div class="card">
    <div class="card-header"> Filter</div>
    <div class="card-body">
        <form action="{{ route("grammar-example.index") }}">
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
                    <input type="hidden" name="chapter_name" value="{{ $searchChapterName }}">
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
@if(isset($grammarEx))
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Grammar</th>
                <th scope="col">Category</th>
                <th scope="col">Chapter</th>
                <th scope="col">Title</th>
                <th scope="col">Read</th>
                <th scope="col">Mean</th>
                <th scope="col" style="width:12%;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grammarEx as $lst)
                <tr>
                    <td>{{ $lst->id }}</td>
                    <td>{{ $lst->productId }}</td>
                    <td>{{ $lst->cate }}</td>
                    <td>{{ $lst->chapter }}</td>
                    <td>
                        <a href="{{ route('grammar-example.show', $lst->id) }}">
                            {{ $lst->title }}
                        </a>
                    </td>
                    <td>{{ $lst->toRead }}</td>
                    <td>{{ $lst->mean }}</td>
                    <td>
                        <div class="action-example">
                            <form action="{{ route('grammar-example.create') }}" method="POST">
                                <input type="hidden" name="id" value="{{ $lst->id }}">
                                @method("GET")
                                @csrf
                                <button type="submit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Create grammar example">
                                    <i class="fab fa-jira"></i>
                                </button>
                            </form>

                        </div>
                        <div class="action-edit">
                            <a href="{{ route('grammar-example.show', $lst->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit grammar example">
                                <i class="fas fa-pen-square fa-3x"></i>
                            </a>
                        </div>
                        <div class="action-delete">
                            <form action="{{ route('grammar-example.destroy', $lst->id) }}" method="POST" >
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-danger"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete grammar example" onClick="return confirm('Do you want delete?')" >
                                    <i class="fas fa-trash-alt "></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@else
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Grammar</th>
                <th scope="col">Category</th>
                <th scope="col">Chapter</th>
                <th scope="col">Title</th>
                <th scope="col">Read</th>
                <th scope="col">Mean</th>
                <th scope="col" style="width:12%;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lstGrammarEx as $lst)
                <tr>
                    <td>{{ $lst->id }}</td>
                    <td>{{ $lst->productId }}</td>
                    <td>{{ $lst->cate }}</td>
                    <td>{{ $lst->chapter }}</td>
                    <td>
                        <a href="{{ route('grammar-example.show', $lst->id) }}">
                            {{ $lst->title }}
                        </a>
                    </td>
                    <td>{{ $lst->toRead }}</td>
                    <td>{{ $lst->mean }}</td>
                    <td>
                        <div class="action-example">
                            <form action="{{ route('grammar-example.create') }}" method="POST">
                                <input type="hidden" name="id" value="{{ $lst->id }}">
                                @method("GET")
                                @csrf
                                <button type="submit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Create grammar example">
                                    <i class="fab fa-jira"></i>
                                </button>
                            </form>

                        </div>
                        <div class="action-edit">
                            <a href="{{ route('grammar-example.show', $lst->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit grammar example">
                                <i class="fas fa-pen-square fa-3x"></i>
                            </a>
                        </div>
                        <div class="action-delete">
                            <form action="{{ route('grammar-example.destroy', $lst->id) }}" method="POST" >
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-danger"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete grammar example" onClick="return confirm('Do you want delete?')" >
                                    <i class="fas fa-trash-alt "></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endif

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
                url: "{{ route("getChapterExist") }}",
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
        });
    });
</script>
@endsection