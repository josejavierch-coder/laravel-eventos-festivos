<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventoFestivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'salon_id' => 'required|exists:salons,id',
            'fecha_evento' => 'required|date',
            'slug' => 'nullable|string|max:255|unique:eventos_festivos,slug,' . $this->evento->id,
            'descripcion' => 'nullable|string',
            'imagen_representativa' => 'nullable|image|max:2048',
            'estado' => 'boolean',
            'fotos' => 'nullable|array|max:5',
            'fotos.*' => 'image|max:2048',
        ];
    }
}
