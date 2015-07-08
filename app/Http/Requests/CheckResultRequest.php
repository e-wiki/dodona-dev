<?php

namespace Dodona\Http\Requests;

use Dodona\Http\Requests\Request;

class CheckResultRequest extends Request
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
            'id'          => ['required', 'regex:/[CRAP][MNOS][LW]([0-9]{2}[1-9]|[0-9][1-9][0-9]|[1-9][0-9]{2})[RAGB]([0-9][1-9]|[1-9][0-9])/'],
            'name'        => 'required|min:2|max:100',
        ];
    }
}
