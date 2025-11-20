## A proof of concept Webstore built using the latest techniques of Laravel 12, Inertia 2, Vue 3.5 (composition/TS), and Tailwind 4

> Please view the [wiki](https://github.com/DignitySAMP/vilt-webshop/wiki) to see preview screenshots and feature / architectural explanations.

Using Laravel Fortify for authentication, Wayfinder BETA to bridge Laravel controllers and routers to the front-end (as a replacement of ziggy.js) and Toastify-3 for toasts. This project aims to showcase my current prowess using the VILT stack.

This features everything from n+1-safe filtering, shopping cart management, categorized item management (stock counts) which is tied to extensive supplier chain management (posting orders to supplier info, through address and contact relations), payments using Laravel Stripe (and safe storage thereof, using k-anonimity) and much more.

### Installation
```
npm install && composer install

cp .env.example .env ## copy .env file
## important: this project heavily relies on e-mail traffic. by default it is configured to output to logs.

php artisan migrate ## click 'yes' to auto generate the database
## alternatively: php artisan migrate --seed to start with starter items, categories, suppliers, ...

php artisan storage:link ## symlink /private/ storage with /public/ folder
php artisan wayfinder:generate --path=resources/ts/wayfinder ## generate wayfinder types
```

### Notes:
 - In this project, /components/ are global reusables. 
    - Some pages have /partial/ folders which include subfiles intended to split and improve readability/maintainability of large pages.
 - All forms are handled programmatically using Inertia.js's useForm(). 
    - Where possible, we use form.submit with wayfinder. 
    - Axios is used where this is not feasible (i.e. shopping carts).