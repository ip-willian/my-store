
# My-Store

A simple symfony 5.4 website to manage orders

## Installation


```bash
  clone repository
  run composer Install

  Create a database
  Edit .env file adding the database url  

  run php bin/console doctrine:migrations:migrate

  run symfony server:start
  
  inside public folder, create a new folder 
  called uploads and inside uploads create a folder named labels - this directories will allow to upload the label for the shipping department
```

## Creating users for testing

open browser and access endpoint http://localhost:8000/register

Picking
e-mail: picking@mystore.com
password: 123456

Shipping
e-mail: shipping@mystore.com
password: 123456

Management
e-mail: manager@mystore.com
password: 123456

## Testing API

In project root folder you will find a postman json file named "my-store.postman_collection.json" that allow you to configure all endpoints in your Postman app

## Note
In this proposed exercise, I went for the simplest possible approach, using shipping information directly in order and using some jQuery libs like Data Tables to shorten the process of pagination, filtering and sorting. Although this might not be the most elegant solution, it achieves the goal.     