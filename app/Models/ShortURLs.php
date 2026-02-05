<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortURLs extends Model
{
    //
    protected $table = 'short_urls';
    protected $fillable = [
        'client_id',
        'user_id',
        'short_code',
        'long_url',
        'clicks',
    ];
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
