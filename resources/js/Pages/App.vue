<template>
  <q-layout view="hHh lpR fFf">

    <q-header elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg" alt="Logo">
          </q-avatar>
          Statistiques Saison 2024-2025
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <!-- drawer content -->
      <q-list>
        <q-item clickable to="/espace-matchs">
          <q-item-section>
            <q-item-label>Espace Matchs</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable to="/espace-joueurs">
          <q-item-section>
            <q-item-label>Espace Joueurs</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>


    <q-page-container>
      <div v-for="(match, index) in matches" :key="index" class="q-mt-lg">
        <MatchCard
          :team1="match.team1"
          :team2="match.team2"
          :match="{
            date: match.date,
            day: match.day
          }"
        />
      </div>
    </q-page-container>

  </q-layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MatchCard from "../components/MatchCard.vue";

const leftDrawerOpen = ref(false);
const matches = ref([]);

const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value;
};

const fetchMatches = async () => {
  try {
    const response = await axios.get('/matchs');
    const data = Array.isArray(response.data) ? response.data : response.data.matches || [];
    matches.value = data.map(match => {
      const isHome = match.domicile; 
      return {
        team1: isHome ? {
          name: "Frouzins AC",
          logo: "logo_frouzins.png"
        } : {
          name: match.nom,
          logo: match.logo,
        },
        team2: isHome ? {
          name: match.nom,
          logo: match.logo,
        } : {
          name: "Frouzins AC",
          logo: "logo_frouzins.png"
        },
        date: "2024-01-01",
        day: match.numero,
      };
    })
  } catch (error) {
    console.error("Erreur lors de la récupération des matchs :", error);
  }
};

onMounted(() => {
  fetchMatches();
});
</script>
