# scandiwebapp test asignment Charbel Abou Younes



###This project is inspired by modern php frameworks like laravel. Everything is implemented from scratch
The project is structured using the MVC pattern
###You can run this project locally :
* Download the project folder
* Run docker-compose up (To start both backend and database services)
* Run docker container exec -it scandiweb_backend_demo sh (To access the backend service)
* Inside the backend service run composer install and run php migrations.php (the last comand will create the database and will populate it with required data)
* Navigate to localhost:8080 (You should be able to see the website)