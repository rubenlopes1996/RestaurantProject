<template>
    <div style="margin-top:200px">
        <div class="container">
            <div class="row">
                <form role="form" id="contact-form" class="contact-form">
                    <h4>Contact an Administrator</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="desc" autocomplete="off" id="desc" placeholder="Short description" v-model="desc">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control textarea" rows="3" name="Message" id="Message" placeholder="Message" v-model="msgGlobalText"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn main-btn pull-right" v-on:click.prevent="sendMessageTo()">Send a message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
module.exports = {
    data: function() {
        return {
            msgGlobalText: "",
            msgGlobalTextArea: "",
            desc: "",
            user: this.$store.state.user
        }
    },
    methods:{
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
				/*let msg = window.prompt('What do you want to say to "' + this.user.name + '"');
				console.log('Sending Message "' + msg + '" to "' + this.user.name + '"');

				// CODE TO SEND MESSAGE USING WEB SOCKETS
				this.$socket.emit('privateMessage', msg, this.user, this.$store.state.user);
				// Complete ...
				
                this.$toasted.show('Message "' + msg + '" sent to "' + this.user.name + '"');*/
                
                this.$socket.emit('msg_from_client_to_admin',  this.desc, this.msgGlobalText, this.$store.state.user);
                this.$toasted.success('Your message has been sent.', {duration: 3000, position: 'top-center'});
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
