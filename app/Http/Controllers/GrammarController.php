<?php

namespace App\Http\Controllers;

use App\Http\Resources\Grammar\GrammarChapterResource;
use App\Http\Resources\Grammar\GrammarResource;
use App\Models\Grammar;
use App\Models\GrammarExample;
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
        $chapter = null;
        $chapterName = '';
        $grammar = [];
        if (isset($search) && $search != 0 && isset($cate)) {
            $grammar = Grammar::where('cateId', $cate)->where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Grammar::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($search) && $search != 0) {
            $grammar = Grammar::where('chapter', $search)->get();
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
        if (substr_count($request->structs, '<p>') >= 1) {
            $request->structs = preg_replace('/<\/?p><\/?p>/i', '<br/>', $request->structs);
            $request->structs = preg_replace('/<\/?p>/i', '', $request->structs);
        }
        if (substr_count($request->toUse, '<p>') >= 1) {
            $request->toUse = preg_replace('/<\/?p><\/?p>/i', '<br/>', $request->toUse);
            $request->toUse = preg_replace('/<\/?p>/i', '', $request->toUse);
        }
        if (substr_count($request->mean, '<p>') >= 1) {
            $request->mean = preg_replace('/<\/?p><\/?p>/i', '<br/>', $request->mean);
            $request->mean = preg_replace('/<\/?p>/i', '', $request->mean);
        }
        if (substr_count($request->description, '<p>') >= 1) {
            $request->description = preg_replace('/<\/?p><\/?p>/i', '<br/>', $request->description);
            $request->description = preg_replace('/<\/?p>/i', '', $request->description);
        }
        $grammar = Grammar::create(
            [
                'cateId' => $request->category,
                'chapter' => $request->chapter,
                'exampleId' => 0,
                'chapterName' => $request->op_chapter_name==null?$request->chapter_name:$request->op_chapter_name,
                'structs' => $request->structs,
                'toUse' => $request->toUse,
                'mean' => $request->mean,
                'description' => $request->description,
                'isolation' => 0,
            ]
        );
        if ($grammar) {
            \Session::flash('success', 'Grammar successfully created.');
        } else {
            \Session::flash('fail', 'Grammar unsuccessfully created.');
        }

        return redirect()->route('grammar.index');
        // return redirect()->back(); // return create page
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function showEx($id)
    {
        $lstChapter = Grammar::find($id);
        $cate = $lstChapter->cateId;
        $chapter = $lstChapter->chapter;
        $chapterName = $lstChapter->chapterName;

        return view('grammar.grammar_example', ['grammarEx' => GrammarExampleResource::collection($grammarEx), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
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
        return view('grammar.grammar_action', ['grammar' => $grammar]);
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
        $grammar = Grammar::find($id);
        if (substr_count($request->structs, '<p>') >= 1) {
            $request->structs = preg_replace('/<\/?p><\/?p>/i', '<br/>', $request->structs);
            $request->structs = preg_replace('/<\/?p>/i', '', $request->structs);
        }
        if (substr_count($request->toUse, '<p>') >= 1) {
            $request->toUse = preg_replace('/<\/?p><\/?p>/i', '<br/>', $request->toUse);
            $request->toUse = preg_replace('/<\/?p>/i', '', $request->toUse);
        }
        if (substr_count($request->mean, '<p>') >= 1) {
            $request->mean = preg_replace('/<\/?p><\/?p>/i', '<br/>', $request->mean);
            $request->mean = preg_replace('/<\/?p>/i', '', $request->mean);
        }
        if (substr_count($request->description, '<p>') >= 1) {
            $request->description = preg_replace('/<\/?p><\/?p>/i', '<br/>', $request->description);
            $request->description = preg_replace('/<\/?p>/i', '', $request->description);
        }
        $grammar = $grammar->update(
            [
                'cateId' => $request->category,
                'chapter' => $request->chapter,
                'chapterName' => $request->chapter_name,
                'structs' => $request->structs,
                'toUse' => $request->toUse,
                'mean' => $request->mean,
                'description' => $request->description,
            ]
        );

        if ($grammar) {
            \Session::flash('success', 'Grammar successfully created.');
        } else {
            \Session::flash('fail', 'Grammar unsuccessfully created.');
        }

        return redirect()->route('grammar.index');
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
        GrammarExample::where('productId', $id)->delete();
        $result = $grammar->delete();
        if ($result) {
            \Session::flash('success', 'Grammar successfully deleted.');
        } else {
            \Session::flash('fail', 'Grammar unsuccessfully deleted.');
        }

        return redirect()->route('grammar.index');
    }
}
