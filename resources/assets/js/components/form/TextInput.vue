<template>
    <div class="form-group" :class="error ? 'has-error' : ''">
        <label :for="name" class="col-md-4 control-label">{{label}}</label>

        <div class="col-md-6">
            <input :id="name" type="text" class="form-control" :name="name" :value="value" :required="required" autofocus>
        </div>

        <span v-if="error" class="help-block">
            <strong>{{error}}</strong>
        </span>
    </div>
</template>

<script>
    export default {
        /**
         * Properties used to define the text input.
         * @param {string} error - The text to use for displaying an error with form validation.
         * @param {string} label - The label for the input that will appear on the form. Required.
         * @param {string} name - The name of the input that the server will receive. Required.
         * @param {boolean} required - Whether or not this form input should be marked as required.
         * @param {string} value - The initial value of the text input.
         */
        mounted() {
            if (this.error) {
                console.log("Error passed to input. Displaying error...");
            }
        },
        props: ['error', 'label', 'name', 'required', 'value']
    }
</script>
