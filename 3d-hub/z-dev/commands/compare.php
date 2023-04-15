<?php
if(!function_exists('compare')){
    /**
     * compare
     * 
     */
    function compare(int $a, $b = null)
    {
        echo "So sanh: \$a == \$b ($a === $b) : ".(($a===$b) ? "true": "false");
    }
}