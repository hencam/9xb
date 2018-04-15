## requirements to run the test

The tech test is designed to run on a LAMP stack, I’m using PHP 7.2.4 and MySQL 5.7.21 (not in strict mode).  The Database is named “9xb” and the credentials are “root” with a blank password.

## why I chose laravel

I chose to use Laravel 5.6 as it’s one of (if not the) most popular MVC frameworks at the moment, and I have to admit, it gives you some really nice tools to do this kind of thing quickly and easily.  It’s also simple to follow through and pretty much forces you to do things in a readable way.  I’m also still familiarising myself with it, so this was a good test for me.  I found it really enjoyable and useful, I used resources such as the laravel docs, laracasts and of course google and stack overflow, but it’s beginning to click into place and I’m looking forward to getting my teeth into much bigger projects.

## database stuff

The database tables were built with laravel migrations (php artisan make:model Employee -m) to generate the model and migration files and I used seeders so I could quickly refresh if I needed to (for example whilst deleting roles and employees).  The actual structure I kept very simple - the only normalisation really required was splitting the roles into their own table so you can link to them from the employee records by their id.  Once you’ve created the database you should be able to build the tables it requires by simply entering the command php artisan migrate:refresh --seed

## how to log in

The overall tech test is protected behind a login - this was generated with just one command in laravel (php artisan make:auth) which I then slightly tweaked to not allow new users to register.  The password reminder doesn’t work as I suspect I need to configure the outgoing mail server, but I ignored this for the tech test.  The login for 9xb is: admin@9xb.com / password123
If you want to log in as me, you can use: neil.whitaker@gmail.com / password123

## development choices

For the actual process of managing employees and roles, I split these into their own separate pages - I’d imagine in a “live” system the person responsible for adding and editing roles might be different to the person who manages employees.  Either way, it was simpler and made more sense to have these in their own pages.

The navigation between the two pages are using default bootstrap buttons - I concentrated on functionality rather than UX and style at this moment. :)

I again used a laravel helper to make the basic CRUD controller (php artisan make:controller EmployeeController --resource) the --resource tells laravel to scaffold the CRUD functions for you.

Once I’d got the edit / update working it was simple to build the ‘add’ functionality.

Then for the roles it was pretty much what I’d already done for the employees.  The logic for preventing more than 4 employees assigned to the same role is performed by the section of template that outputs the role select drop-down - it’s passed a list of roles and how many employees are assigned to it.  The only consideration to remember here is if you are editing an employee then you don’t take that record into account - eg: you are adding a new employee, you need to make sure there aren’t 4 other employees already with that role.  When editing an employee, you need to make sure there aren’t 4 other employees NOT INCLUDING the one you’re editing with that role.

Speaking of the limits for number of employees and roles, I put these values into a config file (in config/constants.php) so they can easily be amended as and when requirements change.  You simply read the values with (\Config::get('constants.varname'))

I’m aware I haven’t strictly followed the brief as per the form html, but having all fields immediately editable on one page and also having to tick a box and then submit to delete, along with having free-form text input on adding a new employee’s role, I thought I should try and improve the UX here.

## what would I improve?

What would I improve?  Some styling would be nice.  Some of the queries for the roles and employees could be tidied up and maybe standardised and not pretty much duplicated.  The weird thing I had to do where the delete link has to be an onClick which submits a hidden form (which I had to hide in a separate TD so it didn’t push the trash icon down!) could be tidied up…  I didn’t really understand the format of the email address too (mail+j+strummer@9xb.com) - was it urlencoded so the +’s are spaces?  That still didn’t seem to make sense, so I left them as is.

## last minute thoughts and additions (or... I was in the shower when I suddenly remembered...)

Two things I just added at the last moment: a check on the create employee submission controller function to make sure there aren’t already 10 employees - this is in case someone manually browses to the add employee url (bypassing the hidden link - never trust users!)  Secondly I added a “view employee record” view which doesn’t show much more info than the employee list, but just to show that the Read bit of CRUD is done.

## how long did this take?

The solution took me around two and a half to three hours, not including time intially spent fighting with laravel and composer.
