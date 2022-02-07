<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public static  function search($keyword)
    {
        return self::where('item_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('item_code', 'LIKE', '%' . $keyword . '%');
    }
}
