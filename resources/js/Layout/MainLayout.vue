<template>
    <q-layout view="hHh lpR fFf">
  
      <q-header elevated class="bg-primary text-white">
        <q-toolbar>
          <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />
  
          <q-toolbar-title>
            <q-avatar>
              <img :src="`/storage/logo_frouzins.png`">
            </q-avatar>
            U15G2 Statistique Saison 2024-2025  
          </q-toolbar-title>
        </q-toolbar>
      </q-header>
  
      <q-drawer show-if-above v-model="leftDrawerOpen" side="left" class="bg-primary text-white" bordered>
        <a href="/espace-matchs">
          <q-item clickable v-ripple to="/espace-matchs">
            <q-item-section>Espace Matchs</q-item-section>
          </q-item>
        </a>
        <a href="/espace-joueurs">
          <q-item clickable v-ripple to="/espace-joueurs">
            <q-item-section>Espace Joueurs</q-item-section>
          </q-item>
        </a>
      </q-drawer>
  
      <q-page-container>
        <slot> </slot>
      </q-page-container>
  
    </q-layout>
  </template>
  
  <script>
  import { ref } from 'vue'
  
  export default {
    setup () {
      const leftDrawerOpen = ref(false)
  
      return {
        leftDrawerOpen,
        toggleLeftDrawer () {
          leftDrawerOpen.value = !leftDrawerOpen.value
        }
      }
    }
  }
  </script>

<style scoped>
a {
  text-decoration: none;
  color: white;
}
</style>