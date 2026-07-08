<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoteRequest extends FormRequest
{
    /**
     * Determinar si el usuario esta autorizado.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para crear/editar lote.
     */
    public function rules(): array
    {
        $rules = [
            'producto'     => 'required|string|max:100',
            'variedad'     => 'required|string|max:100',
            'cantidad_kg'  => 'required|numeric|min:0.01',
            'etapa_actual' => 'required|in:Cultivo,Recepcion,Procesamiento,Empaque,Almacenamiento,Exportacion',
            'proveedor'    => 'required|string|max:200',
            'observaciones' => 'nullable|string|max:500',
        ];

        // Al crear, la fecha es obligatoria
        if ($this->isMethod('post')) {
            $rules['fecha'] = 'required|date';
        }

        return $rules;
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'producto.required'     => 'Seleccione un producto.',
            'variedad.required'     => 'Ingrese la variedad del producto.',
            'cantidad_kg.required'  => 'Ingrese la cantidad en kilogramos.',
            'cantidad_kg.numeric'   => 'La cantidad debe ser un numero.',
            'cantidad_kg.min'       => 'La cantidad debe ser mayor a 0.',
            'etapa_actual.required' => 'Seleccione la etapa actual.',
            'proveedor.required'    => 'Ingrese el nombre del proveedor.',
            'fecha.required'        => 'Seleccione la fecha de registro.',
            'fecha.date'            => 'La fecha no es valida.',
        ];
    }
}
