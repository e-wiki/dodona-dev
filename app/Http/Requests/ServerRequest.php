<?php

namespace Dodona\Http\Requests;

use Dodona\Http\Requests\Request;

class ServerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => ['required', 'regex:/[A-Z]{2}([0-9]{2}[1-9]|[0-9][1-9][0-9]|[1-9][0-9]{2})[PSTD][1-9]([0-9]{2}[1-9]|[0-9][1-9][0-9]|[1-9][0-9]{2})/'],
			'name'        => 'required|min:2|max:50',
			'description' => 'required|min:10|max:450',
        ];
    }
}
