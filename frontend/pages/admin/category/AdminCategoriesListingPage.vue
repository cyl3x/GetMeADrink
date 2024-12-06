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
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for='category in categories'
                :key='category.id'
            >
                <th scope='row'>{{ category.id }}</th>
                <td>
                    <span v-if='!isEditing || editedCategory?.id !== category.id'>
                        {{ category.name }}
                    </span>
                    <input
                        v-else
                        v-model='editedCategory.name'
                        type='text'
                        class="form-control"
                    />
                </td>
                <td>
                    <button
                        v-if='!isEditing || editedCategory?.id !== category.id'
                        @click='edit(category)'
                        class="btn btn-primary btn-sm"
                    >
                        Edit
                    </button>
                    <button
                        v-else
                        @click='saveEdit'
                        class="btn btn-success btn-sm me-2"
                    >
                        Save
                    </button>
                    <button
                        v-if='isEditing && editedCategory?.id === category.id'
                        @click='cancelEdit'
                        class="btn btn-danger btn-sm"
                    >
                        Cancel
                    </button>
                </td>
            </tr>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>
</template>

<script setup lang='ts'>
import { ProductService } from '@/services';
import { onMounted, onUnmounted, ref } from 'vue';

onMounted(() => { window.addEventListener('admin::create', create); });
onUnmounted(() => { window.removeEventListener('admin::create', create); });

const categories = ref<Entity.ProductCategory[]>([]);
const isEditing = ref(false);
const editedCategory = ref<DeepPartial<Entity.ProductCategory> | null>(null);

async function fetchCategoies() {
    categories.value = await ProductService.getCategories();
}

function edit(category: Entity.ProductCategory){
    isEditing.value = true;
    editedCategory.value = {
        id: category.id,
        name: category.name,
    };
}

async function saveEdit(){
    if (!editedCategory.value) return;

    try {
        const newCategory = await ProductService.upsertCategory(editedCategory.value);
        const index = categories.value.findIndex((cat) => cat.id === editedCategory.value?.id);
        if (index !== -1) {
            categories.value[index] = newCategory;
        }
        cancelEdit();
    } catch (error) {
        console.error('Failed to save changes:', error);
    }
}

function cancelEdit(){
    isEditing.value = false;
    editedCategory.value = null;
}

function create() {
    console.log('create new category');
}

fetchCategoies();
</script>
