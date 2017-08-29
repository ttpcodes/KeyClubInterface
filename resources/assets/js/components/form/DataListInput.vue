<template>
    <div>
        <div class="form-group">
            <label class="col-md-4 control-label">Home Page Links</label>
            <div class="col-md-6">
                <input name="members[]" type="text" class="form-control" autofocus :list='datalist'>
            </div>
        </div>
        <div v-for="i in links" class="form-group">
            <div class="col-md-offset-4 col-md-6">
                <input name="members[]" type="text" class="form-control" autofocus :value="i[0]" :list='datalist'>
            </div>
        </div>
        <div v-for="i in items" class="form-group">
            <div class="col-md-offset-4 col-md-6">
                <input name="members[]" type="text" class="form-control" autofocus :list='datalist'>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-4 col-md-8">
                <button class="btn btn-success" v-on:click="add($event)">Add Member</button>
                <button class="btn btn-danger" v-on:click="remove($event)">Remove Member</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                items: 0,
                links: []
            }
        },
        methods: {
            add: function(e) {
                this.click(e);
                this.items++;
            },
            click: function(e) {
                e.preventDefault();
            },
            remove: function(e) {
                this.click(e);
                if (this.items > 0) {
                    this.items--;
                }
            }
        },
        mounted: function() {
            if (this.values) {
                let array = this.values.split(",");
                for (let i = 0; i < array.length; i++) {
                    if (i % 2 == 0) {
                        this.links.push([array[i], array[i + 1]]);
                    }
                }
            }
        },
        props: ['datalist', 'values']
    }
</script>
