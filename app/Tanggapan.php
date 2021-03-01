<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    protected $table = 'tanggapan';
    protected $primaryKey = 'id_tanggapan';
    protected $guarded = [];
    protected $hidden = ['password'];
}
