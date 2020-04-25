[unit-community.com](https://unit-community.com "UNIT Community") is an open source forum that was built for UNIT Factory students.

## Installation

### Step 1.

> To run this project, you must have PHP 7.3 and MySQL installed as a prerequisite.
Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
git clone https://github.com/Navalag/unit-community.git
cd unit-community && composer install && npm install
php artisan unit-community:install
npm run dev
```

### Step 2.

Open project locally! Visit `http://unit-community.test/threads` to create a new account and publish your first thread.

By default there are 2 admins - JohnDoe and JaneDoe. To use them just register user with these names.
You can configure admins in .env file - 'ADMIN_LIST'. 
