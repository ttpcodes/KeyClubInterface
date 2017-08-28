<template>
    <div class="form-group">
        <label :for="name" class="col-md-4 control-label">{{label}}</label>

        <div class="col-md-6">
            <input :id="name" :name="name" type="file" required></input>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['label', 'name']
    }
</script>
