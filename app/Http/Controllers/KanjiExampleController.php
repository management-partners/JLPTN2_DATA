<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KanjiExample;
use App\Models\Kanji;
use App\Http\Resources\Kanji\KanjiExampleResource;
use App\Http\Resources\Kanji\KanjiChapterResource;

class KanjiExampleController extends Controller
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
        $lstKaniEx = [];
        if (isset($search) && $search != 0 && isset($cate)) {
            $lstKaniEx = KanjiExample::where('cateId', $cate)->where('chapterId', $search)->get();
            $chapter = $search;
            $chapterName = Kanji::where('chapter', $search)->get('chapterName')->first()->chapterName;
           
        } elseif (isset($search) && $search != 0) {
            $lstKaniEx = KanjiExample::where('chapterId',$search)->get();
            $chapter = $search;
            $chapterName = Kanji::where('chapter', $search)->get('chapterName')->first()->chapterName;
        } elseif (isset($cate)) {
            $lstKaniEx = KanjiExample::where('cateId', $cate)->get();
        } else {
            $lstKaniEx = KanjiExample::where('cateId', 1)->get();
            $cate = 1;
        }
        
        return view('kanji.kanji_example',['lstKanjiEx' => KanjiExampleResource::collection($lstKaniEx), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kanji.kanji_example_action');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kanjiExample = new KanjiExample();
        $kanjiExample->id           = $request->id;
        $kanjiExample->cateId       = $request->cateId;
        $kanjiExample->chapterId    = $request->chapter;
        $kanjiExample->content      = $request->content;
        $kanjiExample->onRead       = $request->onRead;
        $kanjiExample->kunRead      = $request->kunRead;
        $kanjiExample->otherRead    = $request->otherRead;
        $kanjiExample->mean         = $request->mean;
        $result = $kanjiExample -> save();
        if ($result) {
            \Session::flash('success', 'Kanji example successfully created.');
        } else {
            \Session::flash('fail', 'Kanji example unsuccessfully created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kanjiEx = KanjiExample::find($id);
        return view('kanji.kanji_example_action',['kanjiEx'=> new KanjiExampleResource($kanjiEx)]);
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getKanjiEx($id)
    {
        $kanjiEx = KanjiExample::where('kanjiId',$id)->get();
        $lstChapter = Kanji::find($id);
        $cate = $lstChapter->cateId;
        $chapter = $lstChapter->chapter;
        $chapterName = $lstChapter->chapterName;

        return view('kanji.kanji_example', ['lstKanji'=> KanjiExampleResource::collection($kanjiEx), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getKanjiExChapterExist(Request $request)
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
        $kanji = Kanji::find($id);
        return view('kanji.kanji_example_action',['edit'=> new KanjiExampleResource($kanji)]);
        
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
        $kanjiExample = KanjiExample::find($id);
        $kanjiExample->kanjiId      = $request->id;
        $kanjiExample->cateId       = $request->cateId;
        $kanjiExample->chapterId    = $request->chapter;
        $kanjiExample->content      = $request->content;
        $kanjiExample->onRead       = $request->onRead;
        $kanjiExample->kunRead      = $request->kunRead;
        $kanjiExample->otherRead    = $request->otherRead;
        $kanjiExample->mean         = $request->mean;

        $result = $kanjiExample -> update();
        if ($result) {
            \Session::flash('success', 'Kanji example successfully updated.');
        } else {
            \Session::flash('fail', 'Kanji example unsuccessfully updated.');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kanji = KanjiExample::find($id);
        $result = $kanji->delete();
        if ($result) {
            \Session::flash('success', 'Kanji example successfully deleted.');
            return redirect()->route('kanji-example.index');
        } else {
            \Session::flash('fail', 'Kanji example unsuccessfully deleted.');
        }
    }
}
