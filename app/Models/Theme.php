<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Theme extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'id',
        'theme',

    ];
    protected $fillable = [
        'name',
    ];
}
