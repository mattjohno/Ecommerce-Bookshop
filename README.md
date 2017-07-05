# Ecommerce-Bookshop
"HTML5, PHP, SQL, Foundation 6, JavaScript, JQuery Alphanum"

## Installation

1. Import database located in the SQL file named 'a2029624_tech_reader' to your DBMS
2. Update the database connection settings in 'include/config.php' to connect with the database
3. Load the site

## Test Accounts

* Customer Login in with demo data. 
    * Email: test@test.com 
    * Password: password
* Or Register as a new user

* Admin Login in with demo data. 
    * Email: admin@admin.com
    * Password: Admin17

## Client Side Features

### Registration Form Validation

*	First Name: Must be at least 3 characters
*	Last Name:  Must be at least 3 characters
*	Address:  	Must be at least 3 characters
*	City:     	Must be at least 2 characters
*	Postcode:   Must be 4 digits and numbers only
*	Phone:    	Maximum of 10 digits only and only numbers.
*	Email:      Email must be valid by including a @ and . 
*	Password: 	Password (must be 6 to 8 characters)
*	Password:   Password 1 must match password 2

### Customer and Admin Login

* Email and Password fields connot be left black

### Product Form Validation

*	Product Code:	Must be at least 3 characters
*	Author:	Must be at least 3 characters
*	Title:	Must be at least 3 characters
*	Year:	Must be 4 digits and numbers only
*	Publisher:	Must be at least 3 characters
*	Price:	Must be numbers only
*	Image:	Must be jpg, jpeg, png, gif, bmp image only

## Server Side Features

* Email
    * Check Database for existing email.
    * Encrypt user’s password with MD5 function.
    * Insert customer details into database.
    * Return Success or Error message to web browser.
* Verify
    * Identify Invalid login in attempts.
    * Create user Session if login valid.
    * Return Success or Error message to web browser.
* End Session
    * Log users out.
* Update
    * Insert products to customers shopping cart when instructed from the catalogue.
    * Retrieve customers cart details from database and display in customer’s cart.
* Delete
    * Delete items from customer’s cart.
*	Update
    * Update customer details in the database.
* Insert
    * Insert confirmed orders into the database to be show in the view purchases page.
    * Delete items from shopping cart.
* Update / insert
    * Allow admin to update and insert products into the catalogue.
* User access
    * If admin or users are not signed in they can only access the parts of the site that don’t require a login.
    
