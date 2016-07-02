<?php

namespace App\Http\Requests;

class StorePersonalDetailsRequest extends Request
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
            'name' => 'required|max:128',
            'gender' => 'required|PersonalDetails.Gender',
            'phone' => 'required',
            'email' => 'email|PersonalDetails.EmailExists',
            'nationality' => 'required',
            'preferred_contact_mode' => 'required|PersonalDetails.PreferredContactMode',
        ];
    }
}
