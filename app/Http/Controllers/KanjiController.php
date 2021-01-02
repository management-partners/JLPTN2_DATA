<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanji;
use App\Http\Resources\Kanji\KanjiResource;
use App\Http\Resources\Kanji\KanjiChapterResource;

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
            $lstKanji = Kanji::where('chapter',$search)->get();
            $chapter = $search;
            $chapterName = Kanji::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate)) {
            $lstKanji = Kanji::where('cateId', $cate)->get();
        } else {
            $lstKanji = Kanji::where('cateId', 1)->get();
            $cate = 1;
        }

        return view('kanji.kanji',['lstKanji'=> KanjiResource::collection($lstKanji), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapter = Kanji::groupBy('chapter')->get(['chapter', 'chapterName']);
        return view('kanji.kanji_action',['lstChapter' => KanjiChapterResource::collection($chapter)]);
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
        $kanji = Kanji::find($id);
        $chapter = Kanji::groupBy('chapter')->get(['chapter', 'chapterName']);
        return view('kanji.kanji_action',['lstChapter' => KanjiChapterResource::collection($chapter), 'kanji' => new KanjiResource($kanji)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getKanjiChapterExist(Request $request)
    {   
        $search = $request->key;
        $cate = $request ->cate;
        $kanjiEx = [];
        if(isset($search)){
            $kanjiEx = Kanji::where('cateId',$cate)->where('chapterName','LIKE','%'.$search.'%')->groupBy('chapter')->get(['chapter', 'chapterName']);
        }else{
            $kanjiEx = Kanji::where('cateId',$cate)->groupBy('chapter')->get(['chapter', 'chapterName']);
        }
        return ['results'=> KanjiChapterResource::collection($kanjiEx)];
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
