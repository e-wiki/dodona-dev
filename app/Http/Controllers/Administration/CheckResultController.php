<?php

namespace Dodona\Http\Controllers\Administration;

use Dodona\Models\CheckResult;
use Dodona\Http\Controllers\Controller;
use Dodona\Http\Requests\CheckResultRequest;

class CheckResultController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CheckResultRequest $request)
    {
        CheckResult::create([
            'id'       => $request->get('id'),
            'name'     => $request->get('name'),
            'check_id' => $request->get('check_id'),
            'alert_id' => $request->get('alert_id'),
        ]);

        \Flash::success("Check Result {$request->get('name')} ({$request->get('id')}) successfully created.");

        return redirect('administration/check_results');
    }
}
