<template>
    <div class="jumbotron" v-if="table">
        <h2>Add Table</h2>
        <div class="form-group">
            <label for="tableNumber">Table Number</label>
            <input type="text" class="form-control" v-model="table.table_number" name="table_number" id="table_number" placeholder="Table number" value="" />
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveTable()">Save</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                table: {
                    table_number: ""
                }
            };
        },
        methods: {
            saveTable: function() {
                this.$emit("save-table", this.table);
            }
        }
    }
</script>

