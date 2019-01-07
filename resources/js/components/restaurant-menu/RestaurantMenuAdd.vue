<template>
  <div class="jumbotron" v-if="items">
   <!-- <h2>Add Item</h2>
    <div class="field">
      <input type="file" id="files" ref="files" v-on:change="handleFiles()">
    </div>
    <div class="form-group">
      <label for="inputName">Name</label>
      <input type="text" class="form-control" v-model="items.name" name="name" id="inputName" placeholder="Name" value>
    </div>
    <div class="form-group">
      <label for="inputDescription">Description</label>
      <input type="text" class="form-control" v-model="items.description" name="description" id="inputDescription" placeholder="Description" value>
    </div>
    <div class="form-group">
      <label for="type">Type:</label>
      <select class="form-control" v-model="items.type" id="type" name="type">
          <option>dish</option>
          <option>drink</option>
        </select>
    </div>
    <div class="form-group">
      <label for="inputDescription">Price</label>
      <input type="text" class="form-control" v-model="items.price" name="price" id="inputPrice" placeholder="Price" value>
    </div>
    <div class="form-group">
      <a class="btn btn-primary" v-on:click.prevent="saveItem()">Save</a>

    </div>
    -->

    <form @submit.prevent="submit" class="contact-form">
      <h2>Add Item</h2>

      <div class="field">
        <input type="file" id="files" ref="files" v-on:change="handleFiles()">
      </div>
      <div class="form-group" :class="{ 'form-group--error': $v.name.$error }">
        <input class="form__input form-control" placeholder="Name" v-model.trim="$v.name.$model"/>
      </div>
      <div class="form-group" :class="{ 'form-group--error': $v.description.$error }">
        <input class="form__input form-control" placeholder="Description" v-model.trim="$v.description.$model"/>
      </div>

      <div class="form-group":class="{ 'form-group--error': $v.type.$error }">
        <label for="type">Type:</label>
        <select class="form-control" v-model="items.type" id="type" name="type" v-model.trim="$v.type.$model">
          <option>dish</option>
          <option>drink</option>
        </select>
      </div>


      <div class="form-group" :class="{ 'form-group--error': $v.price.$error }">
        <input class="form__input form-control" placeholder="Price" v-model.trim="$v.price.$model"/>
      </div>

      <button class="btn btn-primary" type="submit" :disabled="submitStatus === 'PENDING'">Add</button>
      <p class="typo__p" v-if="submitStatus === 'OK'">Thanks for your submission!</p>
      <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the fiedl correctly.</p>
      <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
    </form>


  </div>
</template>

<script>
  import { required } from 'vuelidate/lib/validators'
  export default {
    data() {
      return {
        files: [],
        items: {
          name: "",
          description: "",
          type: "",
          price: "",
        },
        submitStatus: null,
        name: "",
        description: "",
        type: "",
        price: "",


      };
    },
    validations: {
      name: {
        required
      },
      description: {
        required
      },
      type: {
        required
      },
      price: {
        required
      },
    },
    methods: {
      submit() {
        console.log('submit!')
        this.$v.$touch()
        if (this.$v.$invalid) {
          this.submitStatus = 'ERROR'
        } else {
          // do your submit logic here
          this.submitStatus = 'PENDING'
          setTimeout(() => {
            this.submitStatus = 'OK'
            this.saveItem();
          }, 500)
        }
      },
      handleFiles() {
        let uploadedFiles = this.$refs.files.files;
        for (var i = 0; i < uploadedFiles.length; i++) {
          this.files.push(uploadedFiles[i]);
        }
        console.log("I am here");
      },
      saveItem: function() {

        this.items.name = this.name ;
        this.items.description = this.description ;
        this.items.price = this.price ;
        this.$emit("create-item", this.items,this.files);

      },

    }
  };
</script>

