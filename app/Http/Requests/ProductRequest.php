<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // validar el usuario tenga permisos y retornar true para pasar la validacion
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
            //'title' => 'required|max:1000',
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:1000'],
            'price' => ['required', 'min:1'],
            'stock' => ['required', 'min:0'],
            'status' => ['required', 'in:available,unavailable'], // comprueba que sea algunos de los dos
        ];
    }

    /**
     * Configure the validator instance.
     * con este metodo podemos ejecutar nuestras propias validaciones
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            //* con $this se hace referencia a toda la informacion del request que guarda la variable $validator
            if ($this->status == 'available' && $this->stock == 0) {

                $validator->errors()->add('stock', 'If available must have stock'); // los agrega a las variables de sesion

                //session()->put('error', 'If available must have stock');// se mantiene y nunca se elimina hasta que se especifique con un forget

                //session()->flash('error', 'If available must have stock'); // se elimina en la proxima peticion

                //* withInput: se le pasan los datos que se quieren retornar a la sesion
                /*return redirect()->back()
                    ->withInput($request->all())
                    // permite enviar los errores a la variable de sesion ($erros)
                    ->withErrors('new error');*/
            }
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'description.required' => 'The description is required',
        ];
    }
}
