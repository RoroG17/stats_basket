<template>
    <MainLayout>
        <div class="row justify-end q-mb-md q-mr-xl">
            <q-btn label="Télécharger en PDF" color="primary" class="q-mt-md" @click="generatePDF" />
        </div>

        <div id="pdf-content">
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
                        title="Statistiques Globals"
                        :rows="stats"
                        :columns="columns1"
                        row-key="name"
                        :rows-per-page-options="[0]"
                        ></q-table>
                    </div>
            </div>

            <q-card class="q-pa-md">
                <q-card-section style="height: 300px;">
                <canvas ref="chartGeneral"></canvas>
                </q-card-section>
            </q-card>

            <div id="q-app">
                    <div class="q-pa-md">
                        <q-table
                        title="Statistiques Complémentaires"
                        :rows="stats"
                        :columns="columns2"
                        row-key="name"
                        :rows-per-page-options="[0]"
                        ></q-table>
                    </div>
            </div>

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

            <q-card class="impl">
                <q-card-section>
                <canvas ref="chartImpl"></canvas>
                </q-card-section>
            </q-card>

            <q-card class="impl">
                <q-card-section>
                <canvas ref="chartImplPos"></canvas>
                </q-card-section>
            </q-card>

            <q-card class="impl">
                <q-card-section>
                <canvas ref="chartImplNeg"></canvas>
                </q-card-section>
            </q-card>
        </q-page>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MainLayout from '@/Layout/MainLayout.vue';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

const columns1 = [
    //s{ name: 'journee', align: 'center', label: 'n° Match', field: 'numero', sortable: true },
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
]

const columns2 = [
    { name: 'equipe', align: 'center', label: 'Equipe', field: 'nom', sortable: true },
    { name: 'tir_re', align: 'center', label: 'Tirs réussis', field: 'tir_reussi', sortable: true },
    { name: 'tir_ra', align: 'center', label: 'Tirs ratés', field: 'tir_rate', sortable: true },
    { name: '3pts_re', align: 'center', label: '3pts réussis', field: 'three_points_reussi', sortable: true },
    { name: '3pts_ra', align: 'center', label: '3pts ratés', field: 'three_points_rate', sortable: true },
    { name: 'passe_re', align: 'center', label: 'Passes réussies', field: 'passe_reussi', sortable: true },
    { name: 'passe_ra', align: 'center', label: 'Passes Ratées', field: 'passe_rate', sortable: true },
    { name: 'lf_re', align: 'center', label: 'LF réussis', field: 'lf_reussi', sortable: true },
    { name: 'lf_ra', align: 'center', label: 'LF francs ratés', field: 'lf_rate', sortable: true },
]

const joueur = ref([]);
const stats = ref([]);
const statsGen = ref([]);
const statsMoyAll = ref([]);
const statsShoot = ref([]);
const statsLF = ref([]);
const statsImplicationJoueur = ref([]);
const statsAllImplication = ref([]);
const statsImplicationPositiveJoueur = ref([]);
const statsAllImplicationPositive = ref([]);
const statsImplicationNegativeJoueur = ref([]);
const statsAllImplicationNegative = ref([]);

const chartGeneral = ref(null);
const chartShoot = ref(null);
const chartLF = ref(null);
const chartImpl = ref(null);
const chartImplPos = ref(null)
const chartImplNeg = ref(null)

