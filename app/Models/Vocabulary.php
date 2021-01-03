<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;
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
}
