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
        $search = $request->chapter;
        $cate = $request->category;
        $kanjiId = $request->kanjiId;
        $chapter = null;
        $chapterName = '';
        $lstKaniEx = [];
        if (isset($cate)) {
            if ($search != 0 && $cate != 0 && $kanjiId != 0) {
                $lstKaniEx = KanjiExample::where('cateId', $cate)->where('chapter', $search)->where('kanjiId', $kanjiId)->get();
                $chapter = $search;
                $chapterName = Kanji::where('chapter', $search)->get('chapterName')->first()->chapterName;
            } elseif ($search != 0) {
                $lstKaniEx = KanjiExample::where('chapter', $search)->get();
                $chapter = $search;
                $chapterName = Kanji::where('chapter', $search)->get('chapterName')->first()->chapterName;
            } elseif ($cate != 0 && $kanjiId != 0) {
                $lstKaniEx = KanjiExample::where('cateId', $cate)->where('kanjiId', $kanjiId)->get();
            }else {
                $lstKaniEx = KanjiExample::where('cateId', 1)->get();
                $cate = 1;
            }
        } else {
            $lstKaniEx = KanjiExample::where('cateId', 1)->get();
            $cate = 1;
        }
        $kanjiName = '';
        if (isset($kanjiId)) {
            $kanjiName = Kanji::where('id', $kanjiId)->get('kanji')->first()->kanji;
        }

        return view('kanji.kanji_example', ['lstKanjiEx' => KanjiExampleResource::collection($lstKaniEx), 'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName, 'searchKanji' => $kanjiId, 'searchKanjiName' => $kanjiName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $kanji = KanjiExample::where('kanjiId', $request->kanjiId)->get();

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
                'kanjiId' => $request->kanjiId,
                'cateId' => $request->cateId,
                'chapter' => $request->chapter,
                'content' => $request->kanji,
                'onRead' => $request->onRead,
                'kunRead' => $request->kunRead,
                'otherRead' => $request->otherRead,
                'mean' => $request->mean,
            ]);
        $kanji = Kanji::find($request->kanjiId);
        if ($kanji->exampleId == 0) {
            $kanji->exampleId = $kanjiExample->id;
            $kanji->update();
        }
        if ($kanjiExample) {
            \Session::flash('success', 'Kanji example successfully created.');
        } else {
            \Session::flash('fail', 'Kanji example unsuccessfully created.');
        }

        $chapter = Kanji::find($kanjiExample->kanjiId);
        $kanjiEx = KanjiExample::where('kanjiId', $kanjiExample->kanjiId)->get();

        return view('kanji.kanji_example', ['lstKanjiEx' => KanjiExampleResource::collection($kanjiEx), 'searchCate' => $chapter->cateId, 'searchChapter' => $chapter->chapter, 'searchChapterName' => $chapter->chapterName, 'searchKanji' => $chapter->id, 'searchKanjiName' => $chapter->kanji]);
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
        $kanjiEx = KanjiExample::find($id);

        return view('kanji.kanji_example_action', ['kanjiEx' => new KanjiExampleResource($kanjiEx)]);
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
        $kanjiEx = KanjiExample::where('kanjiId', $id)->get();
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
    public function getKanjiExist(Request $request)
    {
        $search = $request->key;
        $cate = $request->cate;
        $chapter = $request->chapter;
        $kanji = [];
        if (isset($search)) {
            $kanji = Kanji::where('cateId', $cate)->where('chapter', $search)->get(['id', 'kanji']);
        } elseif (isset($chapter)) {
            $kanji = Kanji::where('cateId', $cate)->get(['id', 'kanji']);
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
        $kanji = KanjiExample::find($id);
        if (!isset($kanji)) {
            $kanji = Kanji::find($id);
        }
        
        return view('kanji.kanji_example_action', ['edit' => new KanjiExampleResource($kanji),'created'=>false]);
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
        $kanjiExample = KanjiExample::find($id);
        
        // $kanjiExample->kanjiId = $request->kanjiId;
        $kanjiExample->cateId = $request->cateId;
        $kanjiExample->chapter = $request->chapter;
        $kanjiExample->content = $request->kanji;
        $kanjiExample->onRead = $request->onRead;
        $kanjiExample->kunRead = $request->kunRead;
        $kanjiExample->otherRead = $request->otherRead;
        $kanjiExample->mean = $request->mean;
        $result = $kanjiExample->update();
        if ($result) {
            \Session::flash('success', 'Kanji example successfully updated.');
        } else {
            \Session::flash('fail', 'Kanji example unsuccessfully updated.');
        }
        $chapter = Kanji::find($kanjiExample->kanjiId);
        $kanjiEx = KanjiExample::where('kanjiId', $kanjiExample->kanjiId)->get();

        return view('kanji.kanji_example', ['lstKanjiEx' => KanjiExampleResource::collection($kanjiEx), 'searchCate' => $chapter->cateId, 'searchChapter' => $chapter->chapter, 'searchChapterName' => $chapter->chapterName, 'searchKanji' => $chapter->id, 'searchKanjiName' => $chapter->kanji]);
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
        $kanjiEx = KanjiExample::find($id);
        $countEx = KanjiExample::where('kanjiId', $kanjiEx->kanjiId)->count('kanjiId');
        if($countEx == 1){
            $examplId = Kanji::find($kanjiEx->kanjiId);
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
