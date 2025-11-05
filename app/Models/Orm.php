<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orm extends Model
{
    //
    protected $fillable = [
        'title',
        'date',
        'type',
        'file',
    ];
    public function omType()
{
    return $this->belongsTo(OmType::class, 'type', 'id');
}

}
