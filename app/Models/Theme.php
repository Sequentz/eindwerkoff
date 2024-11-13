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

    // Define the many-to-many relationship
    public function words()
    {
        return $this->belongsToMany(Word::class, 'words_theme');
    }
}
