<?php

namespace App\Http\Requests\Hearthstone\Cards;

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
            'playerClass' => 'exists:heroes,id',
            'rarity' => 'exists:rarities,id',
            'type' => 'exists:types,id',
            'race' => 'exists:races,id',
            'mechanics' => 'exists:mechanics,id',
            'packset' => 'exists:packsets,id',
            'cost' => 'numeric|min:0',
            'attack' => 'numeric|min:0',
            'health' => 'numeric|min:0'
        ];
    }
}
