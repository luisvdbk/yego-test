# Yego test

### Installation
- Clone the repo
- `cd` to the project folder
- Run `composer install`
- If you don't have a `.env` file after installing the project run `cp .env.example .env`
- Run `php artisan key:generate`
- Run `cp .env .env.testing` (we will be using this for the testing database)
- Change the DB related configurations on the .env files. This project needs a MySQL database for both local and testing databases, due to the use of sql functions not available on sqlite
- Set up `YEGO_API_URL=https://www.rideyego.com/api/v1/city/1` and `YEGO_API_KEY=your_api_key` on the `.env` file
- Run `php artisan config:cache`
- Run `php artisan migrate`

### Part 1 - Data acquisition
The command `php artisan vehicles:sync` collects available vehicles data and stores it on the database. It has been set up on the scheduler to run every minute. It can also be run manually to collect the data in place. If the vehicles data is upated according to the requested criteria, rides will be created on the database as well.

You can go to `/rides` to see a list of rides

### Part 2 - Data processing
The command `php artisan rides:display-stats` can be used to display rides-related stats from the console. You can see the list of options for this command by running `php artisan rides:display-stats -h`. `-H` options is being used rather than `-h` to avoid clashing with help option.

If you need some test data to check this command you can run `php artisan migrate:refresh --seed`

### Tests
Run `php artisan migrate --env=testing`
Run `php artisan test`
