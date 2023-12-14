## Sample Image

<img width="1262" alt="Screenshot 2023-12-14 at 8 56 54 PM" src="https://github.com/ilejohn-official/fullstack-php-test/assets/72869170/9c565e49-22b6-4ab4-a5e8-f3351c156834">


## Setup

Same way you would install a typical laravel application.

    composer install

    npm install

    php artisan serve

The UI is displayed on the root page

Don't forget to run `npm run dev` after modifying the vue component.

## Extra Notes

 - Copy .env.example into .env, use your local set up environment variables and run ```php artisan key:generate``` before serving the backend app.

 - Run ```php artisan migrate``` then ```php artisan db:seed``` to migrate tables and seed hmo data.

 - If ```npm install``` fails on the frontend, use ```npm install --force```

 - Run ```npm run test``` for frontend test and ```php artisan test``` for backend test

 - The 'api/hmo/{hmo}/batches' endpoint fetches the batches group by distinct provider identity for the HMO

