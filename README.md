# vehicle
This is simple symphony example (using import data from json file, ajax call, twig template and doctrine orm ) 

1)Create entities with following schema:

-VehicleType: 
  code
  description
  
-Make: 
  code, 
  description, 
  type - should have OneToMany relationship to VehicleType entity
  
-Model: 
  description, 
  type - should have OneToMany relationship to VehicleType entity, 
  make code (group property in models.json) should have OneToMany relationship to Make entity
  
-SearchLog: 
  vehicle type, 
  make abbr, 
  number of models found in database, 
  request time, 
  ip address, 
  user agent
  
2.)Create fixtures and load data to database from files assets/resources:
vehicle_types.json
makes.json
models.json

3)Create "/" route
You will need to display html page an show list of vehicle types alphabetically. This list should have a link to makes route (#4).

4)Create "/makes/{type}" route
You need to display html page with dropdown that will show list of makes for selected vehicle type.
If make selected from this dropdown you will need send ajax request to load json data from model route (# 5) and display list of model underneath the makes dropdown. Or display message if no models available,

5)Create "/models/{type}/{makeCode}" route to return json list of models for specific make and vehicle type

6)You should log all request for models route to database (SearchLog entity)
