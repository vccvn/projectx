<?php

namespace App\Models;

class TeamMember extends Model
{
    public $table = 'team_members';
    public $fillable = ['owner_id', 'team_id', 'member_id', 'is_leader', 'job'];

    public $timestamps = false;

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }
}
