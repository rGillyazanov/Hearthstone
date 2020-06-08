<template>
    <div>
        <label class="font-weight-bold" for="cardName"><slot>Название карты</slot></label>
        <input type="text" class="form-control" id="cardName" aria-describedby="nameCard" placeholder="Введите название карты" :bind="value" @input="$emit('input', $event.target.value)">
    </div>
</template>

<script>
    export default {
        name: "CardSearchNameComponent",
        props: ['value']
    }
</script>