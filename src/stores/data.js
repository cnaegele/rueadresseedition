import { defineStore } from 'pinia';
import { ref } from 'vue'
export const data = defineStore({
  id: 'iddata',
  state: () => ({
    version: ref('1.0.4'),
    dateversion: ref('15.08.2024'),
    themeChoisi: ref(localStorage.getItem('themeChoisi') || 'dark'),
    idEmployeUser: ref(0),
    nomEmployeUser: ref(''),
    prenomEmployeUser: ref(''),
    loginEmployeUser: ref(''),
    groupeSecurite: ref(''),
    bInGroupe: ref(0),
    idThingRueChoisie: ref(''),
    idAdresseCarte: ref(''),
    idAdresseEdition: ref(''),
    dataThingRue: ref({}),
    dataThingRueAdresses: ref([]),
    dataAdresseEdition: ref({}),
    indexAdresseEdition: ref(-1),
    ruesListe: ref([]),
    rueTypesListe: ref([]),
    rueCategoriesNomListe: ref([]),
    panelexpand: ref([2]),
    clicGeorefRue: ref('x'),
    messagesErreur: {
      dataRue: ref(''),
      dataAdresse: ref(''),
      serverbackend: ref(''),
    }, 
  })
})
