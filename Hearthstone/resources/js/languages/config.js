import Lang from 'lang.js';

// Выполните команду php artisan export:messages-flat
import hearthstone from "./hearthstone";
const messages = hearthstone;

export default new Lang( { messages, locale: 'ru', fallback: 'ru' } );
