<?php

namespace Dodona\Http\Controllers\Administration;

use Dodona\Models\Check;
use Dodona\Http\Controllers\Controller;
use Dodona\Http\Requests\CheckRequest;

class CheckController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CheckRequest $request)
    {
        Check::create([
            'id'                => $request->get('id'),
            'name'              => $request->get('name'),
            'check_category_id' => $request->get('check_category_id'),
            'check_module_id'   => $request->get('check_module_id'),
        ]);

        \Flash::success("Check {$request->get('name')} ({$request->get('id')}) successfully created.");

        return redirect('administration/checks');
    }
}
