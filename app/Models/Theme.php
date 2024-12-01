<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Theme extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['name'];

    public $sortable = ['id', 'name'];


    public function words()
    {
        return $this->belongsToMany(Word::class, 'words_theme', 'theme_id', 'word_id');
    }
}
