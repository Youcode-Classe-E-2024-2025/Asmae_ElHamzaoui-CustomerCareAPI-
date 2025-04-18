<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'agent_id', 'title', 'description', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function agent() {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }
}

