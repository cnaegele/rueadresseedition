
<template>
    <v-card>
        <v-card-text>
            <div>choix d'une rue</div>
            <v-autocomplete
                v-model="lesData.idThingRueChoisie"
                label=""
                :items="items"
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
    await getRuesListe(lesData)
    lesData.ruesListe.unshift({
        "value": ref(0),    
        "title": ref("création d'une nouvelle rue")  
    })
    const items = lesData.ruesListe
    //console.log(items)

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
