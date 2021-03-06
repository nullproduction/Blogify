<?php namespace jorenvanhocht\Blogify\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    |
    | For more information pleas check out the official Laravel docs at
    | http://laravel.com/docs/5.0/eloquent#query-scopes
    |
    */

    public function scopeByHash( $query, $hash )
    {
        return $query->whereHash($hash)->first();
    }

}