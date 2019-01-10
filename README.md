# RestaurantProject
The main purpose of the order system is to improve the efficiency of the communication between
managers, waiters, kitchen personal (cooks) and cashiers of a restaurant. Each time a waiter takes
an order, the required items of that order are passed on as fast as possible to the kitchen. Also, the
waiter must be notified as soon as the orders are completed in the kitchen, and the cashier as soon
as the meal ends and the payment is due. To ensure the maximum efficiency, the communication
within the application should happen in real time.
To simplify the scenario, each order is comprised of only one item (dish/food or drink). Drinks and
dishes have the same flow, they are all prepared by cooks.

#Run project
1ºRun composer install
2ºnpm install on the base of the project
3ºRun npm install inside the folder RestaurantWebSocketServer
4ºRun the artisan migrate
5ºComposer require laravel/passport
6ºphp artisan migrate
7ºphp artisan passport:install
8ºphp artisan db:seed
