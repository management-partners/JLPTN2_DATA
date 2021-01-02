<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use App\Http\Resources\Vocabulary\VocabularyResource;
use App\Http\Resources\Vocabulary\VocabularyChapterResource;

class VocabularyController extends Controller
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
        $vocabulary = [];
        if (isset($search) && $search != 0 && isset($cate)) {
            $vocabulary = Vocabulary::where('cateId', $cate)->where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Vocabulary::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($search) && $search != 0) {
            $vocabulary = Vocabulary::where('chapter',$search)->get();
            $chapter = $search;
            $chapterName = Vocabulary::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate)) {
            $vocabulary = Vocabulary::where('cateId', $cate)->get();
        } else {
            $vocabulary = Vocabulary::where('cateId', 1)->get();
            $cate = 1;
        }
        
        return view('vocabulary.vocabulary',['lstVocabulary'=> VocabularyResource::collection($vocabulary), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapter = Vocabulary::groupBy('chapter')->get(['chapter', 'chapterName']);
        return view('vocabulary.vocabulary_action',['lstVocabulary'=> VocabularyChapterResource::collection($chapter)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
         $vocabulary = Vocabulary::find($id);
        return view('vocabulary.vocabulary_action',['voca'=> new VocabularyResource($vocabulary)]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVocabularyChapterExist(Request $request)
    {
        $search = $request->key;
        $cate = $request->cate;
        $kanjiEx = [];
        if (isset($search)) {
            $kanjiEx = Vocabulary::where('cateId', $cate)->where('chapterName', 'LIKE', '%'.$search.'%')->groupBy('chapter')->get(['chapter', 'chapterName']);
        } else {
            $kanjiEx = Vocabulary::where('cateId', $cate)->groupBy('chapter')->get(['chapter', 'chapterName']);
        }

        return ['results' => VocabularyChapterResource::collection($kanjiEx)];
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
    }
}
