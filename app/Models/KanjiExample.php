<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kanji;

class KanjiExample extends Model
{
    use HasFactory;
    protected $guarded = [];  
    public $timestamps = false;
    public function getCategoryAttribute()
    {
        switch ($this->cateId) {
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
    public function getChapterExAttribute()
    {
        return Kanji::where('chapter',$this->chapterId)->groupBy('chapter')->get('chapterName')[0]['chapterName'];
    }
}
