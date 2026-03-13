<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'event_date'         => 'required',
            'location'           => 'required|string|max:255',
            'address' => 'required_unless:modality,online|nullable|string|max:255',
            'modality'           => 'required|in:presencial,online,hibrido',
            'category_id'        => 'required|exists:categories,id',
            'campus_id'          => 'required|exists:campuses,id',
            'knowledge_area_id'  => 'required|exists:knowledge_areas,id',
            'is_paid'            => 'required|boolean',
            'has_interpreter'    => 'required|boolean',
            'is_accessible'      => 'required|boolean',
            'responsible_name'   => 'required|string|max:255',
            'responsible_email'  => 'required|email',
            'responsible_phone'  => 'required|string|max:20',
            'event_link'         => 'nullable|url',
            'registration_link'  => 'nullable|url',
            'banner'             => 'nullable|image|max:2048',
            'banner_alt_text'    => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'             => 'O título é obrigatório.',
            'description.required'       => 'A descrição é obrigatória.',
            'event_date.required'        => 'A data do evento é obrigatória.',
            'location.required'          => 'O local é obrigatório.',
            'address.required'           => 'O endereço é obrigatório.',
            'modality.required'          => 'A modalidade é obrigatória.',
            'modality.in'                => 'Modalidade inválida.',
            'category_id.required'       => 'Selecione uma categoria.',
            'category_id.exists'         => 'Categoria inválida.',
            'campus_id.required'         => 'Selecione um campus.',
            'campus_id.exists'           => 'Campus inválido.',
            'knowledge_area_id.required' => 'Selecione uma área do conhecimento.',
            'knowledge_area_id.exists'   => 'Área do conhecimento inválida.',
            'is_paid.required'           => 'Informe se o evento é pago ou gratuito.',
            'has_interpreter.required'   => 'Informe se há intérprete de Libras.',
            'is_accessible.required'     => 'Informe se o local é acessível.',
            'responsible_name.required'  => 'O nome do responsável é obrigatório.',
            'responsible_email.required' => 'O e-mail do responsável é obrigatório.',
            'responsible_email.email'    => 'Informe um e-mail válido.',
            'responsible_phone.required' => 'O telefone do responsável é obrigatório.',
            'event_link.url'             => 'O link do evento deve ser uma URL válida.',
            'registration_link.url'      => 'O link de inscrição deve ser uma URL válida.',
            'banner.image'               => 'O banner deve ser uma imagem.',
            'banner.max'                 => 'O banner deve ter no máximo 2MB.',
        ];
    }
}
