<?php

namespace Dodona\Http\Controllers\Administration;

use Dodona\Http\Controllers\Controller;
use Dodona\Http\Requests\ServerRequest;
use Dodona\Server;

class ServerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ServerRequest $request)
    {
		Server::create([
			'id'                     => $request->get('id'),
			'name'                   => $request->get('name'),
			'enabled'                => (is_null($request->get('enabled')) ? FALSE : TRUE),
			'description'            => $request->get('description'),
			'site_id'                => $request->get('site_id'),
			'operating_system_id'     => $request->get('operating_system_id'),
			'database_technology_id' => $request->get('database_technology_id'),
		]);

		return redirect('administration/servers');
    }
	
}
