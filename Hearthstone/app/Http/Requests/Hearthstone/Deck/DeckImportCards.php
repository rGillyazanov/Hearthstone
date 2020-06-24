<?php

namespace App\Http\Requests\Hearthstone\Deck;

use App\Models\Hearthstone\Card;
use Illuminate\Foundation\Http\FormRequest;

class DeckImportCards extends FormRequest
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
            'cardsId' => ['json', function ($attribute, $value, $fail) {
                $this->checkCardsInDeck($attribute, $value, $fail);
            }]
        ];
    }

    /**
     * Проверяет, существование id карт в базе данных
     * @param $attribute
     * @param $value
     * @param $fail
     */
    private function checkCardsInDeck($attribute, $value, $fail) {
        $idOfCards = explode(",", str_replace ('[', '', (str_replace (']', '', $value))));

        $card = Card::whereIn('dbfId', $idOfCards)->first();
        if (!$card) {
            $fail($attribute.' fail.');
        }
    }
}
