<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VocabularyExample;
use App\Models\Vocabulary;
use App\Http\Resources\Vocabulary\VocabularyExampleResource;
use App\Http\Resources\Vocabulary\VocabularyChapterResource;

class VocabularyExampleController extends Controller
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
        $voca = [];
        if (isset($search) && $search != 0 && isset($cate)) {
            $voca = VocabularyExample::where('cateId', $cate)->where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Vocabulary::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($search) && $search != 0) {
            $voca = VocabularyExample::where('chapter',$search)->get();
            $chapter = $search;
            $chapterName = Vocabulary::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate)) {
            $voca = VocabularyExample::where('cateId', $cate)->get();
        } else {
            $voca = VocabularyExample::where('cateId', 1)->get();
            $cate = 1;
        }
        
        return view('vocabulary.vocabulary_example', ['lstVocabularyEx'=> VocabularyExampleResource::collection($voca), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapter = VocabularyExample::groupBy('chapter')->get(['chapter', 'chapterName']);
        return view('vocabulary.vocabulary_example_action',['lstVocabulary'=> VocabularyChapterResource::collection($chapter)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vocabulary = VocabularyExample::find($id);
        return view('vocabulary.vocabulary_example_action',['voca'=> new VocabularyExampleResource($vocabulary)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
