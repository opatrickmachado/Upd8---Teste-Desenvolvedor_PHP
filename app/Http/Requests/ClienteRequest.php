<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{   
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [            
            'xnumeroCPF' => "required|min:14|max:15",    
            'xnomeCliente' => 'required|max:255',       
            'xnomeRua' => 'required|max:255',    
            'xdataNascimento' => 'required|date_format:d/m/Y',   
            'xsexoCliente' => 'required', 
            'xestado_id' => 'required|not_in:0', 
            'xcidade_id' => 'required|not_in:0'
        ];
    }
    public function messages()
    {
        return [            
            'xnumeroCPF.required' => 'CPF Obrigatorio!',
            'xnumeroCPF.min' => 'CPF informado esta invalido!',
            'xnumeroCPF.max' => 'CPF informado esta invalido!',
            'xnumeroCPF.unique' => 'Outro Cliente já cadastrou esse CPF',
            'xnomeCliente.required' => 'Nome Obrigatorio',
            'xnomeCliente.max' => 'Nome informado eh invalido!',
            'xnomeRua.required' => 'Endereco Obrigatorio',
            'xnomeRua.max' => 'Endereco informado eh invalido',
            'xestado_id.required' => 'Selecionar Estado eh Obrigatorio',
            'xestado_id.not_in' => 'Selecio Estado eh Obrigatorio',
            'xcidade_id.required' => 'Selecionar Cidade eh Obrigatorio',
            'xcidade_id.not_in' => 'Selecionar Cidade eh Obrigatorio',
            'xsexoCliente.required' => 'Selecionar sexo ao Cliente eh Obrigatorio',
            'xdataNascimento.required' => 'Eh Obrigatorio informar Data de Nascimento ao Cliente',
            'xdataNascimento.date_format' => 'Data de Nascimento esta invalida!',
        ];
    }
}