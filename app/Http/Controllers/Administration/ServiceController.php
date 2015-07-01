<?php

namespace Dodona\Http\Controllers\Administration;

use Dodona\Http\Controllers\Controller;
use Dodona\Http\Requests\ServiceRequest;
use Dodona\Service;

class ServiceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ServiceRequest $request)
    {
        Service::create([
            'id'          => $request->get('id'),
            'name'        => $request->get('name'),
            'enabled'     => (is_null($request->get('enabled')) ? false : true),
            'description' => $request->get('description'),
            'client_id'   => $request->get('client_id'),
        ]);

        \Flash::success("Service {$request->get('name')} ({$request->get('id')}) successfully created.");

        return redirect('administration/services');
    }
}
