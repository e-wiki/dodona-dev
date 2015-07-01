<?php

namespace Dodona\Http\Controllers\Administration;

use Dodona\Http\Controllers\Controller;
use Dodona\Http\Requests\SiteRequest;
use Dodona\Site;

class SiteController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(SiteRequest $request)
    {
		Site::create([
			'id'             => $request->get('id'),
			'name'           => $request->get('name'),
			'service_id'     => $request->get('service_id'),
			'environment_id' => $request->get('environment_id'),
		]);

		\Flash::success("Site {$request->get('name')} ({$request->get('id')}) successfully created.");

		return redirect('administration/sites');
    }
	
}
