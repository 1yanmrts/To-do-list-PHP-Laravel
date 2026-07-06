<script setup>
import { Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import {
    PlusIcon,
    PencilSquareIcon,
    TrashIcon
} from '@heroicons/vue/24/outline'

defineProps({
    tarefas: Array
});

const alternarStatus = (tarefa) => {
    router.patch(`/tarefas/${tarefa.id}/concluir`, {
        concluida: !tarefa.concluida
    }, {
        preserveScroll: true,
    });
};

const confirmarExclusao = (tarefa) => {
    Swal.fire({
        title: 'Excluir Tarefa?',
        text: `Tem certeza que deseja apagar a tarefa "${tarefa.nome}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/tarefas/${tarefa.id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                    Toast.fire({ icon: 'success', title: 'Tarefa excluída com sucesso!' });
                }
            });
        }
    });
};
</script>

<template>
    <div class="p-8 max-w-6xl mx-auto mt-10 bg-white rounded-lg shadow-md">
        
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">Relatório de Tarefas</h1>
            
            <Link 
                href="/tarefas/create"
                class="bg-blue-500 hover:bg-blue-600 text-gray-700 font-medium py-2 px-4 rounded shadow-sm transition-colors duration-200 flex items-center gap-2 cursor-pointer text-sm"
            >
                <PlusIcon class="w-4 h-4" />
                Nova Tarefa
            </Link>
        </div>
        
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="py-2 px-3 text-center w-16">ID</th>
                        <th class="py-2 px-3 text-center w-40">Data de Conclusão</th>
                        <th class="py-2 px-3">Título da Tarefa</th>
                        <th class="py-2 px-3">Descrição</th>
                        <th class="py-2 px-3 text-center">Ações</th> </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="tarefa in tarefas" 
                        :key="tarefa.id" 
                        @click="alternarStatus(tarefa)"
                        class="hover:bg-blue-50/50 cursor-pointer transition-colors duration-150"
                        :class="{ 'text-gray-400 bg-gray-50/30': tarefa.concluida }"
                    >
                        <td class="py-2 px-3 text-center font-medium text-gray-600">{{ tarefa.id }}</td>
                        <td class="py-2 px-3 text-center text-xs text-gray-500">
                            {{ tarefa.data_conclusao ? new Date(tarefa.data_conclusao).toLocaleString('pt-BR') : '-' }}
                        </td>
                       <td 
                            class="py-2 px-3 font-medium" 
                            :class="tarefa.concluida ? 'line-through text-gray-400' : 'text-gray-800'"
                        >
                            {{ tarefa.nome }}
                        </td>

                        <td 
                            class="py-2 px-3" 
                            :class="tarefa.concluida ? 'line-through text-gray-400' : 'text-gray-600'"
                        >
                            {{ tarefa.descricao }}
                        </td>
                        
                        <td class="py-2 px-3" @click.stop>
                            <div class="flex items-center justify-center gap-1">
                                
                                <Link 
                                    :href="`/tarefas/${tarefa.id}/edit`" 
                                    class="p-1.5 rounded transition-colors flex-shrink-0"
                                    :class="tarefa.concluida ? 'text-gray-400 hover:text-gray-600 hover:bg-gray-100' : 'text-red-500 hover:text-red-700 hover:bg-red-100'"
                                    title="Editar Tarefa"
                                >
                                    <PencilSquareIcon class="w-4 h-4" />
                                </Link>

                                <button 
                                    @click="confirmarExclusao(tarefa)" 
                                    class="p-1.5 rounded transition-colors cursor-pointer flex-shrink-0"
                                    :class="tarefa.concluida ? 'text-gray-400 hover:text-gray-600 hover:bg-gray-100' : 'text-red-500 hover:text-red-700 hover:bg-red-100'"
                                    title="Excluir Tarefa"
                                >
                                     <TrashIcon class="w-4 h-4" />
                                </button>

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>