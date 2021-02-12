<?php

namespace App\Http\Controllers;

use App\Http\Resources\Vocabulary\VocabularyExampleResource;
use App\Http\Resources\Vocabulary\VocabularyChapterResource;
use App\Http\Resources\Vocabulary\VocabularyExitsResource;
use App\Models\Vocabulary;
use App\Models\VocabularyExample;
use Illuminate\Http\Request;

class VocabularyExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $chapter        = $request->chapter;
        $cate           = $request->category;
        $vocaparam      = $request->voca;
        $chapterName    = '';
        $voca           = [];
        if (isset($cate) && isset($chapter) &&  isset($vocaparam)) {
            $voca = VocabularyExample::where('cateId', $cate)->where('chapter', $chapter)->where('vocaId', $vocaparam)->get();
            $chapterName = Vocabulary::where('chapter', $chapter)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate) && isset($chapter) && $chapter != 0) {
            $voca = VocabularyExample::where('cateId', $cate)->where('chapter', $chapter)->get();
            $chapterName = Vocabulary::where('chapter', $chapter)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate)) {
            $voca = VocabularyExample::where('cateId', $cate)->get();
        } else {
            $chapter =1;
            $chapterName = Vocabulary::where('chapter', $chapter)->get('chapterName')->first()->chapterName;
            $voca = VocabularyExample::where('cateId', 1)->where('chapter', $chapter)->get();
            $cate = 1;
        }
        $localVocaName = '';
        if(isset($vocaparam)){
            $localVocaName = Vocabulary::find($vocaparam)->vocabulary;
        }
        
        return view('vocabulary.vocabulary_example', ['lstVocabularyEx' => VocabularyExampleResource::collection($voca), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName, 'searchVoca' => $vocaparam, 'searchVocaName' => $localVocaName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $vocaId = $request->id;
        $fixCate = [];
        $fixCate[] = $request->cateId;
        $fixCate[] = $request->cateName;
        $fixChapter = [];
        $fixChapter[] = $request->chapter;
        $fixChapter[] = $request->chapterName;

        return view('vocabulary.vocabulary_example_action', [
            'voca'=>null,
            'fixCate' => $fixCate, 
            'fixChapter' => $fixChapter,
            'fixId' => $vocaId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vocaExample = VocabularyExample::create([
            'cateId'    => $request->cateId,
            'vocaId'    => $request->vocaId,
            'chapter'   => $request->chapter,
            'content'   => $request->content,
            'onRead'    => $request->onRead,
            'mean'      => $request->mean,
        ]);
        $voca = Vocabulary::find($request->vocaId);
        if(isset($voca) && $voca->exampleId == 0){
            $voca->update(
                ['exampleId' => $request->vocaId]
            );
        }
        if ($vocaExample) {
            \Session::flash('success', 'Vocabulary example successfully created.');
        } else {
            \Session::flash('fail', 'Vocabulary example unsuccessfully created.');
        }
        $vocaEx = VocabularyExample::where('id', $vocaExample->id)->get();
        
        return view('vocabulary.vocabulary_example', ['lstVocabularyEx' => VocabularyExampleResource::collection($vocaEx), 'searchCate' => $request->cateId, 'searchChapter' => $request->chapter, 'searchChapterName' => $voca->chapterName, 'searchVoca' => $request->vocaId, 'searchVocaName' => $voca->vocabulary]);
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
        $fixChapter = [];
        $objVoca = VocabularyExample::find($id);
        $voca = Vocabulary::where('id', $objVoca->vocaId)->get()->first();
        $fixChapter[] = $voca->chapter;
        $fixChapter[] = $voca->chapterName;
        return view('vocabulary.vocabulary_example_action', [
            'voca'=>new VocabularyExampleResource($objVoca),
            'fixChapter' => $fixChapter]);
    }

    /* Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getVocabularyEx($id)
    {
        $vocabulary = VocabularyExample::where('vocaId', $id)->get();
        $lstChapter = Vocabulary::find($id);
        $cate = $lstChapter->cateId;
        $chapter = $lstChapter->chapter;
        $chapterName = $lstChapter->chapterName;

        return view('vocabulary.vocabulary_example', ['lstVocabularyEx' => VocabularyExampleResource::collection($vocabulary), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVocaExChapter(Request $request)
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
    public function getVocabularyExExist(Request $request)
    {
        $search = $request->key;
        $cate = $request->cate;
        $chapter = $request->chapter;
        $kanjiEx = [];
        if (isset($search) && isset($chapter) && $chapter !=0) {
            $kanjiEx = Vocabulary::where('cateId', $cate)->where('chapter', $chapter)->where('chapterName', 'LIKE', '%'.$search.'%')->get(['id', 'vocabulary']);
        } else {
            $kanjiEx = Vocabulary::where('cateId', $cate)->where('chapter', $chapter)->get(['id', 'vocabulary']);
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
        
        $fixChapter = [];
        $objVoca = VocabularyExample::find($id);
        $voca = Vocabulary::where('id', $objVoca->vocaId)->get()->first();
        $fixChapter[] = $voca->chapter;
        $fixChapter[] = $voca->chapterName;
        return view('vocabulary.vocabulary_example_action', [
            'voca'=>new VocabularyExampleResource($objVoca),
            'fixChapter' => $fixChapter]);
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
        $vocaExample = VocabularyExample::find($id);
        $vocaExample = $vocaExample->update([
            'cateId' => $request->category,
            'chapter' => $request->chapter,
            'content' => $request->content,
            'onRead' => $request->onRead,
            'mean' => $request->mean,
        ]);
        if ($vocaExample) {
            \Session::flash('success', 'Vocabulary example successfully updated.');
        } else {
            \Session::flash('fail', 'Vocabulary example unsuccessfully updated.');
        }

        $vocaEx = VocabularyExample::where('id', id)->get();
        $voca = Vocabulary::find($vocaExample->vocaId);

        return view('vocabulary.vocabulary_example', ['lstVocabularyEx' => VocabularyExampleResource::collection($vocaEx), 'searchCate' => $request->category, 'searchChapter' => $request->chapter, 'searchChapterName' => $voca->chapterName, 'searchVoca' => $vocaExample->vocaId, 'searchVocaName' => $vocaExample->vocabulary]);
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
        $vocaEx = VocabularyExample::find($id);
        $countEx = VocabularyExample::where('vocaId', $vocaEx->vocaId)->count();
        if($countEx == 1){
            $voca = Vocabulary::where('id', $vocaEx->vocaId);
            $voca->update([
                'exampleId' => 0,
            ]);
        }
        $result = $vocaEx->delete();
        if ($result) {
            \Session::flash('success', 'Vocabulary example successfully deleted.');

            return redirect()->route('vocabulary-example.index');
        } else {
            \Session::flash('fail', 'Vocabulary example unsuccessfully deleted.');
        }
    }
}
