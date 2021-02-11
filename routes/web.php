<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrammarController;
use App\Http\Controllers\GrammarExampleController;
use App\Http\Controllers\KanjiController;
use App\Http\Controllers\KanjiExampleController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\VocabularyExampleController;
use App\Http\Controllers\LookAndLearnController;
use App\Http\Controllers\LookAndLearnExampleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});
Route::resource('grammar', GrammarController::class);
Route::get('grammar/search/chapter-exist', [GrammarController::class,'getGrammarChapterExist'])->name('getGrammarChapterExist');

Route::resource('grammar-example', GrammarExampleController::class);
Route::get('grammar-example/get-ex/{id}', [GrammarExampleController::class, "showEx"])->name('showEx');
Route::get('grammar-example/search/grammar', [GrammarExampleController::class, "getGrammar"])->name('getGrammar');
Route::get('grammar-example/search/chapter', [GrammarExampleController::class, "getChapterExist"])->name('getChapterExist');


Route::resource('kanji', KanjiController::class);
Route::get('kanji/search/chapter', [KanjiController::class,"getKanjiChapterExist"])->name("getKanjiChapterExist");
Route::get('kanji/search/kanji', [KanjiController::class,"getKanjiExist"])->name("getKanjiExist");

Route::resource('kanji-example', KanjiExampleController::class);
Route::get('kanji-example/get-kanji-ex/{id}', [KanjiExampleController::class, "getKanjiEx"])->name('getKanjiEx');
Route::get('kanji-example/search/chapter', [KanjiExampleController::class,"getKanjiExChapterExist"])->name("getKanjiExChapterExist");
Route::get('kanji-example/search/kanji', [KanjiExampleController::class,"getKanjiExExist"])->name("getKanjiExExist");

Route::resource('vocabulary', VocabularyController::class);
Route::get('vocabulary/search/chapter', [VocabularyController::class,"getVocabularyChapterExist"])->name("getVocabularyChapterExist");
Route::get('vocabulary/search/voca', [VocabularyController::class,"getVocabularyExist"])->name("getVocabularyExist");

Route::resource('vocabulary-example', VocabularyExampleController::class);
Route::get('vocabulary-example/search/{id}', [VocabularyExampleController::class,"getVocabularyEx"])->name('getVocabularyEx');
Route::get('vocabulary-example/example/search', [VocabularyExampleController::class,"getVocaExChapter"])->name("getVocaExChapter");
Route::get('vocabulary/search/voca-ex', [VocabularyExampleController::class,"getVocabularyExExist"])->name("getVocabularyExExist");

Route::resource('lookandlearn', LookAndLearnController::class);
Route::get('lookandlearn/search/chapter', [LookAndLearnController::class,"getLookChapter"])->name('getLookChapter');
Route::get('lookandlearn/search/kanji', [LookAndLearnController::class,"getLookKanji"])->name('getLookKanji');


Route::resource('lookandlearn-example', LookAndLearnExampleController::class);
Route::get('lookandlearn-example/search/chapterEx', [LookAndLearnExampleController::class,"getLookChapterEx"])->name('getLookChapterEx');
Route::get('lookandlearn-example/search/kanji', [LookAndLearnExampleController::class,"getLookKanjiEx"])->name('getLookKanjiEx');
