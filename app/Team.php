<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'size',
    ];

    public function add($users){
        $this->guardAgainstTooManyMembers($users);

        if($users instanceof User){
            return $this->members()->save($users);
        }else{
            return $this->members()->saveMany($users);
        }
    }

    public function members(){
        return $this->hasMany(User::class);
    }

    public function count(){
        return $this->members()->count();
    }

    public function guardAgainstTooManyMembers($users)
    {
        $usersToAddCount = ($users instanceof User) ? 1 : count($users);
        $newTeamCount = $this->count() + $usersToAddCount;

        if($newTeamCount > $this->size){
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
