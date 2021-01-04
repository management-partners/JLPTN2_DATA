<?php

namespace App\Http\Controllers;

use App\Http\Resources\Vocabulary\VocabularyExampleResource;
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
        $search = $request->chapter;
        $cate = $request->category;
        $chapter = null;
        $chapterName = '';
        $voca = [];
        if (isset($search) && $search != 0 && isset($cate)) {
            $voca = VocabularyExample::where('cateId', $cate)->where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Vocabulary::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($search) && $search != 0) {
            $voca = VocabularyExample::where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Vocabulary::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate)) {
            $voca = VocabularyExample::where('cateId', $cate)->get();
        } else {
            $voca = VocabularyExample::where('cateId', 1)->get();
            $cate = 1;
        }

        return view('vocabulary.vocabulary_example', ['lstVocabularyEx' => VocabularyExampleResource::collection($voca), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
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
            'cateId' => $request->cateId,
            'chapter' => $request->chapter,
            'content' => $request->content,
            'onRead' => $request->onRead,
            'mean' => $request->mean,
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

        return redirect()->route('vocabulary-example.index');
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
        $vocabulary = VocabularyExample::find($id);

        return view('vocabulary.vocabulary_example_action', ['voca' => new VocabularyExampleResource($vocabulary)]);
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
        $vocaExample = VocabularyExample::find($id);
        $vocaExample = $vocaExample->update([
            'cateId' => $request->cateId,
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

        return redirect()->route('vocabulary-example.index');
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
        $voca = VocabularyExample::find($id);
        $result = $voca->delete();
        if ($result) {
            \Session::flash('success', 'Vocabulary example successfully deleted.');

            return redirect()->route('vocabulary-example.index');
        } else {
            \Session::flash('fail', 'Vocabulary example unsuccessfully deleted.');
        }
    }
}
