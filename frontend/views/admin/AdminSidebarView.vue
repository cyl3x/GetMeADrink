<template>
<nav class='nav bg-light shadow flex-column h-100 flex-shrink-0 gap-3 p-3 z-1' style='width: 16rem;'>
    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": startWith("admin.order") }'
        :to='{ name: "admin.orders" }'
    >
        Bestellungen
    </router-link>

    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": startWith("admin.product") }'
        :to='{ name: "admin.products" }'
    >
        Produkte
    </router-link>

    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": startWith("admin.categor") }'
        :to='{ name: "admin.categories" }'
    >
        Kategorien
    </router-link>


    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": startWith("admin.variant") }'
        :to='{ name: "admin.variants" }'
    >
        Varianten
    </router-link>

    <router-link
        class='nav-link rounded link-dark'
        :class='{ "bg-secondary-subtle": startWith("admin.table") }'
        :to='{ name: "admin.tables" }'
    >
        Tische
    </router-link>
</nav>
</template>

<script setup lang='ts'>
import { useRoute } from 'vue-router';

const route = useRoute();

function startWith(name: string): boolean {
    return route.name?.toString().startsWith(name) ?? false;
}
</script>
