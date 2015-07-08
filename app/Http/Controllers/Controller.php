<?php

namespace Dodona\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public $items_per_page;

    public function __construct()
    {
        $this->middleware('sentry.auth');

        $this->items_per_page = (int) getenv('ITEMS_PER_PAGE');
    }

}
