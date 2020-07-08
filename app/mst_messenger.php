<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mst_messenger extends Model
{
    protected $table = 'mst_messengers';

    
    public function trx_document()
    {
        return $this->hasMany('App\Trx_document', 'id');
    }
}
