<p align="center"><a href="https://fergus.com" target="_blank"><img src="https://static.fergusapp.com/build/c4eb7cdc1559eef102b110df9ffef73b.svg" width="400"></a></p>


## Pre-requisites

1. [Docker for Mac](https://docs.docker.com/desktop/mac/install/)

## What docker containers are used
There are two containers that are used for this application; Nginx and PHPFPM.

You can file all the files relating to docker in the {root}/.docker folder.

## Getting Started

To bring the application containers up you will need to run the command below. 
The first time you run this it will take a little while so go make yourself a cup of coffee and relax for a bit. 

``./fergus.sh up``

To bring the application containers do run this command.
``./fergus.sh down``

To install all the composer packages required for this project run this command.
``./fergus.sh composer install``


## Testing
Tests are broken down into 2 different types; Feature tests or e2e test and Unit tests.
### Feature / E2E
To run all the Feature tests run this command
``./fergus.sh test::e2e``

### Unit 
To run all the Unit tests run this command
``./fergus.sh test::unit``

## Code fixing 
``./fergus.sh pint``

## Project Folders and Files
Below is a list of notable folders for you to have a look to get a good understanding of the application

### Routes
Folder : {root}/routes

Being that this is an api application the only file that is used is the api.php

### Tests
Folder : {root}/tests

Within this folder you will find a folder for the Feature tests and one for the Unit Tests

### Requests
Folder : app/Http/Requests

Laravel requests are a class that get injected into a controller function in the request pipeline, 
they are used, for the most part, as a way to preform validation in the request pipeline before hitting the controller  function.  

###Controllers
Folder : app/Http/Controllers

###Services
Folder : app/Services

###Repositories
Folder : app/Repositories

###Resources
Folder : app/Resources

JsonResource are used a bit dto's with a few helper methods to do some voodoo magic transformations. 
###Contracts
Folder : app/Contracts

