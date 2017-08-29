<template>
    <div class="form-group">
        <label :for="name" class="col-md-4 control-label">{{label}}</label>

        <div class="col-md-6">
            <input :id="name" type="time" class="form-control" :name="name" :placeholder="dateString" :required="required">
        </div>
    </div>
</template>

<script>
    export default {
        /**
         * Properties used to define the date time input.
         * @param {string} label - The label for the input that will appear on the form. Required.
         * @param {string} name - The name of the input that the server will receive. Required.
         */
        data: function() {
            return {
                date: new Date(),
                dateString: null
            }
        },
        mounted() {
            this.dateString = `${this.date.getHours()}:${this.date.getMinutes() }`;
        },
        props: ['label', 'name', 'required']
    }
</script>
