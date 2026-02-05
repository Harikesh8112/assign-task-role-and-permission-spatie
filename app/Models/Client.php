<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'email',
    ];

    public function shortUrls()
    {
        return $this->hasMany(ShortURLs::class);
    }
}
