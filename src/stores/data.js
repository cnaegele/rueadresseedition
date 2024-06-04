import { defineStore } from 'pinia';
import { ref } from 'vue'
export const data = defineStore({
  id: 'iddata',
  state: () => ({
    version: ref('1.0.0'),
    dateversion: ref('04.06.2024'),
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
    messagesErreur: {
      dataRue: ref(''),
      dataAdresse: ref(''),
      serverbackend: ref(''),
    }, 
  })
})
