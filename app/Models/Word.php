<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Word extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = ['name']; // Adjust as per your attributes

    // Define the many-to-many relationship
    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'words_theme');
    }
}
