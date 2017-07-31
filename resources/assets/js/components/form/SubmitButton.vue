<template>
    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            <button class="btn" :class="btnStyle">{{label}}</button>
        </div>
    </div>
</template>

<script>
    export default {
        /**
         * Properties used to define the submit button logic.
         * @param {string} btnStyle - The name of the bootstrap class used to style the button. Btn is not necessary.
         * @param {string} label - The text that will appear on the button as a label.
         */
        props: ['btnStyle', 'label']
    }
</script>
