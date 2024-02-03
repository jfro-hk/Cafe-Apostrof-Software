<script setup>
import { Link } from '@inertiajs/vue3'
import navigation from '@/Configs/navigation'
</script>

<template>
  <v-list nav>
    <!-- List Menu -->
    <Link v-for="(item, key) in navigation.items" :key="key" :href="item.to" as="div">
      <v-list-item
        class="cursor-pointer w-100"
        :exact="item.exact"
        :class="{ 'fc-primary': $page.url.startsWith(item.to) }"
      >
        <div class="d-flex justify-space-between align-center">
          <div class="d-flex gap-12 align-center">
            <span v-html="item.icon"></span>
            <span class="fc-primary">{{ item.title }}</span>
          </div>
          <div class="side-active"></div>
        </div>
      </v-list-item>
    </Link>
    <!-- Log Out -->
  </v-list>
</template>
