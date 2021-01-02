<?php

namespace App\Http\Controllers;

use App\Http\Resources\Grammar\GrammarChapterResource;
use App\Http\Resources\Grammar\GrammarResource;
use App\Models\Grammar;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->chapter;
        $cate = $request->category;
        $chapter = 0;
        $chapterName = '';
        $grammar = [];
        if (isset($search) && $search != 0 && isset($cate)) {
            $grammar = Grammar::where('cateId', $cate)->where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Grammar::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($search) && $search != 0) {
            $grammar = Grammar::where('chapter',$search)->get();
            $chapter = $search;
            $chapterName = Grammar::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate)) {
            $grammar = Grammar::where('cateId', $cate)->get();
        } else {
            $grammar = Grammar::where('cateId', 1)->get();
            $cate = 1;
        }
        return view('grammar.grammar', ['lstGrammar' => GrammarResource::collection($grammar), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('grammar.grammar_action');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('flash_message', 'Task successfully added!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grammar = Grammar::find($id);
        $lstChapter = Grammar::groupBy('chapter')->get(['chapter', 'chapterName']);

        return view('grammar.grammar_action', ['grammar' => $grammar, 'lstChapter' => $lstChapter]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGrammarChapterExist(Request $request)
    {
        $search = $request->key;
        $cate = $request->cate;
        $chapter = [];
        if (isset($search)) {
            $chapter = Grammar::where('cateId', $cate)->where('chapterName', 'LIKE', '%'.$search.'%')->groupBy('chapter')->get(['chapter', 'chapterName']);
        } else {
            $chapter = Grammar::where('cateId', $cate)->groupBy('chapter')->get(['chapter', 'chapterName']);
        }

        return ['results' => GrammarChapterResource::collection($chapter)];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grammar = Grammar::find($id);
        $lstChapter = Grammar::groupBy('chapter')->get(['chapter', 'chapterName']);

        return view('grammar.grammar_action', ['grammar' => $grammar, 'lstChapter' => $lstChapter]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grammar = Grammar::find($id);
        $grammar->destroy();
    }
}
