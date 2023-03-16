<?php
class DoanLN implements PHPDev, JSDev, NodeJsDev{
    // variable & const
    const NAME        = "Le Ngoc Doan";
    const GENDER      = "Male";
    var   $age        = 28;
    var   $job        = 'Web Developer';
    var   $phone      = '094.578.6960';
    var   $email      = 'doanln16@gmail.com';
    // use for work
    use Laravel, WordPress, ReactJS;

    public function doWork(Work $work)
    {
        do{
            // try hard
        }while($work->done());
    }

    public function retry(Work $work)
    {
        # code...
    }
}