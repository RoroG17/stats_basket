<template>
    <MainLayout>
        <q-page class="flex flex-center q-pa-md">
            <q-card class="q-pa-md">
                <q-card class="q-ma-md shadow-2xl rounded-xl q-mb-xl" >
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
                    </div>
                    <div class="column items-center">
                        <q-avatar size="80px">
                        <img :src="`/storage/${match.logo}`" alt="Logo {{ match.nom }}">
                        </q-avatar>
                        <div class="text-h6 text-center">{{ match.nom }}</div>
                    </div>
                    </q-card-section>
                </q-card>
            </q-card>

            <div id="q-app" style="min-height: 100vh;">
                <div class="q-pa-md">
                    <q-table
                    title="Statistiques"
                    :rows="stats"
                    :columns="columns"
                    row-key="name"
                    ></q-table>
                </div>
            </div>
        </q-page>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MainLayout from '@/Layout/MainLayout.vue';

const columns = [
    { name: 'nom', align: 'center', label: 'Nom', field: 'nom', sortable: true },
    { name: 'prenom', align: 'center', label: 'Prenom', field: 'prenom', sortable: true },
    { name: 'minute', align: 'center', label: 'Minutes', field: 'minutes', sortable: true },
    { name: 'point', align: 'center', label: 'Points', field: 'points', sortable: true },
    { name: 'passe_d', align: 'center', label: 'Passes Décisives', field: 'passe_decisive', sortable: true },
    { name: 'rebond', align: 'center', label: 'Rebonds', field: 'rebond', sortable: true },
    { name: 'rebond_off', align: 'center', label: 'Rebonds offensifs', field: 'rebond_off', sortable: true },
    { name: 'rebond_def', align: 'center', label: 'Rebonds défensifs', field: 'rebond_def', sortable: true },
    { name: 'interception', align: 'center', label: 'Interceptions', field: 'interception', sortable: true },
    { name: 'contre', align: 'center', label: 'Contres', field: 'contre', sortable: true },
    { name: 'ballon_p', align: 'center', label: 'Ballons Perdus', field: 'ballon_perdu', sortable: true },
    { name: 'faute', align: 'center', label: 'Fautes', field: 'faute', sortable: true },
    { name: 'tir_re', align: 'center', label: 'Tirs réussis', field: 'tir_reussi', sortable: true },
    { name: 'tir_ra', align: 'center', label: 'Tirs ratés', field: 'tir_rate', sortable: true },
    { name: '3pts_re', align: 'center', label: '3pts réussis', field: 'three_points_reussi', sortable: true },
    { name: '3pts_ra', align: 'center', label: '3pts ratés', field: 'three_points_rate', sortable: true },
    { name: 'passe_re', align: 'center', label: 'Passes réussies', field: 'passe_reussi', sortable: true },
    { name: 'passe_ra', align: 'center', label: 'Passes Ratées', field: 'passe_rate', sortable: true },
    { name: 'lf_re', align: 'center', label: 'Lancers francs réussis', field: 'lf_reussi', sortable: true },
    { name: 'lf_ra', align: 'center', label: 'Lancers francs ratés', field: 'lf_rate', sortable: true },
]

const match = ref([]);
const stats = ref([]);
const fetchMatchs = async () => {
  try {
    const id = window.location.pathname.split("/").pop();
    const response = await axios.get('/matchs/'+ id); 
    match.value = response.data['infoMatch']; 
    stats.value = response.data['statsMatch']
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
</style>