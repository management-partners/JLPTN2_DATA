@extends('layouts.app')
@section('title', 'Kanji Example Page')
@section('content')
<h1> Kanji Example Page </h1>

<div class="card">
    <div class="card-header"> Filter</div>
    <div class="card-body">
        <form action="{{ route("kanji-example.index") }}">
            <div class="col-sm-3 float-start">
                <select name="category" class="form-select" id="category" onChange="this.form.submit()">
                    <option value="1" {{ $searchCate == 1 ? 'selected' : '' }}>新完全マスタ</option>
                    <option value="2" {{ $searchCate == 2 ? 'selected' : '' }}>総まとめ</option>
                    <option value="3" {{ $searchCate == 3 ? 'selected' : '' }}>耳から覚える</option>
                </select>
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
                @if(!isset($searchKanji))
                    <select name="kanjiId" id="kanjiId" class="form-select select2" onChange="this.form.submit()"></select>
                @else
                    <select name="kanjiId" id="kanjiId" class="form-select select2" onChange="this.form.submit()">
                        <option value="{{ $searchKanji }}" selected="selected">{{ $searchKanjiName }}</option>
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
@if(isset($lstKanjiEx))
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Category</th>
                <th scope="col">Chapter</th>
                <th scope="col">Content</th>
                <th scope="col">On Read</th>
                <th scope="col">Kun Read</th>
                <th scope="col">Other Read</th>
                <th scope="col">Mean</th>
                <th scope="col" style="width:16%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lstKanjiEx as $lst)
                <tr>
                    <td>{{ $lst->id }}</td>
                    <td>{{ $lst->category }}</td>
                    <td>{{ $lst->chapterName }}</td>
                    <td>
                        <a href="{{ route('kanji-example.show', $lst->id) }}">
                            {{ $lst->content }}
                        </a>
                    </td>
                    <td>
                        {{ $lst->onRead }}
                    </td>
                    <td>{{ $lst->kunRead }}</td>
                    <td>{{ $lst->otherRead }}</td>
                    <td>{{ $lst->mean }}</td>
                    <td>
                        <div class="action-example">
                            <form action="{{ route('kanji-example.create') }}" method="POST">
                                <input type="hidden" name="kanjiId" value="{{ $lst->kanjiId }}">
                                @method("GET")
                                @csrf
                                <button type="submit" class="btn btn-warning"  data-bs-toggle="tooltip" data-bs-placement="top" title="View Kanji example">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>

                        </div>
                        <div class="action-edit">
                            <a href="{{ route('kanji-example.show', $lst->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Kanji example">
                                <i class="fas fa-pen-square fa-3x"></i>
                            </a>
                        </div>
                        <div class="action-delete">
                            <form action="{{ route('kanji-example.destroy', $lst->id) }}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-danger" onClick="return confirm('Do you want delete?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete kanji example">
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
                <th scope="col">Content</th>
                <th scope="col">On Read</th>
                <th scope="col">Kun Read</th>
                <th scope="col">Other Read</th>
                <th scope="col">Mean</th>
                <th scope="col" style="width:16%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lstKanji as $lst)
                <tr>
                    <td>{{ $lst->id }}</td>
                    <td>{{ $lst->category }}</td>
                    <td>{{ $lst->chapterName }}</td>
                    <td>
                        <a href="{{ route('kanji-example.show', $lst->id) }}">
                            {{ $lst->content }}
                        </a>
                    </td>
                    <td>
                        {{ $lst->onRead }}
                    </td>
                    <td>{{ $lst->kunRead }}</td>
                    <td>{{ $lst->otherRead }}</td>
                    <td>{{ $lst->mean }}</td>
                    <td>
                        <div class="action-example">
                           <form action="{{ route('kanji-example.create') }}" method="POST">
                                <input type="hidden" name="kanjiId" value="{{ $lst->kanjiId }}">
                                @method("GET")
                                @csrf
                                <button type="submit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Create Kanji example">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>

                        </div>
                        <div class="action-edit">
                            <a href="{{ route('kanji-example.show', $lst->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Kanji example">
                                <i class="fas fa-pen-square fa-3x"></i>
                            </a>
                        </div>
                        <div class="action-delete">
                            <form action="{{ route('kanji-example.destroy', $lst->id) }}" method="POST" >
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-danger"  onClick="return confirm('Do you want delete?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete kanji example">
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
$(document).ready(function(){
    $("#category").on('change', function(){
        $("#chapter").val(null).trigger("change")
        $("#kanjiId").val(null).trigger("change")
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
<script>
    $(document).ready(function() {

        $('#chapter').select2({
            placeholder: "Choose chapter...",
            minimumInputLength: 0,
            theme: "classic",
            allowClear: true,
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
                url: "{{ route("getKanjiExist") }}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        key: params.term,
                        cate: $("#category").val(),
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