<?php

namespace App\Http\Controllers;

use App\Http\Resources\Kanji\KanjiChapterResource;
use App\Http\Resources\Kanji\KanjiResource;
use App\Models\Kanji;
use App\Models\KanjiExample;
use Illuminate\Http\Request;

class KanjiController extends Controller
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
        $lstKanji = [];
        if (isset($search) && $search != 0 && isset($cate)) {
            $lstKanji = Kanji::where('cateId', $cate)->where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Kanji::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($search) && $search != 0) {
            $lstKanji = Kanji::where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Kanji::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate)) {
            $lstKanji = Kanji::where('cateId', $cate)->get();
        } else {
            $lstKanji = Kanji::where('cateId', 1)->get();
            $cate = 1;
        }

        return view('kanji.kanji', ['lstKanji' => KanjiResource::collection($lstKanji), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $chapter = Kanji::groupBy('chapter')->get(['chapter', 'chapterName']);

        return view('kanji.kanji_action', ['lstChapter' => KanjiChapterResource::collection($chapter)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chapterN = Kanji::where('chapter', $request->chapter_name)->get('chapterName')->first();
        $tempChapterName = '';
        if(isset($chapterN)){
            $tempChapterName = $chapterN->chapterName;
        }else{
            $tempChapterName = $request->chapter_name;
        }
        $kanji = new Kanji();
        $kanji->cateId      = $request->category;
        $kanji->exampleId   = 0;
        $kanji->chapter     = $request->chapter;
        $kanji->chapterName = $tempChapterName;
        $kanji->kanji       = $request->kanji;
        $kanji->onRead      = $request->onRead;
        $kanji->kunRead     = $request->kunReadd;
        $kanji->otherRead   = $request->otherRead;
        $kanji->mean        = $request->mean;
        $kanji->isolation   = 0;
        $result = $kanji->save();
        
        if ($result) {
            \Session::flash('success', 'Kanji successfully created.');
             
        } else {
            \Session::flash('fail', 'Kanji unsuccessfully created.');
        }
        return redirect()->route('kanji.index');
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
        $kanji = Kanji::find($id);
        $chapter = Kanji::groupBy('chapter')->get(['chapter', 'chapterName']);

        return view('kanji.kanji_action', ['lstChapter' => KanjiChapterResource::collection($chapter), 'kanji' => new KanjiResource($kanji)]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKanjiChapterExist(Request $request)
    {
        $search = $request->key;
        $cate = $request->cate;
        $kanjiEx = [];
        if (isset($search)) {
            $kanjiEx = Kanji::where('cateId', $cate)->where('chapterName', 'LIKE', '%'.$search.'%')->groupBy('chapter')->get(['chapter', 'chapterName']);
        } else {
            $kanjiEx = Kanji::where('cateId', $cate)->groupBy('chapter')->get(['chapter', 'chapterName']);
        }

        return ['results' => KanjiChapterResource::collection($kanjiEx)];
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
        
        $kanji = Kanji::find($id);
        $chapterN = Kanji::where('chapter', $request->chapter_name)->get('chapterName')->first()->chapterName;
        $chapter = $request->chapter_name;
        $kanji->cateId      = $request->category;
        $kanji->chapter     = $chapter;
        $kanji->chapterName = $chapterN;
        $kanji->kanji       = $request->kanji;
        $kanji->onRead      = $request->onRead;
        $kanji->kunRead     = $request->kunReadd;
        $kanji->otherRead   = $request->otherRead;
        $kanji->mean        = $request->mean;
        $result = $kanji->update();
        if ($result) {
            \Session::flash('success', 'Kanji successfully updated.');
            return redirect()->route('kanji.index');
        } else {
            \Session::flash('fail', 'Kanji unsuccessfully updated.');
        }
        
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
        $kanji = Kanji::find($id);
        KanjiExample::where('kanjiId', $id)->delete();
        $result = $kanji->delete();
        if ($result) {
            \Session::flash('success', 'Kanji successfully deleted.');
            return redirect()->route('kanji.index');
        } else {
            \Session::flash('fail', 'Kanji unsuccessfully deleted.');
        }
    }
}
