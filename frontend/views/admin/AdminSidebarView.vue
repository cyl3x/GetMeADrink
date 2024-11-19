<template>
<nav class='nav bg-light shadow flex-column h-100 flex-shrink-0 gap-3 p-3 z-1' style='width: 16rem;'>
    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": is("admin.orders") }'
        :to='{ name: "admin.orders" }'
    >
        Bestellungen
    </router-link>

    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": is("admin.products") }'
        :to='{ name: "admin.products" }'
    >
        Produkte
    </router-link>

    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": is("admin.categories") }'
        :to='{ name: "admin.categories" }'
    >
        Kategorien
    </router-link>

    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": is("admin.tables") }'
        :to='{ name: "admin.tables" }'
    >
        Tische
    </router-link>
</nav>
</template>

<script setup lang='ts'>
import { useRoute } from 'vue-router';


const route = useRoute();

function is(name: string): boolean {
    return route.name === name;
}
</script>
