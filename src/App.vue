<template>
  <v-app>
    <v-main>
      <div><UserInformation groupeSecurite="RueManager"></UserInformation></div>
      <div v-if="lesData.bInGroupe == 0">Utilisation autoris&eacute;e uniquement aux membres du groupe {{ lesData.groupeSecurite }}</div>
      <div v-if="lesData.bInGroupe == 1">
      <h2>Edition des rues et adresses</h2>
      <Suspense><RueChoix /></Suspense>
      <Suspense><RueEdition /></Suspense>
      </div>
    </v-main>
    <AppFooter />
  </v-app>
</template>

<script setup>
  import UserInformation from '@/components/UserInformation.vue'
  import RueChoix from '@/components/RueChoix.vue'
  import RueEdition from '@/components/RueEdition.vue'
  import { data } from '@/stores/data.js'
  let lesData = data()
  //console.log(lesData)
</script>
