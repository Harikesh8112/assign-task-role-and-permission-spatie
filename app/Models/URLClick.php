<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class URLClick extends Model
{
    //
    protected $table = 'url_clicks';
    protected $fillable = [
        'short_url_id',
        'user_id',
        'clicked_at',
    ];
}
