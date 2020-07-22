<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MiniStore</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    </head>
    <body>
        <div id="app">
            <Index />
        </div>
    </body>
</html>
<?php /**PATH C:\Users\fab\Desktop\LARAVEL\fullstack-php-test\resources\views/welcome.blade.php ENDPATH**/ ?>