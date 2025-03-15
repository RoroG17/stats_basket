<template>
    <MainLayout>
        <q-page class="flex flex-center q-pa-md">
            <q-card class="q-ma-md shadow-2xl rounded-xl q-mb-xl">
                <q-card-section class="row items-center justify-around">
                <div class="column items-center">
                    <q-avatar size="80px">
                    <img :src="`/storage/avatar.png`" alt="Logo {{ match.nom }}">
                    </q-avatar>
                    <div class="text-h6 text-center">{{ joueur.nom }} {{ joueur.prenom }}</div>
                </div>
                </q-card-section>
            </q-card>

            <div id="q-app">
                    <div class="q-pa-md">
                        <q-table
                        title="Statistiques"
                        :rows="stats"
                        :columns="columns"
                        row-key="name"
                        ></q-table>
                    </div>
            </div>

            <q-card class="q-pa-md">
                <q-card-section>
                <canvas ref="chartGeneral"></canvas>
                </q-card-section>
            </q-card>

            <q-card class="pie">
                <q-card-section>
                <canvas ref="chartShoot"></canvas>
                </q-card-section>
            </q-card>

            <q-card class="pie">
                <q-card-section>
                <canvas ref="chartLF"></canvas>
                </q-card-section>
            </q-card>
        </q-page>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MainLayout from '@/Layout/MainLayout.vue';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

const columns = [
    { name: 'journee', align: 'center', label: 'n° Match', field: 'numero', sortable: true },
    { name: 'equipe', align: 'center', label: 'Equipe', field: 'nom', sortable: true },
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

const joueur = ref([]);
const stats = ref([]);
const statsGen = ref([]);
const statsShoot = ref([]);
const statsLF = ref([]);

const chartGeneral = ref(null);
const chartShoot = ref(null);
const chartLF = ref(null);

const fetchMatchs = async () => {
  try {
    const id = window.location.pathname.split("/").pop();
    const response = await axios.get('/joueurs/'+ id); 
    joueur.value = response.data['infoJoueur']; 
    stats.value = response.data['stats']
    statsGen.value = response.data['statsMoy']
    statsShoot.value = response.data['statsShoot']
    statsLF.value = response.data['statsLF']


    const labelsGen = Object.keys(statsGen.value);
    const dataValuesGen = Object.values(statsGen.value);

    new Chart(chartGeneral.value, {
        type: "bar", // Type de graphique (bar, line, pie, etc.)
        data: {
        labels: labelsGen,
        datasets: [
            {
            label: "Statistiques du joueur",
            data: dataValuesGen,
            backgroundColor: "rgba(75, 192, 192, 0.5)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
            },
        ],
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        },
    });

    const labelsShoot = Object.keys(statsShoot.value);
    const dataValuesShoot = Object.values(statsShoot.value);
    
    new Chart(chartShoot.value, {
        type: "pie", // Type de graphique (bar, line, pie, etc.)
        data: {
        labels: labelsShoot,
        datasets: [
            {
            label: "Statistiques du joueur",
            data: dataValuesShoot,
            backgroundColor: dataValuesShoot.map((_, index) => 
                    index % 2 === 0 ? "rgba(75, 192, 192, 0.5)" : "rgba(192, 75, 75, 0.5)"
                ),
                borderColor: dataValuesShoot.map((_, index) => 
                    index % 2 === 0 ? "rgba(75, 192, 192, 1)" : "rgba(192, 75, 75, 1)"
                ),
            borderWidth: 1,
            },
        ],
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        },
    });

    const labelsLF = Object.keys(statsLF.value);
    const dataValuesLF = Object.values(statsLF.value);
    
    new Chart(chartLF.value, {
        type: "pie", // Type de graphique (bar, line, pie, etc.)
        data: {
        labels: labelsLF,
        datasets: [
            {
            label: "Statistiques du joueur",
            data: dataValuesLF,
            backgroundColor: dataValuesShoot.map((_, index) => 
                    index % 2 === 0 ? "rgba(75, 192, 192, 0.5)" : "rgba(192, 75, 75, 0.5)"
                ),
                borderColor: dataValuesShoot.map((_, index) => 
                    index % 2 === 0 ? "rgba(75, 192, 192, 1)" : "rgba(192, 75, 75, 1)"
                ),
            borderWidth: 1,
            },
        ],
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        },
    })

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

.pie {
    width: 40%;
    margin-top: 2em;
}

.q-app{
    width: 50%;
}
</style>