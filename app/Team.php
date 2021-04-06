<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'size',
    ];

    public function add($user){
        $this->guardAgainstTooManyMembers();

        if($user instanceof User){
            return $this->members()->save($user);
        }else{
            return $this->members()->saveMany($user);
        }
    }

    public function members(){
        return $this->hasMany(User::class);
    }

    public function count(){
        return $this->members()->count();
    }

    public function guardAgainstTooManyMembers()
    {
        if($this->count() >= $this->size){
            throw new \Exception();
        }
    }

    public function removeMember($user){
        $user->team_id = null;
        $user->save();
    }

    public function removeMembers($users = null){
        $deleteUsers = $users ? $users : $this->members()->get();
        $this->members()->whereIn('id', $deleteUsers->pluck('id'))->update(['team_id' => null]);
    }


}
