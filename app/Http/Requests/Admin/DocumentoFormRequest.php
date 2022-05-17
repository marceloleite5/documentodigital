<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoFormRequest extends FormRequest
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
        $id = $this->segment(2);
        return [
            'nome' => "required|max:100|unique:documento,nome,{$id},id",
            'tipodocumento_id' => 'required',
            'filial_id' => 'required',
            'setor_id' => 'required',
            'armario' => 'required|max:10',
            'gaveta' => 'required|max:10',
            'pasta' => 'required|max:10',
            'data_documento' => 'required|date',
        ];
    }
}
