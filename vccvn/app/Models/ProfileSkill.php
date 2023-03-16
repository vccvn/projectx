<?php

namespace App\Models;

class ProfileSkill extends Model
{
    public $table = 'profile_skills';
    public $fillable = ['profile_id', 'skill_id', 'percentage', 'show', 'priority'];

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

    /**
     * sap xep lai thu tu
     *
     * @param integer $priority
     * @return void
     */
    public function updatePriority($priority=0)
    {
        $c = self::where('profile_id',$this->profile_id)->count();
        if($this->priority==0){
            $this->priority = $c;
            return $this->save();
        }

        if($priority != 0 && $priority != $this->priority){
            if($priority > $c){
                $priority = $c;
            }
            $query = static::where('profile_id',$this->profile_id)->where('id', '!=', $this->id);

            $begin = ($priority<$this->priority)?$priority:$this->priority;
            $end = ($priority>$this->priority)?$priority:$this->priority;    
            
            $query->whereBetween('priority',[$begin,$end]);
            
            if($list = $query->get()){
                if($priority > $this->priority){
                    foreach($list as $item){
                        $item->priority = $item->priority - 1;
                        $item->save();
                    }
                    
                }
                else{
                    foreach($list as $item){
                        $item->priority = $item->priority + 1;
                        $item->save();
                    }
                }   
            }
            $this->priority = $priority;
            $this->save();
            return true;
        }elseif($priority == 0){
            $count = self::where('profile_id',$this->profile_id)->count();
            if($this->priority==0){
                $this->priority = $count;
                $this->save();
                return true;
            }
            return $this->updatePriority($count);
        }
        return false;
    }

    public static function repairPriority($profile_id)
    {
        $max = self::where('profile_id',$profile_id)->count();
        if(count($list = self::where('profile_id',$profile_id)->orderBy('priority','DESC')->get())>0){
            foreach($list as $menu){
                if($menu->priority>$max){
                    $menu->priority = $max;
                    $menu->save();
                }
                $max--;
            }
        }
    }


}
