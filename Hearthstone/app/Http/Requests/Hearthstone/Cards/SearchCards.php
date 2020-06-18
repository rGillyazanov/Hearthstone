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
            'hero_id' => 'exists:heroes,id',
            'rarity_id' => 'exists:rarities,id',
            'type_id' => 'exists:types,id',
            'race_id' => 'exists:races,id',
            'mechanics' => 'exists:mechanics,id',
            'packset_id' => 'exists:packsets,id',
            'cost' => 'numeric|min:0',
            'attack' => 'numeric|min:0',
            'health' => 'numeric|min:0',
            'sort' => ['json', function ($attribute, $value, $fail) {
                $this->sorted($attribute, $value, $fail);
            }]
        ];
    }

    /**
     * Проверяет, чтобы поля и типы сортировки, соответствовали
     * типам, указанным в форме.
     * @param $attribute
     * @param $value
     * @param $fail
     */
    private function sorted($attribute, $value, $fail) {
        $value = json_decode($value);
        if (!($value->name == 'cost' || $value->name == 'attack' || $value->name == 'health')
            || !($value->type == 'asc' || $value->type == 'desc')) {
            $fail($value->name.' or '.$value->type.' is invalid.');
        }
    }
}
