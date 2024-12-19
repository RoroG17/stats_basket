<template>
    <q-card class="q-ma-md q-pa-md shadow-2">
      <q-card-section>
        <div class="row justify-between items-center">
          <!-- Équipe 1 -->
          <div class="col-auto text-center q-gutter-md row items-center">
            <q-avatar size="80px">
              <img :src="'/storage/' + team1.logo" alt="Logo équipe 1" />
            </q-avatar>
            <div class="q-ml-md text-h5">{{ team1.name }}</div>
          </div>

  
          <!-- Détails du match -->
          <div class="col-auto text-center">
            <div class="text-h6">{{ match.date }}</div>
            <div class="text-caption">Journée {{ match.day }}</div>
            <q-chip class="q-mt-sm" color="primary" outline>
              VS
            </q-chip>
          </div>
  
          <!-- Équipe 2 -->
          <div class="col-auto text-center q-gutter-md row items-center">
            <div class="q-ml-md text-h5">{{ team2.name }}</div>
            <q-avatar size="80px">
              <img :src="'/storage/' + team2.logo" alt="Logo équipe 2" />
            </q-avatar>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </template>
  
  <script>
  export default {
    name: "MatchCard",
    props: {
      team1: {
        type: Object,
        required: true,
      },
      team2: {
        type: Object,
        required: true,
      },
      match: {
        type: Object,
        required: true,
      },
    },
  };
  </script>
  
  <style scoped>
  .shadow-2 {
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
  }
  </style>
  