<?php

namespace App\Models;

class Team extends Model
{
    public $table = 'teams';
    public $fillable = ['owner_id', 'name', 'description'];

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }

    /**
     * lấy ra các thành viên trong team
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamMembers()
    {
        return $this->hasMany('App\Models\TeamMember', 'team_id', 'id');
    }

    /**
     * lấy ra các thành viên trong team
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    
    public function members()
    {
        return $this->teamMembers()->join('users', 'users.id', '=', 'team_members.member_id')
                    ->select('team_members.*', 'users.name', 'users.email', 'users.avatar');
    }

    public function beforeDelete()
    {
        $this->teamMembers()->delete();
    }
}
