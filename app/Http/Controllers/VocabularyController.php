<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use App\Models\VocabularyExample;
use App\Http\Resources\Vocabulary\VocabularyResource;
use App\Http\Resources\Vocabulary\VocabularyChapterResource;
use App\Http\Resources\Vocabulary\VocabularyExitsResource;

class VocabularyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $cate           = $request->category;
        $chapter        = $request->chapter;
        $voca           = $request->voca;
        $chapterName    = '';
        $vocaName       = '';
        $vocabulary = [];
        if (isset($chapter) && $chapter != 0 && isset($cate) && isset($voca)) {
            $vocabulary     = Vocabulary::where('cateId', $cate)->where('chapter', $chapter)->where('id', $voca)->get();
            $chapterName    = $vocabulary[0]->chapterName;
            $vocaName       = $vocabulary[0]->vocabulary;
        } elseif (isset($chapter) && $chapter != 0 && isset($voca)) {
            $vocabulary     = Vocabulary::where('chapter', $chapter)->where('id', $voca)->get();
            $chapterName    = $vocabulary[0]->chapterName;
            $vocaName       = $vocabulary[0]->vocabulary;
        } elseif (isset($cate)) {
            $vocabulary = Vocabulary::where('cateId', $cate)->get();
            if( count($vocabulary) > 0){
                $chapterName    = $vocabulary[0]->chapterName;
            }
        } else {
            $chapter =1;
            $chapterName = Vocabulary::where('chapter', $chapter)->get('chapterName')->first()->chapterName;
            $vocabulary = Vocabulary::where('cateId', 1)->where('chapter', $chapter)->get();
            $cate = 1;
        }
        
       
        return view('vocabulary.vocabulary',['lstVocabulary'=> VocabularyResource::collection($vocabulary), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName, 'searchVoca' => $voca, 'searchVocaName' => $vocaName]);
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
        $chapterName = $request->op_chapter_name==null?$request->chapter_name:$request->op_chapter_name;
        $voca = Vocabulary::create([
                'cateId'        => $request->category,
                'chapter'       => $request->chapter,
                'exampleId'     => 0,
                'chapterName'   => $chapterName,
                'vocabulary'    => $request->vocabulary,
                'onRead'        => $request->onRead,
                'mean'          => $request->mean,
                'isolation'     => 0,
            ]);
        if ($voca) {
            \Session::flash('success', 'Vocabulary successfully created.');
        } else {
            \Session::flash('fail', 'Vocabulary unsuccessfully created.');
        }
        $vocabulary = Vocabulary::where('id', $voca->id)->get();

        return view('vocabulary.vocabulary',['lstVocabulary'=> VocabularyResource::collection($vocabulary), 'searchCate' => $request->category, 'searchChapter' => $request->chapter, 'searchChapterName' => $chapterName, 'searchVoca' => $voca->id, 'searchVocaName' => $request->vocabulary]);

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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVocabularyExist(Request $request)
    {
        $search = $request->key;
        $cate = $request->cate;
        $chapter = $request->chapter;
        $kanjiEx = [];
        if (isset($search) && isset($chapter) && $chapter!=0) {
            $kanjiEx = Vocabulary::where('cateId', $cate)->where('chapter', $chapter)->where('vocabulary', 'LIKE', '%'.$search.'%')->get(['id','vocabulary']);
        } else if(isset($chapter) && $chapter!=0){
            $kanjiEx = Vocabulary::where('cateId', $cate)->where('chapter', $chapter)->get(['id','vocabulary']);
        }
        else {
            $kanjiEx = Vocabulary::where('cateId', $cate)->get(['id','vocabulary']);
        }
        return ['results' => VocabularyExitsResource::collection($kanjiEx)];
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
        $vocabulary = Vocabulary::find($id);
        return view('vocabulary.vocabulary_action',['voca'=> new VocabularyResource($vocabulary)]);
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
        $voca = Vocabulary::find($id);
        $voca = $voca -> update([
                'cateId'        => $request->category,
                'chapter'       => $request->chapter,
                'chapterName'   => $request->chapter_name,
                'vocabulary'    => $request->vocabulary,
                'onRead'        => $request->onRead,
                'mean'          => $request->mean,
            ]);
        if ($voca) {
            \Session::flash('success', 'Vocabulary successfully updated.');
        } else {
            \Session::flash('fail', 'Vocabulary unsuccessfully updated.');
        }

        $vocabulary = Vocabulary::where('id', $id)->get();
        
        return view('vocabulary.vocabulary',['lstVocabulary'=> VocabularyResource::collection($vocabulary), 'searchCate' => $request->category, 'searchChapter' => $request->chapter, 'searchChapterName' => $request->chapter_name, 'searchVoca' => $id, 'searchVocaName' => $request->vocabulary]);
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
        $voca = Vocabulary::find($id);
        VocabularyExample::where('vocaId', $id)->delete();
        $result = $voca->delete();
        if ($result) {
            \Session::flash('success', 'Vocabulary successfully deleted.');
            return redirect()->route('vocabulary.index');
        } else {
            \Session::flash('fail', 'Vocabulary unsuccessfully deleted.');
        }
    }
}