const fetchMatchs = async () => {
  try {
    const id = window.location.pathname.split("/").pop();
    const response = await axios.get('/joueurs/'+ id); 
    joueur.value = response.data['infoJoueur']; 
    console.log(joueur.value.nom)
    stats.value = response.data['stats']
    statsGen.value = response.data['statsMoy']
    statsMoyAll.value = response.data['statsMoyAll']
    statsShoot.value = response.data['statsShoot']
    statsLF.value = response.data['statsLF']

    statsImplicationJoueur.value = response.data['statsImplicationJoueur']
    statsAllImplication.value = response.data['statsAllImplication']

    statsImplicationPositiveJoueur.value = response.data['statsImplicationPositiveJoueur']
    statsAllImplicationPositive.value = response.data['statsAllImplicationPositive']

    statsImplicationNegativeJoueur.value = response.data['statsImplicationNegativeJoueur']
    statsAllImplicationNegative.value = response.data['statsAllImplicationNegative']

    const labelsGen = Object.keys(statsGen.value);
    const dataValuesGen = Object.values(statsGen.value);
    const dataValuesMoyAll = Object.values(statsMoyAll.value)

    new Chart(chartGeneral.value, {
        type: "bar", // Type de graphique (bar, line, pie, etc.)
        data: {
        labels: labelsGen,
        datasets: [
            {
                label: "Moyenne du joueur",
                data: dataValuesGen,
                backgroundColor: "rgba(75, 192, 192, 0.5)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
            },
            {
                label: "Moyenne de l'équipe",
                data: dataValuesMoyAll,
                backgroundColor: "rgba(192, 75, 75, 0.5)",
                borderColor: "rgba(192, 75, 75, 1)",
                borderWidth: 1,
            }
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

    const labelsImplAll = ["Implication Positive Joueur", "Implication Négative Joueur", "Implication Equipe"];
    const dataValuesImpl = [statsImplicationPositiveJoueur.value.total, statsImplicationNegativeJoueur.value.total, statsAllImplication.value.total];
    
    new Chart(chartImpl.value, {
        type: "pie",
        data: {
            labels: labelsImplAll,
            datasets: [
            {
                label: "Statistiques d'implication",
                data: dataValuesImpl,
                backgroundColor: [
                "rgba(75, 192, 192, 0.6)",   // bleu/vert : positif
                "rgba(255, 99, 132, 0.6)",   // rouge : négatif
                "rgba(255, 206, 86, 0.6)",   // jaune : équipe
                ],
                borderColor: [
                "rgba(75, 192, 192, 1)",
                "rgba(255, 99, 132, 1)",
                "rgba(255, 206, 86, 1)",
                ],
                borderWidth: 1,
            },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        },
    });

    const labelsImpl = ["Implication Joueur", "Implication Equipe"];
    const dataValuesImplPos = [statsImplicationPositiveJoueur.value.total, statsAllImplicationPositive.value.total];
    
    new Chart(chartImplPos.value, {
        type: "pie", // Type de graphique (bar, line, pie, etc.)
        data: {
        labels: labelsImpl,
        datasets: [
            {
            label: "Statistiques du joueur",
            data: dataValuesImplPos,
            backgroundColor: dataValuesImplPos.map((_, index) => 
                    index % 2 === 0 ? "rgba(75, 192, 192, 0.5)" : "rgba(192, 75, 75, 0.5)"
                ),
                borderColor: dataValuesImplPos.map((_, index) => 
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

    const dataValuesImplNeg = [statsImplicationNegativeJoueur.value.total, statsAllImplicationNegative.value.total];
    
    new Chart(chartImplNeg.value, {
        type: "pie", // Type de graphique (bar, line, pie, etc.)
        data: {
        labels: labelsImpl,
        datasets: [
            {
            label: "Statistiques du joueur",
            data: dataValuesImplNeg,
            backgroundColor: dataValuesImplNeg.map((_, index) => 
                    index % 2 === 0 ? "rgba(75, 192, 192, 0.5)" : "rgba(192, 75, 75, 0.5)"
                ),
                borderColor: dataValuesImplNeg.map((_, index) => 
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

import { jsPDF } from "jspdf";
import html2canvas from "html2canvas";


const generatePDF = async () => {
  const element = document.getElementById("pdf-content"); // Sélectionne l'élément à capturer

  if (!element) {
    console.error("Élément #pdf-content non trouvé !");
    return;
  }

  const canvas = await html2canvas(element, {
    scale: 2, // Améliore la qualité de l'image
    useCORS: true, // Évite les erreurs de sécurité liées aux images externes
  });

  const imgData = canvas.toDataURL("image/png");
  const pdf = new jsPDF("p", "mm", "a4");
  const margin = 10; // Marge en mm

  let imgWidth = 210 - 2 * margin; // Largeur A4 moins les marges
  let imgHeight = (canvas.height * imgWidth) / canvas.width;

  if (imgHeight > 297 - 2 * margin) {
    // Si l'image est trop grande pour une seule page
    let pageHeight = 297 - 2 * margin; // Hauteur max par page
    let y = margin; // Position de départ

    while (imgHeight > 0) {
      pdf.addImage(imgData, "PNG", margin, y, imgWidth, Math.min(imgHeight, pageHeight));
      imgHeight -= pageHeight;
      y = margin;
      if (imgHeight > 0) pdf.addPage(); // Ajoute une nouvelle page si nécessaire
    }
  } else {
    // Si tout tient sur une page
    pdf.addImage(imgData, "PNG", margin, margin, imgWidth, imgHeight);
  }

  pdf.save("statistiques_"+ joueur.value.nom + "_" + joueur.value.prenom + ".pdf");
};

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

.impl {
    width: 30%;
    margin-top: 2em;
}
</style>