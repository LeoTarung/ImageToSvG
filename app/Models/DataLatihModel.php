<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLatihModel extends Model
{
    use HasFactory;
    protected $table = 'db_latih';
    protected $guarded = [];
    protected $primaryKey = 'no';
}
