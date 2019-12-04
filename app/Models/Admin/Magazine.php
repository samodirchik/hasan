<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Magazine extends Model {

    protected $fillable = [
        'name',
        'image',
        'book',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
