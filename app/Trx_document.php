<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trx_document extends Model
{
    //
    protected $table = "trx_documents";
    
    public function trxDocument()
    {
        
    }

    public function mst_messengers()
    {
        return $this->belongsTo('App\mst_messenger', 'messenger_id');
    }                             
}
