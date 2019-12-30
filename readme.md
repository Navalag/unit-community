## Project description

A forum is a deceptively complex thing. Sure, it's made up of threads and replies, but what else might exist as part of a forum? What about profiles, or thread subscriptions, or filtering, or real-time notifications?

All of these features, and not only them, are implemented in this project. 

#### Used technologies:
- Laravel
- Vue.js
- Algolia search
- Trix editor (WYSIWYG)
- reCAPTCHA
 
## Installation

Clone the repository
```
git clone https://github.com/Navalag/forum.git
```

Install dependencies
```
composer install
npm install
```

Copy .env.example to .env and update database credentials (also you have to create new database to specify its name in .env).
```
cp .env.example .env
php artisan key:generate
```

Run migration and seeder
```
php artisan migrate
php artisan db:seed
```

Compile js and css files
```
npm run dev
```

Run server
```
php artisan serve
```
