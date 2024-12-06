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
                v-for='variant in variants'
                :key='variant.id'
            >
                <th scope='row'>
                    {{ variant.id }}
                </th>
                <td>
                    {{ variant.name }}
                </td>
                <td>
                    {{ formatDate(variant.createdAt) }}
                </td>
                <td class='text-end'>
                    <button
                        class='btn btn-primary btn-sm me-2'
                        @click='editVariant(variant.id)'
                    >
                        Bearbeiten
                    </button>
                    <button
                        class='btn btn-danger btn-sm'
                        @click='deleteVariant(variant.id)'
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

const variants = ref<Entity.ProductVariant[]>([]);
const router = useRouter();

async function fetchCategoies() {
    variants.value = await ProductService.getVariants();
}

function create() {
    router.push({ name: 'admin.variant' });
}

function editVariant(id: number) {
    router.push({ name: 'admin.variant', params: { id } });
}

async function deleteVariant(id: number) {
    await ProductService.deleteVariant(id);
    await fetchCategoies();
}

function formatDate(date: string) {
    return new Date(date).toLocaleString('de-DE');
}

fetchCategoies();
</script>
