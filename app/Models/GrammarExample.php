<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grammar;

class GrammarExample extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = []; 
    public function getCateAttribute(){
        switch ($this->category) {
            case 1:
                return '新完全マスタ';
            case 2:
                return '総まとめ';
            case 3:
                return '耳から覚える';
            case 4:
                return 'Kanji Look And Learn';

        }
    }
    public function getChapterNameAttribute(){
        return Grammar::where('chapter', $this->chapter)->get('chapterName')->first()->chapterName;
    }
}
