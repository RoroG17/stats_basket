<template>
  <MainLayout>
    <q-page class="flex flex-center q-pa-md">
      <q-card class="q-pa-md">
        <h6>Effectif Saison 2024-2025</h6>
        <div v-if="joueurs.length > 0" class="row q-col-gutter-md">
          <div v-for="joueur in joueurs" :key="joueur.licence" class="col-12 col-md-4">
            <q-card class="shadow-2xl rounded-xl">
              <q-card-section class="row items-center justify-center">
                <div class="column items-center">
                  <q-avatar size="80px">
                    <img :src="`/storage/avatar.png`" alt="Logo {{ joueur.nom }}">
                  </q-avatar>
                  <div class="text-h6 text-center">{{ joueur.nom }} {{ joueur.prenom }}</div>
                  <a :href="`/espace-joueurs/${joueur.licence}`">Accès statistiques</a>
                </div>
              </q-card-section>
            </q-card>
          </div>
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
  
  const joueurs = ref([]);
  
  const fetchMatchs = async () => {
    try {
      const response = await axios.get('/joueurs'); // API récupérant plusieurs matchs
      joueurs.value = response.data; // Stocker tous les matchs
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