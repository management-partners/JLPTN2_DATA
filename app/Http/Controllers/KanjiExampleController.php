<?php

namespace App\Http\Controllers;

use App\Http\Resources\Kanji\KanjiChapterResource;
use App\Http\Resources\Kanji\KanjiExampleResource;
use App\Http\Resources\Kanji\KanjiNameResource;
use App\Models\Kanji;
use App\Models\KanjiExample;
use Illuminate\Http\Request;

class KanjiExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $chapter = $request->chapter;
        $cate = $request->category;
        $chapterName = '';
        
        $lstKaniEx = [];
        if (isset($cate)) {
            if ($chapter != 0 && $cate != 0) {
                $lstKaniEx = KanjiExample::where('cateId', $cate)->where('chapter', $chapter)->get();
                // $chapterName = Kanji::where('chapter', $chapter)->get('chapterName')->first()->chapterName;
                $chapterName = $lstKaniEx[0]->chapterName;

            } elseif ($chapter != 0) {
                $lstKaniEx = KanjiExample::where('chapter', $chapter)->get();
                // $chapterName = Kanji::where('chapter', $chapter)->get('chapterName')->first()->chapterName;
                $chapterName = $lstKaniEx[0]->chapterName;

            } elseif ($cate != 0 ) {
                $lstKaniEx = KanjiExample::where('cateId', $cate)->get();
            } elseif ($cate != 0) {
                $lstKaniEx = KanjiExample::where('cateId', $cate)->get();
            }else {
                $lstKaniEx = KanjiExample::where('cateId', 1)->get();
                $cate = 1;
            }
        } else {
            $chapter = 1;
            $chapterName = Kanji::where('chapter', $chapter)->get('chapterName')->first()->chapterName;
            $lstKaniEx = KanjiExample::where('cateId', 1)->where('chapter', $chapter)->get();
            $cate = 1;
        }
        
        
        return view('kanji.kanji_example', ['lstKanjiEx' => KanjiExampleResource::collection($lstKaniEx), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $kanji = KanjiExample::where('id', $request->kanjiId)->get();
        
        return view('kanji.kanji_example_action', ['edit' => new KanjiExampleResource($kanji[0]),'created'=>true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kanjiExample = KanjiExample::create([
                'id'       => $request->kanjiId,
                'cateId'   => $request->cateId,
                'chapter'  => $request->chapter,
                'content'  => $request->kanji,
                'hanviet'  => $request->hanviet,
                'onRead'   => $request->onRead,
                'kunRead'  => $request->kunRead,
                'otherRead' => $request->otherRead,
                'mean'      => $request->mean,
                'isolation' => 0
            ]);
            
        $kanji = Kanji::find($request->kanjiId);
        

        if ($kanji->exampleId == 0) {
            $kanji->exampleId = $kanjiExample->autoId;
            $kanji->update();
        }
        if ($kanjiExample) {
            \Session::flash('success', 'Kanji example successfully created.');
        } else {
            \Session::flash('fail', 'Kanji example unsuccessfully created.');
        }
        $kanjiEx = KanjiExample::where('id', $request->kanjiId)->get()[0];
        
        return view('kanji.kanji_example', ['lstKanjiEx' => KanjiExampleResource::collection($kanjiEx), 'searchCate' => $chapter->cateId, 'searchChapter' => $chapter->chapter, 'searchChapterName' => $chapter->chapterName]);
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
        $autoId = $id;
        $kanjiEx = KanjiExample::where('autoId',$id)->get();

        

        return view('kanji.kanji_example_action', ['kanjiEx' => new KanjiExampleResource($kanjiEx[0])]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getKanjiEx($id)
    {
        $kanjiEx = KanjiExample::where('id',$id)->get();
        $lstChapter = Kanji::find($id);
        $cate = $lstChapter->cateId;
        $chapter = $lstChapter->chapter;
        $chapterName = $lstChapter->chapterName;


        return view('kanji.kanji_example', ['lstKanji' => KanjiExampleResource::collection($kanjiEx), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKanjiExChapterExist(Request $request)
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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKanjiExExist(Request $request)
    {
        $search = $request->key;
        $cate = $request->cate;
        $chapter = $request->chapter;
        $kanji = [];
        if (isset($search)) {
            $kanji = Kanji::where('cateId', $cate)->where('chapter', $chapter)->where('kanji', 'LIKE', '%'.$search.'%')->get(['id', 'kanji']);
        } elseif (isset($chapter)) {
            $kanji = Kanji::where('cateId', $cate)->where('chapter', $chapter)->get(['id', 'kanji']);
        }

        return ['results' => KanjiNameResource::collection($kanji)];
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
        
        $kanjiEx = KanjiExample::where('autoId',$id)->get();
        
        if (count($kanjiEx) == 0) {
            $kanjiEx = Kanji::find($id);            
        } 
        
        return view('kanji.kanji_example_action', ['edit' => new KanjiExampleResource($kanjiEx[0]),'created'=>false]);
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
        $kanjiExample = KanjiExample::where('autoId',$id)->get()[0];
        $result = KanjiExample::where('autoId', $id)->update([
                'cateId' => $request->cateId,
                'chapter' => $request->chapter,
                'content' => $request->kanji,
                'hanviet' => $request->hanviet,
                'onRead' => $request->onRead,
                'kunRead' => $request->kunRead,
                'otherRead' => $request->otherRead,
                'mean' => $request->mean,
            ]);

        if ($result) {
            \Session::flash('success', 'Kanji example successfully updated.');
        } else {
            \Session::flash('fail', 'Kanji example unsuccessfully updated.');
        }
        $chapter = Kanji::find($kanjiExample->id);
        $kanjiEx = KanjiExample::where('id', $kanjiExample->id)->get();

        return view('kanji.kanji_example', ['lstKanjiEx' => KanjiExampleResource::collection($kanjiEx), 'searchCate' => $chapter->cateId, 'searchChapter' => $chapter->chapter, 'searchChapterName' => $chapter->chapterName]);
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
        $kanjiEx = KanjiExample::where('autoId',$id)->get()[0];
        
        $countEx = KanjiExample::where('id',$id)->count('id');
        if($countEx == 1){
            $examplId = Kanji::find($id);
            $examplId->update([
                'exampleId' => 0,
            ]);
        }
        $result = $kanjiEx->delete();

        if ($result) {
            \Session::flash('success', 'Kanji example successfully deleted.');

            return redirect()->route('kanji-example.index');
        } else {
            \Session::flash('fail', 'Kanji example unsuccessfully deleted.');
        }
    }
}
