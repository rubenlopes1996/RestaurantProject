<template>
    <div style="margin-top:200px">

        <form @submit.prevent="submit" class="contact-form">
            <h4>Contact an Administrator</h4>

            <div class="form-group" :class="{ 'form-group--error': $v.msgGlobalText.$error }">
                <input class="form__input form-control" placeholder="Short description" v-model.trim="$v.msgGlobalText.$model"/>
            </div>

            <div class="form-group" :class="{ 'form-group--error': $v.msgGlobalTextArea.$error }">
                <input class="form__input form-control" placeholder="Message" v-model.trim="$v.msgGlobalTextArea.$model"/>
            </div>
            <button class="btn main-btn" type="submit" :disabled="submitStatus === 'PENDING'">Submit!</button>
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
                msgGlobalText: '',
                msgGlobalTextArea:'',
                submitStatus: null,
            }
        },
        validations: {
            msgGlobalText: {
                required
            },
            msgGlobalTextArea:{
                required
            }
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
                        this.sendMessageTo();
                    }, 500)
                }
            },
            sendGlobalMsg: function(){
                if(this.$store.state.user){
                    this.$socket.emit('msg_from_client',  this.msgGlobalText, this.$store.state.user);
                    this.$toasted.show('Msg enviada para server');
                } else {
                    this.$toasted.error('User is not logged in');
                }
            },
            sendDepMsg: function(){
                if(this.$store.state.user){
                    this.$socket.emit('msg_from_client_dep',  this.msgDepText, this.$store.state.user);
                } else {
                    this.$toasted.error('User is not logged in');
                }
                this.msgDepText ="";
            },
            sendMessageTo: function(){


                this.$toasted.success('Your message has been sent.', {duration: 3000, position: 'top-center'});
                this.$socket.emit('msg_from_client_to_admin',  this.msgGlobalText, this.msgGlobalTextArea, this.$store.state.user);

            }
        },
        sockets:{
            msg_from_server_dep(dataFromServer){
                this.msgDepTextArea = dataFromServer + '\n' + this.msgDepTextArea;
            },
            privateMessage_unavailable(destUser){
                this.$toasted.error('User "' + destUser.name + '" is not available');
            }
        }
    }



</script>