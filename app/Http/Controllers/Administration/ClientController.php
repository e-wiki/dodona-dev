<?php

namespace Dodona\Http\Controllers\Administration;

use Dodona\Client;
use Dodona\Http\Requests\ClientRequest;
use Dodona\Http\Controllers\Controller;

class ClientController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ClientRequest $request)
    {
		Client::create([
			'id'          => $request->get('id'),
			'name'        => $request->get('name'),
			'enabled'     => (is_null($request->get('enabled')) ? FALSE : TRUE),
			'description' => $request->get('description'),
		]);

		\Flash::success("Client {$request->get('name')} ({$request->get('id')}) successfully created.");
		
		return redirect('administration/clients');
    }
	
}
