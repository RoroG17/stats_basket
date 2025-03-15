<template>
  <MainLayout>
    <q-page class="flex flex-center q-pa-md">
      <q-card class="q-pa-md">
        <h6>Calendrier Saison 2024-2025</h6>
         <div v-if="matchs.length > 0">
          <q-card
            v-for="match in matchs"
            :key="match.id"
            class="q-ma-md shadow-2xl rounded-xl q-mb-xl"
          >
            <q-card-section class="bg-primary text-white text-center text-h6">
              Journée {{ match.numero }} - {{ match.date_match }}
            </q-card-section>
            <q-card-section class="row items-center justify-around" v-if="match.domicile == 0">
              <div class="column items-center">
                <q-avatar size="80px">
                  <img :src="`/storage/${match.logo}`" alt="Logo {{ match.nom }}">
                </q-avatar>
                <div class="text-h6 text-center">{{ match.nom }}</div>
              </div>
              <div class="text-h4 text-weight-bold">
                <p>{{ match.score_a }} - {{ match.score_f }}</p>
                <a :href="`/espace-matchs/${match.numero}`">accès statistiques</a>
              </div>
              
              <div class="column items-center">
                <q-avatar size="80px">
                  <img :src="`/storage/logo_frouzins.png`" alt="Logo FAC">
                </q-avatar>
                <div class="text-h6 text-center">Frouzins AC</div>
              </div>
            </q-card-section>

            <q-card-section class="row items-center justify-around" v-if="match.domicile == 1">
              <div class="column items-center">
                <q-avatar size="80px">
                  <img :src="`/storage/logo_frouzins.png`" alt="Logo FAC">
                </q-avatar>
                <div class="text-h6 text-center">Frouzins AC</div>
              </div>
              <div class="text-h4 text-weight-bold">
                <p>{{ match.score_f }} - {{ match.score_a }}</p>
                <a :href="`/espace-matchs/${match.numero}`">accès statistiques</a>
              </div>
              <div class="column items-center">
                <q-avatar size="80px">
                  <img :src="`/storage/${match.logo}`" alt="Logo {{ match.nom }}">
                </q-avatar>
                <div class="text-h6 text-center">{{ match.nom }}</div>
              </div>
            </q-card-section>
          </q-card>
        </div>

        <q-spinner v-else color="primary" size="lg" class="q-ma-md" />
      </q-card>
    </q-page>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MainLayout from '@/Layout/MainLayout.vue';

const matchs = ref([]);

const fetchMatchs = async () => {
  try {
    const response = await axios.get('/matchs'); // API récupérant plusieurs matchs
    matchs.value = response.data; // Stocker tous les matchs
  } catch (error) {
    console.error("Erreur lors de la récupération des matchs :", error);
  }
};

onMounted(fetchMatchs);
</script>

<style scoped>
.q-card {
  width : 90%;
  margin-bottom : 5em;
  margin: auto;
}

.text-h4 {
  text-align: center;
}

a {
  text-align: center;
  text-decoration: none;
  font-size: 15px;
}
</style>
