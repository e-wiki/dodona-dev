<?php

namespace Dodona\Http\Requests;

use Dodona\Http\Requests\Request;

class ClientRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => ['required', 'regex:/[A-Z][A-Z]/'],
            'name'        => 'required|min:2|max:50',
            'description' => 'required|min:10|max:450',
        ];
    }
}
