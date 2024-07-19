<?php
/**
 *   Stake iGaming platform
 *   ----------------------
 *   UpdateUser.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    
    public function authorize()
    {
        return TRUE;
    }

    
    public function rules()
    {
        $rules = [
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        
        if (config('settings.users.email_auth') && $this->user()->email) {
            $rules['email'] = 'required|email|max:100|unique:users,email,' . $this->user()->id;
        }

        foreach (config('settings.users.fields') as $field) {
            if ($field->validation) {
                $rules['fields.' . $field->id] = $field->validation;
            }
        }

        return $rules;
    }
}
