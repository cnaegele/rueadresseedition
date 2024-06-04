import { ref } from 'vue'
import axios from 'axios'
let g_devurl = ''
if (import.meta.env.DEV) {
    g_devurl = 'https://mygolux.lausanne.ch'    
}
const g_pathurl = '/goeland/rue/ajax/'

export async function getDataUserInfo(groupeSecurite, lesData) {
    const urlui = `${g_devurl}/goeland/gestion_spec/g_login_f5.php`
    const params = new URLSearchParams([['groupesecurite', groupeSecurite]])
    const response = await axios.get(urlui, { params })
        .catch(function (error) {
            traiteAxiosError(error, lesData)
        })   
    const userInfo = response.data
    lesData.idEmployeUser = ref(userInfo.id_employe)
    lesData.nomEmployeUser = ref(userInfo.nom_employe)
    lesData.prenomEmployeUser = ref(userInfo.prenom_employe)
    lesData.loginEmployeUser = ref(userInfo.login_employe)
    lesData.groupeSecurite = ref(userInfo.groupesecurite)
    lesData.bInGroupe = ref(userInfo.bingroupe)
}

export async function getRuesListe(lesData) {
    const urlrl = `${g_devurl}${g_pathurl}rues_noms_liste.php`
    const response = await axios.get(urlrl)
        .catch(function (error) {
            return traiteAxiosError(error)
        })
    lesData.ruesListe = ref(response.data)
}

export async function getTypesRueListe(lesData) {
    const urlrl = `${g_devurl}${g_pathurl}rue_types_liste.php`
    const response = await axios.get(urlrl)
        .catch(function (error) {
            return traiteAxiosError(error)
        })
    lesData.rueTypesListe = ref(response.data)
}

export async function getCategoriesNomRueListe(lesData) {
    const urlrl = `${g_devurl}${g_pathurl}rue_categoriesnom_liste.php`
    const response = await axios.get(urlrl)
        .catch(function (error) {
            return traiteAxiosError(error)
        })
    lesData.rueCategoriesNomListe = ref(response.data)
}

export async function getRueData(lesData) {
    const urlrd = `${g_devurl}${g_pathurl}rue_data.php`
    const params = new URLSearchParams([['idthing', lesData.idThingRueChoisie]])
    const response = await axios.get(urlrd, { params })
        .catch(function (error) {
            return traiteAxiosError(error)
        })
    const aResponse = response.data
    if (aResponse.length == 1) {
        lesData.dataThingRue = ref(aResponse[0])
    }
}

export async function getRueAdressesListe(lesData) {
    const urlral = `${g_devurl}${g_pathurl}rue_adresses_liste.php`
    const params = new URLSearchParams([['idthing', lesData.idThingRueChoisie]])
    const response = await axios.get(urlral, { params })
        .catch(function (error) {
            return traiteAxiosError(error)
        })
    for (let i=0; i<response.data.length; i++) {
        if (response.data[i].bactif == 1) {
            response.data[i].boolactif = true    
        } else {
            response.data[i].boolactif = false    
        }
    }
    lesData.dataThingRueAdresses = ref(response.data)
}

export async function sauveAdresse(lesData, dataAdresse) {
    const jdata = JSON.stringify(dataAdresse)
    const urlsaa = `${g_devurl}${g_pathurl}rue_adresse_sauve.php`
    const response = await axios.post(urlsaa, jdata, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .catch(function (error) {
        lesData.messagesErreur.serverbackend = ref(traiteAxiosError(error, lesData))
    })      
    //console.log(response.data)
    if (response.data.message.indexOf('ERREUR') == 0) {
        lesData.messagesErreur.serverbackend = ref(response.data.message)   
    }
}

export async function sauveRue(lesData, dataRue) {
    const jdata = JSON.stringify(dataRue)
    //console.log(`json pour rue_sauve.php: ${jdata}`)
    const urlsar = `${g_devurl}${g_pathurl}rue_sauve.php`
    const response = await axios.post(urlsar, jdata, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .catch(function (error) {
        lesData.messagesErreur.serverbackend = ref(traiteAxiosError(error))
    })      
    //console.log(response.data)
    if (response.data.message.indexOf('ERREUR') == 0) {
        lesData.messagesErreur.serverbackend = ref(response.data.message)   
    }
}

function traiteAxiosError(error) {
    if (error.response) {
        return `${error.response.data}<br>${error.response.status}<br>${error.response.headers}`    
    } else if (error.request.responseText) {
        return error.request.responseText
    } else {
        return error.message
    }
}