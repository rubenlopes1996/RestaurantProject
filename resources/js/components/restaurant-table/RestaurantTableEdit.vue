<template>
    <div class="jumbotron" v-if="tables">
        <h2>Edit Table</h2>
        <div class="form-group">
            <label for="tableNumber">Table Number</label>
            <input type="text" class="form-control" v-model="tables.table_number" name="table_number" id="table_number" placeholder="Table number" value="" />
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveTable()">Save</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["tables"],
        data() {
            return {
                table: {
                    table_number: ""
                }
            };
        },
        methods: {
            saveTable: function() {
                this.$emit("save-edited");
            }
        }
    }
</script>

