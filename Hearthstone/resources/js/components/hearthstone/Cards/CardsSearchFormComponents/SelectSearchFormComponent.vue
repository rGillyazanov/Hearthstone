<template>
    <div class="select-field">
        <label class="font-weight-bold"><slot></slot></label>
        <v-select
                :options="options"
                label="name"
                :reduce="name => name.id"
                :placeholder="placeholder"
                :bind="value"
                @input="$emit('input', $event)"
        ></v-select>
    </div>
</template>

<script>
    import vSelect from 'vue-select';

    export default {
        name: "SelectSearchFormComponent",
        data() {
            return {
                options: []
            }
        },
        props: {
            value: Number,
            apiLink: {
                type: String,
                required: true
            },
            placeholder: String
        },
        components: {
            vSelect: vSelect
        },
        async mounted() {
            await axios.get(this.apiLink).then(response => {
                this.options = response.data.data;
            }).catch(error => {
                console.log(error)
            });
        }
    }
</script>

<style>
    .vs__dropdown-toggle {
        background-color: #fff !important;
        padding: 2px 5px 5px 5px;
    }
    .vs__search::placeholder {
        color: #495057;
    }
</style>