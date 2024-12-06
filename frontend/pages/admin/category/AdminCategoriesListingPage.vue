<template>
<div class='w-100 overflow-scroll'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>
                    #
                </th>
                <th scope='col'>
                    Name
                </th>
                <th scope='col'>
                    Erstellt am
                </th>
                <th class='text-end' scope='col'>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for='category in categories'
                :key='category.id'
            >
                <th scope='row'>
                    {{ category.id }}
                </th>
                <td>
                    {{ category.name }}
                </td>
                <td>
                    {{ formatDate(category.createdAt) }}
                </td>
                <td class='text-end'>
                    <button
                        class='btn btn-primary btn-sm me-2'
                        @click='editCategory(category.id)'
                    >
                        Bearbeiten
                    </button>
                    <button
                        class='btn btn-danger btn-sm'
                        @click='deleteCategory(category.id)'
                    >
                        Löschen
                    </button>
                </td>
            </tr>
        </tbody>
        <tfoot />
    </table>
</div>
</template>

<script setup lang='ts'>
import { ProductService } from '@/services';
import { onMounted, onUnmounted, ref } from 'vue';
import { useRouter } from 'vue-router';

onMounted(() => { window.addEventListener('admin::create', create); });
onUnmounted(() => { window.removeEventListener('admin::create', create); });

const categories = ref<Entity.ProductCategory[]>([]);
const router = useRouter();

async function fetchCategoies() {
    categories.value = await ProductService.getCategories();
}

function create() {
    router.push({ name: 'admin.category' });
}

function editCategory(id: number) {
    router.push({ name: 'admin.category', params: { id } });
}

async function deleteCategory(id: number) {
    await ProductService.deleteCategory(id);
    await fetchCategoies();
}

function formatDate(date: string) {
    return new Date(date).toLocaleString('de-DE');
}

fetchCategoies();
</script>
