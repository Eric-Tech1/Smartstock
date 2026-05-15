<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SmartStock</title>

        @routes 

        @viteReactRefresh
        
        @vite(['resources/js/app.jsx'])
        
        @inertiaHead
    </head>
    <body class="dashboard-body">
        @inertia
    </body>
</html>