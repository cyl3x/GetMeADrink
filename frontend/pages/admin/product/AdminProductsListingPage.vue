<template>
    <div class='w-100 overflow-auto'>
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
                        Bild
                    </th>
                    <th scope='col'>
                        Variant
                    </th>
                    <th scope='col'>
                        Preis
                    </th>
                    <th scope='col'>
                        Erstellt am
                    </th>
                    <th scope='col'>
                        Aktionen
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for='product in products'
                    :key='product.id'
                >
                    <th scope='row'>{{ product.id }}</th>
                    <td>{{ product.name }}</td>
                    <td>
                        <div style="width: 5rem; height: 5rem;">
                            <img
                            v-if='product.image'
                            :src='product.image'
                            class='card-grid-item__image'
                            >
                            <div v-else>Kein Bild vorhanden</div>
                        </div>
                    </td>
                    <td>{{ product.variant.name }}</td>
                    <td>{{ product.price.toFixed(2) }} €</td>
                    <td>{{ formatDate(product.createdAt) }}</td>
                    <td>
                        <button
                            class='btn btn-primary btn-sm'
                            @click='edit(product.id)'
                        >
                            Bearbeiten
                        </button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <!-- Pagination -->
            </tfoot>
        </table>
    </div>
    </template>

    <script setup lang='ts'>
    import { ProductService } from '@/services';
    import { onMounted, onUnmounted, ref } from 'vue';
    import { useRouter } from 'vue-router';

    const products = ref<Entity.Product[]>([]);
    const router = useRouter();

    onMounted(() => { window.addEventListener('admin::create', create); });
    onUnmounted(() => { window.removeEventListener('admin::create', create); });

    function create() {
    router.push({ name: 'admin.product' });
    }

    function edit(id: number) {
    router.push({ name: 'admin.product', params: { id } });
    }

    async function fetchProducts() {
        products.value = await ProductService.getProducts();
    }

    function formatDate(date: string) {
        return new Date(date).toLocaleString('de-DE');
    }

    fetchProducts();
    </script>

