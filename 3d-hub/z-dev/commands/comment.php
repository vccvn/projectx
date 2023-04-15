<?php
if (!function_exists('comment')) {
    /**
     * comment
     * 
     */
    function comment()
    {
        $data = [
            // select
            'select' => 'select',
            'selectraw' => 'selectRaw',
            // from
            'from' => 'from',
            'fromraw' => 'fromRaw',
            // join
            'join' => 'join',
            'leftjoin' => 'leftJoin',
            'crossjoin' => 'crossJoin',
            // where
            'where' => 'where',
            'whereraw' => 'whereRaw',
            'wherein' => 'whereIn',
            'wherenotin' => 'whereNotIn',
            'wherebetween' => 'whereBetween',
            'wherenotbetween' => 'whereNotBetween',
            'whereday' => 'whereDay',
            'wheremonth' => 'whereMonth',
            'whereyear' => 'whereYear',
            'wheredate' => 'whereDate',
            'wheretime' => 'whereTime',
            'wherecolumn' => 'whereColumn',
            // orwhere
            'orwhere' => 'orWhere',
            'orwhereraw' => 'orWhereRaw',
            'orwherein' => 'orWhereIn',
            'orwherenotin' => 'orWhereNotIn',
            'orwherebetween' => 'orWhereBetween',
            'orwherenotbetween' => 'orWhereNotBetween',
            'orwhereday' => 'orWhereDay',
            'orwheremonth' => 'orWhereMonth',
            'orwhereyear' => 'orWhereYear',
            'orwheredate' => 'orWhereDate',
            'orwheretime' => 'orWhereTime',
            'orwherecolumn' => 'orWhereColumn',
            // groupby
            'groupby' => 'groupBy',
            // having
            'having' => 'having',
            'havingraw' => 'havingRaw',
            // orderby
            'orderby' => 'orderBy',
            'orderbyraw' => 'orderByRaw',
            // limit
            'skip' => 'skip',
            'take' => 'take',

            'with',
            'load'

        ];
        $str = "/**\n * danh sách method";
        foreach ($data as $key => $value) {
            $str .= "\n * @method BaseRepository $value(\$_ = null)";
        }
        $str.="\n */";
        echo $str;
    }
}
