<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrammarExample;
use App\Models\Grammar;
use App\Http\Resources\Grammar\GrammarExampleResource;
use App\Http\Resources\Grammar\GrammarItemResource;
use App\Http\Resources\Grammar\GrammarChapterResource;

class GrammarExampleController extends Controller
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
        $grammarEx = [];
        if (isset($search) && $search != 0 && isset($cate)) {
            $grammarEx = GrammarExample::where('category', $cate)->where('chapter', $search)->get();
            $chapter = $search;
            $chapterName = Grammar::where('chapter', $search)->get('chapterName')->first()->chapterName;;
        } elseif (isset($search) && $search != 0) {
            $grammarEx = GrammarExample::where('chapter',$search)->get();
            $chapter = $search;
            $chapterName = Grammar::where('chapter', $search)->get('chapterName')->first()->chapterName;;
        } elseif (isset($cate)) {
            $grammarEx = GrammarExample::where('category', $cate)->get();
        } else {
            $grammarEx = GrammarExample::where('category', 1)->get();
            $cate = 1;
        }
        
        return view('grammar.grammar_example',['lstGrammarEx' => GrammarExampleResource::collection($grammarEx),'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $chapter = Grammar::find($request->id);
        $fixChapter = [];
        $fixChapter[] = $chapter->chapter;
        $fixChapter[] = $chapter->chapterName;
        $fixGrammar =[];
        $fixGrammar[] = $chapter->id;
        $fixGrammar[] = $chapter->structs;
        return view('grammar.grammar_example_action', ['grammarEx'=> null, 'fixChapter'=>$fixChapter, 'fixGrammar'=> $fixGrammar]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (substr_count($request->title, '<p>') == 1) {
            $request->title = preg_replace('/<\/?p>/i', '', $request->title);
        }
        if (substr_count($request->toRead, '<p>') == 1) {
            $request->toRead = preg_replace('/<\/?p>/i', '', $request->toRead);
        }
        if (substr_count($request->mean, '<p>') == 1) {
            $request->mean = preg_replace('/<\/?p>/i', '', $request->mean);
        }
        
        $grammEx = GrammarExample::create(
            [
                'productId' => $request->grammar,
                'chapter'   => $request->chapter,
                'category'  => $request->category,
                'title'     => $request->title,
                'toRead'    => $request->toRead,
                'mean'      => $request->mean,
            ]
        );
        if ($grammEx) {
            \Session::flash('success', 'Grammar example successfully created.');
        } else {
            \Session::flash('fail', 'Grammar example unsuccessfully created.');
        }

        $gr = Grammar::find($grammEx->productId);

        return view('grammar.grammar_example',['lstGrammarEx' => GrammarExampleResource::collection($grammarEx),'searchCate' => $grammEx->category, 'searchChapter' => $grammEx->chapter, 'searchChapterName' => $gr->chapterName]);
        // return redirect()->route('grammar-example.index');        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grammarEx = GrammarExample::find($id);
        $chapter = Grammar::where('id', $id)->groupBy('chapter')->get('chapterName');
        $grammar = Grammar::where('id', $id)->get('structs');
        return view('grammar.grammar_example_action', ['grammarEx'=> new GrammarExampleResource( $grammarEx), 'chapter_name'=>$chapter[0]["chapterName"], 'grammar_name'=> $grammar[0]["structs"]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEx($id)
    {
        $grammarEx = GrammarExample::where('productId', $id)-> get();
        $lstChapter = Grammar::find($id);
        $cate = $lstChapter->cateId;
        $chapter = $lstChapter->chapter;
        $chapterName = $lstChapter->chapterName;
        return view('grammar.grammar_example', ['grammarEx'=> GrammarExampleResource::collection($grammarEx),'searchCate' => $cate, 'searchChapter' => $chapter, 'searchChapterName' => $chapterName]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getGrammar(Request $request)
    {   
        $search = $request->key;
        $chapter = $request ->chapter; 
        $grammarEx = [];
        if(isset($search)){
            $grammarEx = Grammar::where('chapter', $chapter)->where('structs','LIKE', '%'.$search.'%')->get(['id', 'structs']);
        }else{
            $grammarEx = Grammar::where('chapter', $chapter)->get(['id', 'structs']);
        }
        return ['results'=> GrammarItemResource::collection($grammarEx)];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getChapterExist(Request $request)
    {   
        $search = $request->key;
        $cate = $request ->cate;
        $grammarEx = [];
        if(isset($search)){
            $grammarEx = Grammar::where('cateId',$cate)->where('chapterName','LIKE','%'.$search.'%')->groupBy('chapter')->get(['chapter', 'chapterName']);
        }else{
            $grammarEx = Grammar::where('cateId',$cate)->groupBy('chapter')->get(['chapter', 'chapterName']);
        }
        return ['results'=> GrammarChapterResource::collection($grammarEx)];
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grammarEx = GrammarExample::find($id);
        $chapter = Grammar::where('id', $id)->groupBy('chapter')->get('chapterName');
        $grammar = Grammar::where('id', $id)->get('structs');
        return view('grammar.grammar_example_action', ['grammarEx'=> new GrammarExampleResource( $grammarEx), 'chapter_name'=>$chapter[0]["chapterName"], 'grammar_name'=> $grammar[0]["structs"]]);
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
        if (substr_count($request->title, '<p>') == 1) {
            $request->title = preg_replace('/<\/?p>/i', '', $request->title);
        }
        if (substr_count($request->toRead, '<p>') == 1) {
            $request->toRead = preg_replace('/<\/?p>/i', '', $request->toRead);
        }
        if (substr_count($request->mean, '<p>') == 1) {
            $request->mean = preg_replace('/<\/?p>/i', '', $request->mean);
        }
        $grammEx = GrammarExample::find($id);
        $grammEx = $grammEx->update(
            [
                'productId' => $request->grammar,
                'chapter'   => $request->chapter,
                'category'  => $request->category,
                'title'     => $request->title,
                'toRead'    => $request->toRead,
                'mean'      => $request->mean,
            ]
        );
        if ($grammEx) {
            \Session::flash('success', 'Grammar example successfully updated.');
        } else {
            \Session::flash('fail', 'Grammar example unsuccessfully updated.');
        }
         $gr = Grammar::find($grammEx->productId);

        return view('grammar.grammar_example',['lstGrammarEx' => GrammarExampleResource::collection($grammarEx),'searchCate' => $grammEx->category, 'searchChapter' => $grammEx->chapter, 'searchChapterName' => $gr->chapterName]);
        // return redirect()->route('grammar-example.index');      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grammar = GrammarExample::find($id);
        $counter = GrammarExample::where('productId', $id)->count('exampleId');
        if($counter == 1){
            $gram = Grammar::where('id', $grammar->productId)->get();
            $gram->update([
                'exampleId' => 0
            ]);
        }
        $result = $grammar->destroy();
        if ($result) {
            \Session::flash('success', 'Grammar successfully deleted.');
            return redirect()->route('grammar.index');
        } else {
            \Session::flash('fail', 'Grammar unsuccessfully deleted.');
        }
    }

}
