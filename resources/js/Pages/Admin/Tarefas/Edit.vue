<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    tarefa: Object
});

const form = useForm({
    nome: props.tarefa.nome,
    descricao: props.tarefa.descricao,
    data_limite: props.tarefa.data_limite ? props.tarefa.data_limite.split('T')[0] : ''
});

const atualizarTarefa = () => {
    form.put(`/tarefas/${props.tarefa.id}`, {
        onSuccess: () => {
        }
    });
};
</script>

<template>
    <div class="p-8 max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Editar Tarefa #{{ tarefa.id }}</h2>
            
            <Link href="/dashboard" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded transition-colors">
                Voltar para a Listagem
            </Link>
        </div>
        
        <form @submit.prevent="atualizarTarefa">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Título da Tarefa</label>
                <input v-model="form.nome" type="text" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <textarea v-model="form.descricao" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Data Limite</label>
                <input v-model="form.data_limite" type="date" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end gap-2">
                <Link href="/dashboard" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Cancelar
                </Link>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-gray-700 rounded hover:bg-blue-600" :disabled="form.processing">
                    Atualizar Tarefa
                </button>
            </div>
        </form>
    </div>
</template>