<?php

namespace App\Http\Requests\Heathstone\Cards;

use Illuminate\Foundation\Http\FormRequest;

class SearchCards extends FormRequest
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
            'parameters.playerClass' => 'exists:heroes,id',
            'parameters.rarity' => 'exists:rarities,id',
            'parameters.type' => 'exists:types,id',
            'parameters.race' => 'exists:races,id',
            'parameters.mechanics' => 'exists:mechanics,id',
            'parameters.packset' => 'exists:packsets,id',
            'parameters.cost' => 'numeric|min:0',
            'parameters.attack' => 'numeric|min:0',
            'parameters.health' => 'numeric|min:0'
        ];
    }
}
