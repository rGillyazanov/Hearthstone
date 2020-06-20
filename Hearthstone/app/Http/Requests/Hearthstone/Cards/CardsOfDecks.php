<?php

namespace App\Http\Requests\Hearthstone\Cards;

use Illuminate\Foundation\Http\FormRequest;

class CardsOfDecks extends FormRequest
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
            'cost' => 'nullable|min:0|max:10',
            'format' => 'min:1|max:2'
        ];
    }

    /**
     * Add parameters to be validated
     *
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        return array_replace_recursive(
            parent::all(),
            $this->route()->parameters()
        );
    }
}
