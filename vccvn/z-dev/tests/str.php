<?php

function test_match($str){
    preg_match_all('/([A-z0-9_\-]*)*(\#[A-z0-9_\-]|\.[A-z0-9_\-])*/i', $str, $match);

    print_r($match);
}