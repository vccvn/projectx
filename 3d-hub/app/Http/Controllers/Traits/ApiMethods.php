<?php

namespace App\Http\Controllers\Traits;

trait ApiMethods{
    use CrudMethods, ApiCrud, ApiFilter;
}