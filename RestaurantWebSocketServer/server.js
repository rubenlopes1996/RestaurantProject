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
            socket.join('group_' + user.type);
            loggedUsers.addUserInfo(user, socket.id);
        }
    });
    
    socket.on('user_exit', function (user) {
        if (user !== undefined && user !== null){
            socket.leave('group_' + user.type);
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
        //var admins = loggedUsers.userInfoOfAdmin();
        //console.log(admins);
        if (userInfo === undefined) {
            io.sockets.emit('msg_from_server', 'User Unknown: "' + msg + '"');
        } else {
            //io.sockets.emit('msg_from_server', userInfo.name +'\n Desc: "' + desc + '"'+',\n Msg: "' + msg + '"');
            //for (admin of admins) {
                socket.broadcast.to('group_manager').emit('privateMessage', userInfo.name + ' - ' + userInfo.type, desc, msg);
            //}
            
        }
    });

    socket.on('paidInvoice_to_admins', function (userInfo, invoice_table_number, invoice_id) {
        if (userInfo != undefined) {
            socket.broadcast.to('group_manager').emit('socketRefresh', invoice_id);
            socket.broadcast.to('group_manager').emit('freshPaidInvoices', userInfo.type + ': ' + userInfo.name, invoice_table_number, invoice_id);
             
        }
    });

    socket.on('terminatedMeal_to_cashiers', function (userInfo, meal_table_number, meal_id) {
        if (userInfo != undefined) {
            socket.broadcast.to('group_cashier').emit('socketRefreshMeals', meal_id);
            socket.broadcast.to('group_cashier').emit('freshTerminatedMeals', userInfo.type + ': ' + userInfo.name, meal_table_number, meal_id);
            socket.broadcast.to('group_manager').emit('socketRefreshMeals');
             
        }
    });

    socket.on('orderAdded_to_cooks', function (order_id) {
        socket.broadcast.to('group_cook').emit('socketRefreshOrders');
        socket.broadcast.to('group_cook').emit('freshOrder', order_id);
    });

    socket.on('orderChangedState', function() {
        socket.broadcast.to('group_cook').emit('socketRefreshOrders');
    });

    socket.on('orderPrepared_to_waiter', function(waiter_Id) {
        const waiter = loggedUsers.userInfoByID(waiter_Id);
        io.to(waiter.socketID).emit('socketRefreshPCOrders');
        io.to(waiter.socketID).emit('freshOrderPrepared');
    });


    socket.on('user_saved', user=>{
        if(user){
            socket.broadcast.emit('user_changed', user);
        }
    })



})

