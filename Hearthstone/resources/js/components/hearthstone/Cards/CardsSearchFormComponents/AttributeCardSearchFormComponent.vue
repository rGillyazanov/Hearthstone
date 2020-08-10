<template>
    <div class="input-group mt-3">
        <input type="range" class="custom-range" min="0" max="10" :value="value" :bind="value" @input="$emit('input', $event.target.value)">
        <small class="form-text text-muted">
            <slot name="name-attribute"></slot>: {{ changedValue(value) }}
            <div class="form-check">
                <input class="form-check-input" type="checkbox" :bind="checked" @change="$emit('change', $event.target.checked)">
                <label class="form-check-label" style="margin-top: 2px">
                    <slot name="search-attribute"></slot>
                </label>
            </div>
        </small>
    </div>
</template>

<script>
    export default {
        name: "AttributeCardSearchFormComponent",
        props: {
            value: Number,
            checked: Boolean
        },
        methods: {
            changedValue(value) {
                return value === 10 ? '10+' : value;
            }
        }
    }
</script>

<style scoped>

</style>