<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Meu Sistema de Tarefas</title>
        
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        
        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-gray-100">
        @inertia
    </body>
</html>