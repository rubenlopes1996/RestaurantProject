<template>
    <div class="jumbotron" v-if="items">
        <h2>Edit Menu</h2>
        <div class="field">
            <input type="file" id="files" ref="files" v-on:change="handleFiles()">
        </div>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input type="text" class="form-control" v-model="items.name" name="name" id="inputName" placeholder="Name" value="" />
        </div>
        <div class="form-group">
            <label for="inputDescription">Description</label>
            <input type="text" class="form-control" v-model="items.description" name="description" id="inputDescription" placeholder="Description" value="" />
        </div>
         <div class="form-group">
            <label for="type">Type:</label>
            <select class="form-control" v-model="items.type" id="type" name="type">
                    <option> dish </option>
                    <option> drink </option>
            </select>
        </div>
           <div class="form-group">
            <label for="inputDescription">Price</label>
            <input type="text" class="form-control" v-model="items.price" name="price" id="inputPrice" placeholder="Price" value="" />
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveItem()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
        </div>
    
    </div>
</template>

<script>
    export default {
        props: ["items"],
        data() {
            return {
            files: [],
        };
    },
    methods: {
        handleFiles() {
            let uploadedFiles = this.$refs.files.files;
            for (var i = 0; i < uploadedFiles.length; i++) {
                this.files.push(uploadedFiles[i]);
            }
            this.upload();
        },
        upload() {
            for (let i = 0; i < this.files.length; i++) {
                if (this.files[i].id) {
                continue;
                }
                let formData = new FormData();
                formData.append("file", this.files[i]);

                axios.post("api/menu-photo/" + this.items.id, formData, {
                    headers: {
                    "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    this.items.photo_url = response.data.photo;
                })
                .catch(error => {
                    console.log(error.response.data.message);
                });
            }
        }, 
        saveItem: function() {
            this.$emit("save-item");
        },
        cancelEdit: function() {
            this.$emit("cancel-edit");
        }
    }
}
</script>

