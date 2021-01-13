@extends('layouts.app')
@section('title', 'Kanji Example Page')
@section('content')
<h1> Look And Learn Example Page </h1>
<div class="create-button">
    <a href="{{ route('lookandlearn-example.create') }}">
        <span class="menu-text btn btn-primary"> Create New </span>
    </a>
</div>
<div class="card">
    <div class="card-header"> Filter</div>
    <div class="card-body">
        <form action="{{ route("kanji-example.index") }}">
            <div class="mb-3 row float-start space-chapter">
                <label for="inputPassword" class="col-sm-4 col-form-label">Category</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control" value="4">
                    <input type="text" class="form-control-plaintext" readonly value="Look And Learn">
                </div>
            </div>
            <div class="col-sm-3 float-start space-chapter">
                @if(!isset($searchChapter))
                    <select name="chapter" id="chapter" class="form-select select2" onChange="this.form.submit()"></select>
                @else
                    <select name="chapter" id="chapter" class="form-select select2" onChange="this.form.submit()">
                        <option value="{{ $searchChapter }}" selected="selected">{{ $searchChapterName }}</option>
                    </select>
                @endif

            </div>
            <div class="col-sm-3 float-start space-chapter">
                @if(!isset($searchLook))
                    <select name="kanjiId" id="kanjiId" class="form-select select2" onChange="this.form.submit()"></select>
                @else
                    <select name="kanjiId" id="kanjiId" class="form-select select2" onChange="this.form.submit()">
                        <option value="{{ $searchLook }}" selected="selected">{{ $searchLookName }}</option>
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
@if(isset($lstLookEx))
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Category</th>
                <th scope="col">Chapter</th>
                <th scope="col">Kanji</th>
                <th scope="col">Kanji-VN</th>
                <th scope="col">On Read</th>
                <th scope="col">Kun Read</th>
                <th scope="col">Other Read</th>
                <th scope="col">Mean</th>
                <th scope="col" class="col-action">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lstLookEx as $lst)
                <tr>
                    <td>{{ $lst->id }}</td>
                    <td>{{ $lst->category }}</td>
                    <td>{{ $lst->chapterName }}</td>
                    <td>
                        <a href="{{ route('lookandlearn-example.show', $lst->id) }}">
                            {{ $lst->kanji }}
                        </a>
                    </td>
                    <td>{{ $lst->hanviet }}</td>
                    <td>{{ $lst->onRead }}</td>
                    <td>{{ $lst->kunRead }}</td>
                    <td>{{ $lst->otherRead }}</td>
                    <td>{{ $lst->mean }}</td>
                    <td>
                        <div class="action-example">
                            <form action="{{ route('lookandlearn-example.create') }}" method="POST">
                                <input type="hidden" name="kanjiId" value="{{ $lst->kanjiId }}">
                                @method("GET")
                                @csrf
                                <button type="submit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="View Look And Learn example">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>

                        </div>
                        <div class="action-edit">
                            <a href="{{ route('lookandlearn-example.show', $lst->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Look And Learn Example">
                                <i class="fas fa-pen-square fa-3x"></i>
                            </a>
                        </div>
                        <div class="action-delete">
                            <form action="{{ route('lookandlearn-example.destroy', $lst->id) }}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-danger" onClick="return confirm('Do you want delete?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Look And Learn Example">
                                    <i class="fas fa-trash-alt"></i>
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
                <th scope="col">Category</th>
                <th scope="col">Chapter</th>
                <th scope="col">Kanji</th>
                <th scope="col">Kanji-VN</th>
                <th scope="col">On Read</th>
                <th scope="col">Kun Read</th>
                <th scope="col">Other Read</th>
                <th scope="col">Mean</th>
                <th scope="col" class="col-action">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lstLookExample as $lst)
                <tr>
                    <td>{{ $lst->id }}</td>
                    <td>{{ $lst->category }}</td>
                    <td>{{ $lst->chapterName }}</td>
                    <td>
                        <a href="{{ route('lookandlearn-example.show', $lst->id) }}">
                            {{ $lst->kanji }}
                        </a>
                    </td>
                    <td>{{ $lst->hanviet }}</td>
                    <td>{{ $lst->onRead }}</td>
                    <td>{{ $lst->kunRead }}</td>
                    <td>{{ $lst->otherRead }}</td>
                    <td>{{ $lst->mean }}</td>
                    <td>
                        <div class="action-example">
                            <form action="{{ route('lookandlearn-example.create') }}" method="POST">
                                <input type="hidden" name="kanjiId" value="{{ $lst->kanjiId }}">
                                @method("GET")
                                @csrf
                                <button type="submit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Create Look And Learn Example">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>

                        </div>
                        <div class="action-edit">
                            <a href="{{ route('lookandlearn-example.show', $lst->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Look And Learn Example">
                                <i class="fas fa-pen-square fa-3x"></i>
                            </a>
                        </div>
                        <div class="action-delete">
                            <form action="{{ route('lookandlearn-example.destroy', $lst->id) }}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-danger" onClick="return confirm('Do you want delete?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Look And Learn Example">
                                    <i class="fas fa-trash-alt"></i>
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
        $("#chapter").on('change', function() {
            $("#kanjiId").val(null).trigger("change")
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#chapter').select2({
            placeholder: "Choose chapter...",
            minimumInputLength: 0,
            theme: "classic",
            allowClear: true,
            ajax: {
                url: "{{ route("getLookChapterEx") }}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        key: params.term,
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
            $("#kanjiId").val(null).trigger("change")
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#kanjiId').select2({
            placeholder: "Choose kanji...",
            minimumInputLength: 0,
            theme: "classic",
            allowClear: true,
            ajax: {
                url: "{{ route("getLookKanjiEx") }}",
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
            }
        });
    });
</script>
@endsection