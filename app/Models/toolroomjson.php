<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class toolroomjson extends Model
{
    use HasFactory;

    protected $table = 'items'; // nama tabel di database
    protected $fillable = ['No', 'ItemCode', 'itemName', 'description', 'StatusBarang', 'OP', 'OQ', 'Stock']; // field yang bisa diisi
}
