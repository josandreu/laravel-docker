<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Podemos usar este método para comprobar si un id concreto pertenece al usuario, por ejemplo.
     * https://laravel.com/docs/6.x/validation
     * @return bool
     */
    public function authorize()
    {
        //if(Request::input('email') == 'jos@josandreu.com') return true;
        //else return false;
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
            'token' => 'required|min:5',
            'email' => 'required|email'
            // required|email|exist:users,email  ---> requerido | de tipo email | si existe en la tabla users y columna email
        ];
    }

    public function messages() {
        return [
            'email.required' => 'Es necesario un email',
            'token.required'  => 'El token es obligatorio'
        ];
    }

    // para que muestre los errores y no haga un redirect al index
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
