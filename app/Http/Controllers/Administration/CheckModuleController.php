<?php

namespace Dodona\Http\Controllers\Administration;

use Dodona\Models\CheckModule;
use Dodona\Http\Controllers\Controller;
use Dodona\Http\Requests\CheckModuleRequest;

class CheckModuleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CheckModuleRequest $request)
    {
        CheckModule::create([
            'name' => $request->get('name'),
        ]);

        \Flash::success("Check Module {$request->get('name')} successfully created.");

        return redirect('administration/check_modules');
    }
}
