
<template>
    <v-card>
        <v-card-text>
            <v-row no-gutters class="d-flex align-center">
                <v-col cols="auto">
                    <p class="text-subtitle-1 mb-2">Choix d'une rue.</p>
                </v-col>
                <v-col cols="auto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</v-col>
                <v-col cols="auto">
                    <p class="text-body-1 mb-2">Localisation :&nbsp;</p>
                </v-col>
                <v-col cols="auto">
                    <v-select
                        v-model="lesData.modeLocal"
                        :items="[
                            { title: 'Lausanne', value: 'ls' },
                            { title: 'Hors de Lausanne', value: 'horsls' }
                        ]"
                        item-title="title"
                        item-value="value"
                        density="compact"
                        height="16px"
                        max-width="200px"
                    ></v-select>
                </v-col>
            </v-row>
            <v-autocomplete
                v-model="lesData.idThingRueChoisie"
                label=""
                :items="lesData.ruesListe"
                :custom-filter="customFilter"
            ></v-autocomplete>
        </v-card-text>
    </v-card>
</template>

<script setup>
    import { ref, watch } from 'vue'
    import { data } from '@/stores/data.js'
    import { getRuesListe } from '@/axioscalls.js'
    import { getRueData } from '@/axioscalls.js'
    import { getRueAdressesListe } from '@/axioscalls.js'
    let lesData = data()
    //const items = ref([])
    listeRue()

    watch(() => lesData.modeLocal, () => {
        lesData.idThingRueChoisie = ''
        listeRue()
    })
    watch(() => lesData.idThingRueChoisie, () => {
        choixRue()
    })

    const removeAccents = str =>
        str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

    function customFilter(itemTitle, queryText, item) {
        const textLowerCase = item.raw.title.toLowerCase()
        const searchTextLowerCase = queryText.toLowerCase()
        const textUnAccent = removeAccents(item.raw.title.toLowerCase())
        const searchTextUnAccent = removeAccents(queryText.toLowerCase())
        return textLowerCase.indexOf(searchTextLowerCase) > -1
            || textUnAccent.indexOf(searchTextUnAccent) > -1
    }

    async function listeRue() {
        await getRuesListe(lesData)
        //console.log(lesData.ruesListe)
        lesData.ruesListe.unshift({
            "value": ref(0),    
            "title": ref("création d'une nouvelle rue")  
        })
        //items.value = lesData.ruesListe
    }

    async function choixRue() {
        //console.log(lesData.idThingRueChoisie)
        await getRueData(lesData)
        //console.log(lesData.dataThingRue)
        if (lesData.idThingRueChoisie > 0) {
            lesData.panelexpand = ref([2])
        } else {
            lesData.dataThingRue.idtyperue = ref(1)
            lesData.panelexpand = ref([0])
        }
        await getRueAdressesListe(lesData)
        lesData.indexAdresseEdition = ref(-1)
        lesData.idAdresseCarte = ref('')
        lesData.idAdresseEdition = ref('') 
        //console.log(lesData.dataThingRueAdresses)
    }
</script>
