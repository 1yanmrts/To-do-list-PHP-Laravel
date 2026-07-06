<template>
    <div class="p-8 max-w-6xl mx-auto mt-10">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Painel Geral</h1>
            <p class="text-gray-500 mt-1">Bem-vindo ao sistema de administração modular.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <Link 
                href="/tarefas" 
                class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 border-l-4 border-l-blue-500 hover:shadow-md transition-shadow group"
            >
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2 group-hover:text-blue-500 transition-colors">
                    Módulo
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Tarefas</h2>
                <p class="text-gray-400 text-sm mt-2">Acessar listagem completa</p>
            </Link>

            <div class="bg-gray-50 p-6 rounded-lg border border-dashed border-gray-300 flex flex-col justify-center items-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="text-sm font-medium">Novo Módulo em Breve</span>
            </div>

        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

</script>