<?php

namespace App\Models;

class Experience extends Model
{
    public $table = 'experiences';
    public $fillable = ['profile_id', 'org_id', 'type', 'title', 'description', 'has_start_date', 'has_finish_date', 'started_at', 'finished_at'];

    public $timestamps = false;

    protected $_dates = [];
    protected $_times = [];
    
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
     * lấy thông tin date
     *
     * @param string $column tên cột
     * @param string $type array hay string
     * @return void
     */
    public function getDate(string $column, $type = 'array')
    {
        if(!$c = $this->getTimeColumn($column)) {
            $datetime = date('Y-m-d H:i:s');
            $dateData = parse_date_time($datetime);
        }else{
            $this->_dates = [
                'started_at' => parse_date_time($this->started_at),
                'finished_at' => parse_date_time($this->finished_at)
            ];
            $dateData = $this->_dates[$c];
        }
        return (strtolower($type) == 'string' || $type == 1) ? $dateData['year'] . '-' . $dateData['month'] . '-' . $dateData['day'] : $dateData;
    }

    /**
     * lấy thông tin time
     *
     * @param string $column
     * @param string $format
     * @return string
     */
    public function getTime($column, $format = null)
    {
        if(!$c = $this->getTimeColumn($column)) return ($format ? date($format) : time());
        if(!array_key_exists($c, $this->_times)){
            $this->_times = [
                'started_at' => strtotime($this->started_at),
                'finished_at' => strtotime($this->finished_at)
            ];
        }
        $time = $this->_times[$c];
        return ($format?date($format,$time):$time);
    }

    public function getTimeColumn($column)
    {
        if(in_array($c = strtolower($column), ['started_at', 'finished_at'])) return $c;
        return null;
    }
}
