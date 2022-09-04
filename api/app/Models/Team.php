<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;


    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function leader()
    {
        $leader_id = $this->team_leader;

        return User::where('id', $leader_id)->first();
    }
}
