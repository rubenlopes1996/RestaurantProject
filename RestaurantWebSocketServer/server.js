/*jshint esversion: 6 */

var app = require('http').createServer();

// Se tiverem problemas com "same-origin policy" deverão activar o CORS.

// Aqui, temos um exemplo de código que ativa o CORS (alterar o url base) 

// var app = require('http').createServer(function(req,res){
// Set CORS headers
//  res.setHeader('Access-Control-Allow-Origin', 'http://---your-base-url---');
//  res.setHeader('Access-Control-Request-Method', '*');
//  res.setHeader('Access-Control-Allow-Methods', 'UPGRADE, OPTIONS, GET');
//  res.setHeader('Access-Control-Allow-Credentials', true);
//  res.setHeader('Access-Control-Allow-Headers', req.header.origin);
//  if ( req.method === 'OPTIONS' || req.method === 'UPGRADE' ) {
//      res.writeHead(200);
//      res.end();
//      return;
//  }
// });

// NOTA: A solução correta depende da configuração do próprio servidor, 
// e alguns casos do próprio browser.
// Assim sendo, não se garante que a solução anterior funcione.
// Caso não funcione é necessário procurar/investigar soluções alternativas

var io = require('socket.io')(app);

var LoggedUsers = require('./loggedusers.js');

app.listen(8080, function(){
    console.log('listening on *:8080');
});

// ------------------------
// Estrutura dados - server
// ------------------------

// loggedUsers = the list (map) of logged users. 
// Each list element has the information about the user and the socket id
// Check loggedusers.js file

let loggedUsers = new LoggedUsers();

io.on('connection', function (socket) {
    console.log('client has connected (socket ID = '+socket.id+')' );

    socket.on('msg_from_client', function (msg, userInfo) {
        if (userInfo === undefined) {
            io.sockets.emit('msg_from_server', 'User Unknown: "' + msg + '"');
        } else {
            io.sockets.emit('msg_from_server', userInfo.name +': "' + msg + '"');
        }
    });

    

    socket.on('user_enter', function (user) {
        if (user !== undefined && user !== null){
            socket.join('department_' + user.department_id);
            loggedUsers.addUserInfo(user, socket.id);
        }

    });
    
    socket.on('user_exit', function (user) {
        if (user !== undefined && user !== null){
            socket.leave('department_' + user.department_id);
            loggedUsers.removeUserInfoByID(user.id);
        }
    });
    
    socket.on('msg_from_client_dep', function (msg, userInfo) {
        if (userInfo !== undefined) {
            let channelName = 'department_' + userInfo.department_id;
            io.sockets.to('department_'+userInfo.department_id).emit('msg_from_server_dep',
            userInfo.name +': "' + msg + '"');
        }
    });

    socket.on('privateMessage', (msg, user, from)=>{
        const userInfo = loggedUsers.userInfoByID(user.id);
        if(userInfo){
            io.to(userInfo.socketID).emit('privateMessage', from, msg);
        } else {
            socket.emit('privateMessage_unavailable', user);
        }
    })

    socket.on('msg_from_client_to_admin', function (desc, msg, userInfo) {
        //find an admin
        var admins = loggedUsers.userInfoOfAdmin();
        console.log(admins);
        if (userInfo === undefined) {
            io.sockets.emit('msg_from_server', 'User Unknown: "' + msg + '"');
        } else {
            //io.sockets.emit('msg_from_server', userInfo.name +'\n Desc: "' + desc + '"'+',\n Msg: "' + msg + '"');
            for (admin of admins) {
                socket.broadcast.to(admin.socketID).emit('privateMessage', userInfo.name + ' - ' + userInfo.type, desc, msg);
            }
            
        }
    });

    socket.on('user_saved', user=>{
        if(user){
            socket.broadcast.emit('user_changed', user);
        }
    })



})

