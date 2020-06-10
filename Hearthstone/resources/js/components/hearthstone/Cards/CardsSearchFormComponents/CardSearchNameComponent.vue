<template>
    <div>
        <label class="font-weight-bold" for="cardName"><slot name="label">Название карты</slot></label>
        <input type="text" class="form-control" :class="{'is-invalid': $v.value.$error}" @blur="$v.value.$touch()" id="cardName" aria-describedby="nameCard" placeholder="Введите название карты" :bind="value" @change="$emit('input', $event.target.value)">
        <div class="invalid-feedback" v-if="!$v.value.minLength">
            Минимальное количество символов {{ $v.value.$params.minLength.min }}. Количество символов в строке: {{ value.length }}.
        </div>
    </div>
</template>

<script>
    import { minLength } from 'vuelidate/lib/validators';

    export default {
        name: "CardSearchNameComponent",
        data() {
            return {
                isError: false
            }
        },
        props: ['value'],
        validations: {
            value: {
                minLength: minLength(2)
            }
        }
    }
</script>