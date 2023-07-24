<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjiModel extends Model
{
    use HasFactory;
    protected $table = 'db_hasil_uji';
    protected $guarded = [];
    protected $primaryKey = 'no';
}
