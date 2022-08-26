## PHP and webserver
1. PHP Version: 8.0 or higher
2. Webserver: I used apache.
## Setting up
Please run `composer update` command in project root folder to download the dependencies and setting up the project. Needless to say that composer must be installed on your local machine.
## DB
1. MySQL: Please create a mysql database and set PDO credentials in .env (Which must be created) file. You can use .env.example file in project root folder to see how to set your .env file.
2. Migration: Please run `php migration.php` in project root folder to migrate the database.
## Starting The Project
In project folder please run `php -S localhost:8000` to run the application. If port 8000 is occupied please change the port number for provided api links. <br />
I used <span style="color: green">PostMan</span> to call api links.
## Tasks and related links
1. The code has to read files that are in different formats (csv, json) and contain various cars related data: <br />
    a. Method: GET.  <br />
    b. Link: http://localhost:8000/cars/import <br />
    c. Note: This api call truncates car table. If you want to keep data please remove `$objCar->getDB()->truncateTable('car');` in <span style="color: green">import</span> method of  <span style="color: green">CarsController</span> (Line 16).  <br />
    d. Note 2: Since The task insist on keeping every data, unvalidated inputs are saved az `null`. If you want to skip row with unvalidated data completely; please uncomment lines 139 to 141 in <span style="color: green">Car</span> model.
2. Endpoints to retrieve the information saved in the database:  <br />
   a. Method: GET - Link: http://localhost:8000/cars - Remark: It will retrieve all cars. <br />
   b. Method: GET - Link: http://localhost:8000/car/report/by/brand?brand=Fiat - Remarks: Please replace (Fiat) with preferred brand name to retrieve cars with named brand.  <br />
   c. Method: GET - LInk: http://localhost:8000/car/report/by/year?year=2011 - Remarks: Please replace (2011) with preferred year to retrieve cars created in that year.
3. Endpoint for creating cars: <br />
    a. Method: POST <br />
    b. Link: http://localhost:8000/cars <br />
    b. JSON Structure: <br />
   {
   "Car Brand": "Mercedes Benz",
   "Car Model": "S500",
   "Car year": "2022",
   "Location": "Germany",
   "License plate": "GR 75 Z 222",
   "Car km": "1",
   "Number of doors": "4",
   "Number of seats": "4",
   "Fuel type": "Petrol",
   "Transmission": "Automatic",
   "Car Type Group": "Car",
   "Car Type": "Luxury car",
   "Inside height": "59.20",
   "Inside length": "76.90",
   "Inside width": "59.20"
   }
    <br />
    d. Note: Please don't forget to set `Accept` header to `application/json`
## Running tests
1. Please run `./vendor/bin/phpunit` in project root folder to see the test results.
2. Please consider that since I was forbid to use Laravel, my tests are not ideal. This is my first experience with phpunit out of a laravel or lumen project.