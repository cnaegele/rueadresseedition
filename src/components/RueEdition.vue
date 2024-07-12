<style>
.mapcontainerrue {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin: 0;
  padding: 0;
  position: relative;
  width: 100%;
  height: 600px;
  background-color: black;
  justify-content: center;
  align-items: center;
}
.mapcontaineradr {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin: 0;
  padding: 0;
  position: relative;
  width: 1000px;
  height: 615px;
  background-color: black;
  justify-content: center;
  align-items: center;
}
.titreAdresses {
    font-weight: bold;
    background-color: rgb(52, 122, 212);
}
</style>
<template>
    <v-dialog
        v-model="dialog"
        width="auto"
    >
        <v-card
            max-width="400"
            :text="dialogText"
            :title="dialogTitle"
        >
            <template v-slot:actions>
            <v-btn
                class="ms-auto"
                text="Ok"
                @click="dialog = false"
            ></v-btn>
            </template>
        </v-card>
    </v-dialog>

    <v-expansion-panels
        v-model="lesData.panelexpand" 
        v-if="lesData.idThingRueChoisie !== ''"
        multiple
    >
        <v-expansion-panel>
            <v-expansion-panel-title>
                Données rue (id: {{ lesData.idThingRueChoisie }})
            </v-expansion-panel-title>
            <v-expansion-panel-text>   
                <v-form @submit.prevent="demandeSauveRue()">
                    <v-container v-if="lesData.idThingRueChoisie !== ''">
                        <v-row>
                            <v-col>
                                <v-tooltip text="sauver">
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind="props"
                                            icon="mdi-database-arrow-left-outline"
                                            type="submit"
                                        />
                                    </template>        
                                </v-tooltip>
                                <v-tooltip text="abandonner les modifications">
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind="props"
                                            icon="$cancel"
                                            @click="quitteEditionRue()"
                                        />
                                    </template>        
                                </v-tooltip>
                                &nbsp;&nbsp;<span class="messageErreur">{{ lesData.messagesErreur.dataRue }}</span>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-select
                                    id="selTypeRue"
                                    v-model="lesData.dataThingRue.idtyperue"
                                    :rules="typeRueRules"
                                    label="type de rue"
                                    :items="lesData.rueTypesListe"
                                    @focus="focusSurInputGenereNom"
                                    required
                                ></v-select>
                            </v-col>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpArticle"
                                    v-model="lesData.dataThingRue.article"
                                    label="article"
                                    @focus="focusSurInputGenereNom"
                                ></v-text-field>    
                            </v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    id="inpPrenom"
                                    v-model="lesData.dataThingRue.prenom"
                                    label="Prénom"
                                    @focus="focusSurInputGenereNom"
                                ></v-text-field>    
                            </v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    id="inpNom"
                                    v-model="lesData.dataThingRue.nom"
                                    :rules="nomRueRules"
                                    label="nom"
                                    name="nom"
                                    required
                                    @focus="focusSurInputGenereNom"
                                ></v-text-field>    
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                                cols="12"
                                md="12"
                            >
                                <v-text-field
                                    id="inpNomLong"
                                    v-model="lesData.dataThingRue.nomlong"
                                    :rules="nomLongRueRules"
                                    label="nom long"
                                    required
                                ></v-text-field>    
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                                cols="12"
                                md="8"
                            >
                                <v-text-field
                                    id="inpNomCourt"
                                    v-model="lesData.dataThingRue.nomcourt"
                                    :rules="nomCourtRueRules"
                                    label="nom court"
                                    required
                                ></v-text-field>    
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpESTRID"
                                    v-model="lesData.dataThingRue.estrid"
                                    :rules="estridRules"
                                    label="ESTRID"
                                ></v-text-field>    
                            </v-col>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpESID"
                                    v-model="lesData.dataThingRue.esid"
                                    :rules="esidRules"
                                    label="ESID"
                                ></v-text-field>    
                            </v-col>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpCodeRue"
                                    v-model="lesData.dataThingRue.coderue"
                                    :rules="codeRueRules"
                                    label="code rue (SOI)"
                                ></v-text-field>    
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-select
                                    v-model="lesData.dataThingRue.idcategorienom"
                                    :rules="categorieNomRules"
                                    label="catégorie nom"
                                    :items="lesData.rueCategoriesNomListe"
                                ></v-select>
                            </v-col>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpDateDecisionMuni"
                                    v-model="lesData.dataThingRue.datedecisionmuni"
                                    :rules="anneeDecisionMuniRules"
                                    label="année décision municipalité"
                                ></v-text-field>    
                            </v-col>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-radio-group
                                    label="sur domaine"
                                    v-model="lesData.dataThingRue.bpublic"
                                    inline
                                    density="compact"
                                >
                                    <v-radio label="public" :value="1" ></v-radio>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <v-radio label="privé" :value="0" ></v-radio>
                                </v-radio-group>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpCoordMinOE"
                                    v-model="lesData.dataThingRue.coordminoe"
                                    :rules="coordOEMinRules"
                                    label="coordonnée minimum ouest-est"
                                ></v-text-field>    
                            </v-col>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpCoordMinSN"
                                    v-model="lesData.dataThingRue.coordminsn"
                                    :rules="coordSNMinRules"
                                    label="coordonnée minimum sud-nord"
                                ></v-text-field>    
                            </v-col>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpCoordMaxOE"
                                    v-model="lesData.dataThingRue.coordmaxoe"
                                    :rules="coordOEMaxRules"
                                    label="coordonnée maximum ouest-est"
                                ></v-text-field>    
                            </v-col>
                            <v-col
                                cols="12"
                                md="2"
                            >
                                <v-text-field
                                    id="inpCoordMaxSN"
                                    v-model="lesData.dataThingRue.coordmaxsn"
                                    :rules="coordSNMaxRules"
                                    label="coordonnée maximum sud-nord"
                                ></v-text-field>    
                            </v-col>
                        </v-row>
                        <v-row v-if="bGeoRefRue == true">
                            <v-col
                                cols="12"
                                md="8"
                            >
                                <v-radio-group
                                    label="Géoréférencement de la rue : Retour clic sur carte"
                                    v-model="lesData.clicGeorefRue"
                                    inline
                                    density="compact"
                                >
                                    <v-radio label="aucun" :value="'x'" ></v-radio>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <v-radio label="minOE" :value="'minOE'" ></v-radio>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <v-radio label="minOE et minSN" :value="'minOEminSN'" ></v-radio>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <v-radio label="minSN" :value="'minSN'" ></v-radio>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <v-radio label="maxOE" :value="'maxOE'" ></v-radio>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <v-radio label="maxOE et maxSN" :value="'maxOEmaxSN'" ></v-radio>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <v-radio label="maxSN" :value="'maxSN'" ></v-radio>
                                </v-radio-group>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col
                                cols="12"
                                md="12"
                            >
                                <v-textarea
                                    label="commentaire"
                                    v-model="lesData.dataThingRue.commentaire"
                                    rows="1"
                                    auto-grow
                                ></v-textarea>                        
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </v-expansion-panel-text>
        </v-expansion-panel>
        <v-expansion-panel>
            <v-expansion-panel-title>
                Carte
            </v-expansion-panel-title>
            <v-expansion-panel-text>
                <v-container>
                    <v-row 
                        no-gutters
                        class="border border-thin"
                    >
                        <v-col>
                            <div class="mapcontainerrue">
                                <map-lausanne 
                                    v-if="lesData.dataThingRue.coordminoe != null
                                            && lesData.dataThingRue.coordminsn != null
                                            && lesData.dataThingRue.coordmaxoe != null
                                            && lesData.dataThingRue.coordmaxsn != null" 
                                    ref="ruemap"
                                    :zoom="mapZoomRue"
                                    :base-layer="'fonds_geo_osm_bdcad_gris'"
                                    :layers-visible="41"
                                    :center="[(lesData.dataThingRue.coordminoe+lesData.dataThingRue.coordmaxoe)/2.0, 
                                                (lesData.dataThingRue.coordminsn+lesData.dataThingRue.coordmaxsn)/2.0]"
                                    @map-click="handleMapClickEventRue"            
                                />
                                <map-lausanne v-else ref="ruemap"
                                    :zoom="mapZoomLausanne"
                                    :center="mapCenterLausanne"
                                    :base-layer="'fonds_geo_osm_bdcad_gris'"
                                    :layers-visible="41"
                                    @map-click="handleMapClickEventRue" 
                                />
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-expansion-panel-text>
        </v-expansion-panel>
        <v-expansion-panel>
            <v-expansion-panel-title>
                Adresses ({{ lesData.dataThingRueAdresses.length }})
            </v-expansion-panel-title>
            <v-expansion-panel-text>
                <v-container>
                    <v-row 
                        no-gutters
                        class="titreAdresses border border-thin"
                    >
                        <v-col> </v-col>
                        <v-col md="2">
                            Adresse&#0160;&#0160;&#0160;&#0160;
                            <v-tooltip text="créer une nouvelle adresse">
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        v-bind="props"
                                        icon="$plus"
                                        color="primary"
                                        size="small"
                                        @click="demandeCreationAdresse()"
                                    />
                                </template>        
                            </v-tooltip>
                        </v-col>
                        <v-col>Code postal</v-col>
                        <v-col>Commune</v-col>
                        <v-col>Ext CP</v-col>
                        <v-col>egid</v-col>
                        <v-col>edid</v-col>
                        <v-col>coord OE</v-col>
                        <v-col>Coord SN</v-col>
                        <v-col>Accès DP</v-col>
                        <v-col>etat</v-col>
                    </v-row>
                    <v-form @submit.prevent="demandeSauveAdresse(adresseinit)">
                    <v-row
                        no-gutters 
                        class="border border-thin"
                        v-if="lesData.idAdresseEdition == '0'" 
                    >
                        <v-col> </v-col>
                        <v-col>
                            {{ lesData.dataThingRue.nomlong }}
                        </v-col>
                        <v-col>
                            <v-text-field
                                v-model="nouveauNumero"
                                label="numéro"
                                density="compact"
                                ref="inpNouveauNumero"
                                :rules="nouveauNumeroRule"
                            ></v-text-field> 
                        </v-col>
                        <v-col>
                            <v-tooltip text="sauver la nouvelle adresse">
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        v-bind="props"
                                        icon="mdi-database-arrow-left-outline"
                                        type="submit"
                                    />
                                </template>        
                            </v-tooltip>
                            <v-tooltip text="abandonner la création de la nouvelle adresse">
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        v-bind="props"
                                        icon="$cancel"
                                        @click="quitteEditionAdresse(adresseinit)"
                                    />
                                </template>        
                            </v-tooltip>
                         </v-col>
                        <v-col></v-col>
                        <v-col></v-col>
                        <v-col></v-col>
                        <v-col></v-col>
                        <v-col></v-col>
                        <v-col> </v-col>
                        <v-col> </v-col>
                    </v-row>
                    </v-form>
                    <v-form v-for="(adresse, index) in lesData.dataThingRueAdresses" :key="adresse.idadresse">
                        <v-row 
                            no-gutters
                            v-if="lesData.idAdresseEdition != adresse.idadresse"
                            class="vrowadressevisu border border-thin" 
                            :class="{ adressedesactivee : !adresse.boolactif }" 
                            :goid="adresse.idadresse" 
                        >
                            <v-col>
                                <v-tooltip text="afficher la carte">
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind="props"
                                            icon="mdi-map"
                                            size="small"
                                            @click="selectAdresseCarte(adresse)"
                                        />
                                    </template>        
                                </v-tooltip>
                                 <v-tooltip text="éditer">
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind="props"
                                            icon="$edit"
                                            size="small"
                                           @click="demandeEditionAdresse(adresse, index)"
                                        />
                                    </template>        
                                </v-tooltip>
                            </v-col>
                            <v-col md="2">
                                {{ adresse.libelle }}
                            </v-col>
                            <v-col>
                                {{ adresse.codepostal }}
                            </v-col>
                            <v-col>
                                {{ adresse.communepostale }}
                            </v-col>
                            <v-col>
                                {{ adresse.extensioncp }}
                            </v-col>
                            <v-col>
                                {{ adresse.egid }}
                            </v-col>
                            <v-col>
                                {{ adresse.edid }}
                            </v-col>
                            <v-col>
                                {{ adresse.coordoe }}
                            </v-col>
                            <v-col>
                                {{ adresse.coordsn }}
                            </v-col>
                            <v-col>
                               {{ adresse.accesdp }}
                            </v-col>    
                            <v-col>
                                <div v-if="adresse.boolactif">existe</div>
                                <div v-else>désactivée</div>
                            </v-col>
                        </v-row>
                        <v-row 
                            no-gutters
                            v-if="lesData.idAdresseEdition == adresse.idadresse"
                            class="vrowadresseedit border border-thin" 
                            :class="{ adressedesactivee : !adresse.boolactif }" 
                            :goid="adresse.idadresse" 
                        >
                            <v-col>
                                <v-tooltip text="sauver">
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind="props"
                                            icon="mdi-database-arrow-left-outline"
                                            @click="demandeSauveAdresse(adresse)"
                                        />
                                    </template>        
                                </v-tooltip>
                                <v-tooltip text="abandonner les modifications">
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind="props"
                                            icon="$cancel"
                                            @click="quitteEditionAdresse(adresse)"
                                        />
                                    </template>        
                                </v-tooltip>
                                <span class="messageErreur">{{ lesData.messagesErreur.dataAdresse }}</span>
                            </v-col>
                            <v-col md="2">
                                {{ adresse.libelle }}
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="adresse.codepostal"
                                    :rules="adrCodePostalRules"
                                    label="code postal"
                                ></v-text-field>    
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="adresse.communepostale"
                                    :rules="todorules"
                                    label="commune postale"
                                ></v-text-field>    
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="adresse.extensioncp"
                                    :rules="adrExtensionCPRules"
                                    label="ext. CP"
                                ></v-text-field>    
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="adresse.egid"
                                    :rules="egidRules"
                                    label="egid"
                                ></v-text-field>    
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="adresse.edid"
                                    :rules="edidRules"
                                    label="edid"
                                ></v-text-field>    
                            </v-col>
                            <v-col>
                                <v-text-field
                                    :id="`inpCoordOE${adresse.idadresse}`"
                                    v-model="lesData.dataThingRueAdresses[index].coordoe"
                                    :rules="adrcoordOERules"
                                    label="coord. ouest-est"
                                ></v-text-field>    
                            </v-col>
                            <v-col>
                                <v-text-field
                                    :id="`inpCoordSN${adresse.idadresse}`"
                                    v-model="lesData.dataThingRueAdresses[index].coordsn"
                                    :rules="adrcoordSNRules"
                                    label="coord. sud-nord"
                                ></v-text-field>    
                            </v-col>
                            <v-col>
                                <v-select
                                    :items="itemsAccesDP"
                                    label="accès par DP"
                                    v-model="adresse.accesdp"
                                ></v-select>
                            </v-col>    
                            <v-col>
                                <v-switch
                                        v-if="adresse.boolactif"
                                        label="existe"
                                        v-model="adresse.boolactif"
                                        color="primary"
                                        density="compact"
                                >
                                </v-switch>
                                <v-switch
                                        v-else
                                        label="-"
                                        v-model="adresse.boolactif"
                                        color="primary"
                                        density="compact"
                                >
                                </v-switch>
                            </v-col>
                        </v-row>
                        <v-row 
                            no-gutters
                            class="border border-thin"
                            v-if="lesData.idAdresseCarte == adresse.idadresse"
                        >
                            <v-col
                            >
                                <!-- géoréférencement... {{ adresse.coordoe }} , {{ adresse.coordsn }} -->
                                <div class="mapcontaineradr">
                                    <map-lausanne v-if="adresse.coordoe != null" ref="adrmap"
                                        :zoom="mapZoomAdresse"
                                        :center="[adresse.coordoe, adresse.coordsn]"
                                        :base-layer="'fonds_geo_osm_bdcad_gris'"
                                        :layers-visible="41"
                                        @map-click="handleMapClickEventAdresse"
                                    />
                                    <map-lausanne v-else ref="adrmap"
                                        :zoom="mapZoomRue"
                                        :center="[(lesData.dataThingRue.coordminoe+lesData.dataThingRue.coordmaxoe)/2.0, 
                                                  (lesData.dataThingRue.coordminsn+lesData.dataThingRue.coordmaxsn)/2.0]"
                                        :base-layer="'fonds_geo_osm_bdcad_gris'"
                                        :layers-visible="41"
                                        @map-click="handleMapClickEventAdresse"
                                    />
                                </div>
                             </v-col>
                        </v-row>
                    </v-form>
                </v-container>           
            </v-expansion-panel-text>  
        </v-expansion-panel>
    </v-expansion-panels>
 </template>

<script setup>
    import { ref, watch, nextTick} from 'vue'
    import { data } from '@/stores/data.js'
    import MapLausanne from 'ol-map-lausanne'
    import 'ol-map-lausanne/dist/style.css'
    import { getTypesRueListe } from '@/axioscalls.js'
    import { getCategoriesNomRueListe } from '@/axioscalls.js'
    import { getRueData } from '@/axioscalls.js'
    import { getRueAdressesListe } from '@/axioscalls.js'
    import { sauveAdresse } from '@/axioscalls.js'
    import { sauveRue } from '@/axioscalls.js'
    let initialData = true
    let lesData = data()
    let idTypeRue = lesData.dataThingRue.idtyperue
    let mapCenter = ref([])
    let adresse = ref({})
    let nouveauNumero = ref('')
    const adresseinit = {
        idadresse: 0,
    }
    const mapZoomAdresse = ref(9)
    const mapZoomRue = ref(7)
    const mapZoomLausanne = ref(2)
    const mapCenterLausanne = ref([2538590,1154830])
    const itemsAccesDP = ['-', 'oui', 'non']
    let bGeoRefRue = ref(false)
    let dialog = ref(false)
    let dialogText = ref('')
    let dialogTitle = ref('')
    await getTypesRueListe(lesData)
    //console.log(lesData.rueTypesListe)
    await getCategoriesNomRueListe(lesData)
    //console.log(lesData.rueCategoriesNomListe)

    let btypeRueRules
    let bnomRueRules, bnomCourtRueRules, bnomLongRueRules
    let banneeDecisionMuniRules
    let bestridRules, besidRules, bcodeRueRules
    let bcategorieNomRules
    let bcoordOEMinRules, bcoordOEMaxRules, bcoordSNMinRules, bcoordSNMaxRules
    let badrCodePostalRules, badrExtensionCPRules, begidRules, bedidRules
    let badrcoordOERules, badrcoordSNRules
    const inpNouveauNumero = ref(null)
    const typeRueRules = [
        value => {
            if (value) {
                btypeRueRules = true
                return true
            }
            btypeRueRules = false
            return `Le choix d'un type de rue est obligatoire`
        }
    ]
    const nomCourtRueRules = [
        value => {
            if (value) {
                bnomCourtRueRules = true
                return true
            }
            bnomCourtRueRules = false
            return 'Le nom court est obligatoire'
        }
    ]
    const nomLongRueRules = [
        value => {
            if (value) {
                bnomLongRueRules = true
                return true
            }
            bnomLongRueRules = false
            return 'Le nom long est obligatoire'
        }
    ]
    const nomRueRules = [
        value => {
            if (value) {
                bnomRueRules = true
                return true
            }
            bnomRueRules = false
            return 'Le nom est obligatoire'
        }
    ]
    const anneeDecisionMuniRules = [
        value => {
            if (!value) {
                banneeDecisionMuniRules = true
                return true
            }
            if (/^\+?(0|[1-9]\d*)$/.test(value)) { 
                if (value >= 1600 && value <= (new Date()).getFullYear()+1) {
                    banneeDecisionMuniRules = true    
                    return true
                }
            }
            banneeDecisionMuniRules = false
            return 'année décision municipalité invalide, 1600 < année < ' + ((new Date()).getFullYear()+1).toString()
        }
    ]
    const estridRules = [
        value => {
            if (!value) {
                bestridRules = true
                return true
            }
            if (/^\+?(0|[1-9]\d*)$/.test(value)) {
                bestridRules = true
                return true
            }
            bestridRules = false
            return 'estrid invalide, numérique ou vide'
        }
    ]
    const esidRules = [
        value => {
            if (!value) {
                besidRules = true
                return true
            }
            if (/^\+?(0|[1-9]\d*)$/.test(value)) {
                besidRules = true
                return true
            }
            besidRules = false
            return 'esid invalide, numérique ou vide'
        }
    ]
    const codeRueRules = [
        value => {
            if (!value) {
                bcodeRueRules = true
                return true
            }
            if (/^\+?(0|[1-9]\d*)$/.test(value)) {
                bcodeRueRules = true
                return true
            }
            bcodeRueRules = false
            return 'code rue invalide, numérique ou vide'
        }
    ]
    const categorieNomRules = [
        value => {
            if (value) {
                bcategorieNomRules = true
                return true
            }
            bcategorieNomRules = false
            return `Le choix d'une catégorie de nom est obligatoire`
        }
    ]
    const nouveauNumeroRule = [
        value => { 
            value = value.trim()
            if (value) {
                if (/^\+?(0|[1-9]\d*)$/.test(value)) {
                    if (value >= 0 && value <= 999) {
                        return true
                    } else {
                        return 'Le numéro est invalide, il doit être compris entre 0 et 999'
                    }
                } else {
                    const valnum = value.substring(0, value.length-1)
                    const valcar = value.substring(value.length-1)
                    if (/^\+?(0|[1-9]\d*)$/.test(valnum)) {
                        if (/[a-z]|[A-Z]/.test(valcar)) {
                            return true
                        } else {
                            return 'Le numéro est invalide, le dernier caractère non numérique doit être une lettre'
                        }
                    } else {
                        return 'Le numéro est invalide, seul le dernier caractère peut être non numérique'
                    }
                }
            }
            return 'Le numéro est obligatoire'
         }    
    ]
    const coordOEMinRules = [
    value => {
            if (!value) {
                bcoordOEMinRules = true
                return true
            }
            if (!isNaN(value)) {
                if (value > 2533500 && value < 2545400) {
                    bcoordOEMinRules = true
                    return true
                }
            }
            bcoordOEMinRules = false
            return 'coordonnée ouest-est minimum invalide'
        }    
    ]
    const coordOEMaxRules = [
    value => {
            if (!value) {
                bcoordOEMaxRules = true
                return true
            }
            if (!isNaN(value)) {
                if (value > 2533500 && value < 2545400) {
                    bcoordOEMaxRules = true
                    return true
                }
            }
            bcoordOEMaxRules = false
            return 'coordonnée ouest-est maximum invalide'
        }    
    ]
    const coordSNMinRules = [
    value => {
            if (!value) {
                bcoordSNMinRules = true
                return true
            }
            if (!isNaN(value)) {
                if (value > 1150300 && value < 1162100) {
                    bcoordSNMinRules = true
                    return true
                }
            }
            bcoordSNMinRules = false
            return 'coordonnée sud-nord minimum invalide'
        }    
    ]
    const coordSNMaxRules = [
    value => {
            if (!value) {
                bcoordSNMaxRules = true
                return true
            }
            if (!isNaN(value)) {
                if (value > 1150300 && value < 1162100) {
                    bcoordSNMaxRules = true
                    return true
                }
            }
            bcoordSNMaxRules = false
            return 'coordonnée sud-nord maximum invalide'
        }    
    ]
    const adrCodePostalRules = [
    value => {
            if (!value) {
                badrCodePostalRules = true
                return true
            }
            if (/^\+?(0|[1-9]\d*)$/.test(value)) {
                if (value >= 1000 && value < 2000) {
                    badrCodePostalRules = true
                    return true
                }
            }
            badrCodePostalRules = false
            return 'code postal  invalide'
        }    
    ]
    const adrExtensionCPRules = [
    value => {
            if (!value) {
                badrExtensionCPRules = true
                return true
            }
            if (/^\+?(0|[1-9]\d*)$/.test(value)) {
                if (value >= 1 && value <= 99) {
                    badrExtensionCPRules = true
                    return true
                }
            }
            badrExtensionCPRules = false
            return 'extension code postal invalide'
        }    
    ]
    const egidRules = [
        value => {
            if (!value) {
                begidRules = true
                return true
            }
            if (/^\+?(0|[1-9]\d*)$/.test(value)) {
                begidRules = true
                return true
            }
            begidRules = false
            return 'egid invalide, numérique ou vide'
        }
    ]
    const edidRules = [
    value => {
            if (!value) {
                bedidRules = true
                return true
            }
            if (/^\+?(0|[1-9]\d*)$/.test(value)) {
                if (value >= 0 && value <= 99) {
                    bedidRules = true
                    return true
                }
            }
            bedidRules = false
            return 'edid invalide'
        }    
    ]
    const adrcoordOERules = [
    value => {
            if (!value) {
                badrcoordOERules = true
                return true
            }
            if (!isNaN(value)) {
                if (value > 2533500 && value < 2545400) {
                    badrcoordOERules = true
                    return true
                }
            }
            badrcoordOERules = false
            return 'coordonnée ouest-est invalide'
        }    
    ]
    const adrcoordSNRules = [
    value => {
            if (!value) {
                badrcoordSNRules = true
                return true
            }
            if (!isNaN(value)) {
                if (value > 1150300 && value < 1162100) {
                    badrcoordSNRules = true
                    return true
                }
            }
            badrcoordSNRules = false
            return 'coordonnée sud-nord invalide'
        }    
    ]
   const todorules = [
        value => { return true }    
    ]

    watch(() => lesData.idThingRueChoisie, () => {
        initialData = true
        if (lesData.idThingRueChoisie == 0) {
            initData()
        }
    })
    watch(() => lesData.dataThingRue.idtyperue, () => {
        genereNoms()
    })
    watch(() => lesData.dataThingRue.article, () => {
        genereNoms()
    })
    watch(() => lesData.dataThingRue.prenom, () => {
        genereNoms()
    })
    watch(() => lesData.dataThingRue.nom, () => {
        genereNoms()
    })
    watch(() => lesData.panelexpand, () => {
        //On test si données rue et carte rue ouvert
        let nbrOuvert = 0
        if (lesData.panelexpand.length > 1) {
            for (let i=0; i<lesData.panelexpand.length; i++) {
                if (lesData.panelexpand[i] == 0 || lesData.panelexpand[i] == 1) {
                    nbrOuvert++    
                }
            }
        }
        if (nbrOuvert == 2) {
            bGeoRefRue = ref(true)
        } else {
            bGeoRefRue = ref(false)    
        }
    })

    function initData() {
        lesData.dataThingRue = ref({
            "idthing" : '0',
            "idville" : '632',
            "article" : '',
            "prenom" : '',
            "nom" : '',
            "coderue" : '',
            "estrid" : '',
            "esid" : '',
            "idtyperue" : '',
            "nomlong" : '',
            "nomcourt" : '',
            "bpublic" : '',
            "datedecisionmuni" : '',
            "idcategorienom" : '',
            "commentaire" : '',
            "coordminoe" : null,
            "coordminsn" : null,
            "coordmaxoe" : null,
            "coordmaxsn" : null,
        })
   }

    function focusSurInputGenereNom() {
        initialData = false
    }

    function genereNoms() {
        if (!initialData) {
            let typeRue = ''
            let typeRueCourt = ''
            if (lesData.dataThingRue.idtyperue != '1') {
                const oTypeRue = lesData.rueTypesListe.find( obj => obj['value'] == lesData.dataThingRue.idtyperue )
                typeRue = `${oTypeRue.title} `
                typeRueCourt = `${oTypeRue.typeruecourt} `
            }

            let article = ''
            if (lesData.dataThingRue.hasOwnProperty('article') && lesData.dataThingRue.article != null) {
                article = lesData.dataThingRue.article.trim()
            }
            if (article != '' && article.slice(-1) != "'") {
                //on ajoute un espace si ce n'est pas vide et si ça ne se fini pas pas un apostrophe
                article = `${article} `
            }

            let prenom = ''
            if (lesData.dataThingRue.hasOwnProperty('prenom') && lesData.dataThingRue.prenom != null) {
                prenom = lesData.dataThingRue.prenom.trim()
            }
            if (prenom != '' && prenom.slice(-1) != "-") {
                //on ajoute un espace si ce n'est pas vide et si ça ne se fini pas pas un tiret
                prenom = `${prenom} `
            }

            const nom = lesData.dataThingRue.nom.trim()

            lesData.dataThingRue.nomlong = `${typeRue}${article}${prenom}${nom}`
            lesData.dataThingRue.nomcourt = `${typeRueCourt}${article}${prenom}${nom}`
        }
    }

    function selectAdresseCarte(adresse) {
        let idadresse = adresse.idadresse
        if (lesData.idAdresseCarte == idadresse.toString()) {
            lesData.idAdresseCarte = ref('')
            idadresse = ''    
        } else {
            lesData.idAdresseCarte = ref(idadresse.toString())
        }
        const oEls = document.getElementsByClassName("vrowadressevisu")
        for (let i=0; i<oEls.length; i++) {
            let oEl =  oEls[i]
            if (oEl.getAttribute("goid") == idadresse) {
                oEl.style.color = "greenyellow"
            } else {
                oEl.style.color = ""    
            }
        }
    }

    function demandeEditionAdresse(adresse, index) {
        //console.log(adresse)
        const idadresse = adresse.idadresse
        lesData.indexAdresseEdition = ref(index)
        lesData.idAdresseCarte = ref(adresse.idadresse)
        lesData.idAdresseEdition = ref(adresse.idadresse)
        lesData.dataAdresseEdition = ref(adresse)
        const oEls = document.getElementsByClassName("vrowadressevisu")
        for (let i=0; i<oEls.length; i++) {
            let oEl =  oEls[i]
            oEl.style.color = ""
            if (oEl.getAttribute("goid") == idadresse) {
                oEl.scrollIntoView({ behavior: 'smooth' })
            }            
        }    
    }

    function quitteEditionAdresse(adresse) {
        lesData.messagesErreur.dataAdresse = ref('')
        lesData.indexAdresseEdition = ref(-1)
        lesData.idAdresseCarte = ref('')
        lesData.idAdresseEdition = ref('')
        nouveauNumero = ref('')
        reloadAdresseRue()
    }

    function demandeCreationAdresse() {
        lesData.idAdresseEdition = 0
        nextTick(() => {
                inpNouveauNumero.value.$el.querySelector('input').focus()
        })

    }

    async function demandeSauveAdresse(adresse)         
    {
        if (adresse.idadresse === 0 
            || (   badrCodePostalRules == true && badrExtensionCPRules == true
                && begidRules == true && bedidRules == true
                && badrcoordOERules == true && badrcoordSNRules == true)) {
            lesData.messagesErreur.dataAdresse = ref('')
            lesData.idAdresseCarte = ref('')
            lesData.idAdresseEdition = ref('')
            const dataAdresse = {
                idadresse: adresse.idadresse,
                idthingrue: lesData.idThingRueChoisie,
                bactif: 1,
                baccesdp: '',
                numero: '',
                numeroextension: '',
                codepostal: '',
                communepostale: '',
                extensioncp: '',
                egid: '',
                edid: '',
                coordoe: '',
                coordsn: '',
            }

            if (adresse.idadresse === 0) {
                //Crétion nouvelle adresse
                //on teste que le nouveau numéro est saisi
                if (nouveauNumero.value.trim() == '') {
                    dialogText.value = "il faut saisir un numéro"
                    dialogTitle.value = "Création impossible"
                    dialog.value = true
                    return
                }

                //on teste que le nouveau numéro n'est pas déjà utilisé
                let numExiste
                for (let i=0; i<lesData.dataThingRueAdresses.length; i++) {
                    if (lesData.dataThingRueAdresses[i].numeroextension == null) {
                        numExiste = `${lesData.dataThingRueAdresses[i].numero}`
                    } else {
                        numExiste = `${lesData.dataThingRueAdresses[i].numero}${lesData.dataThingRueAdresses[i].numeroextension.toLowerCase()}`
                    }
                    if (nouveauNumero.value.toLowerCase() == numExiste) {
                        nouveauNumero = ref('')
                        dialogText.value = `ce numéro ${numExiste} est déjà utilisé`
                        dialogTitle.value = "Création impossible"
                        dialog.value = true
                        return
                    }
                }

                const nNo = nouveauNumero.value    
                if (/^\+?(0|[1-9]\d*)$/.test(nNo)) {
                    dataAdresse.numero = nNo
                    dataAdresse.numeroextension = ''
                } else {
                    const valnum = nNo.substring(0, nNo.length-1)
                    const valcar = nNo.substring(nNo.length-1)
                    dataAdresse.numero = valnum
                    dataAdresse.numeroextension = valcar
                }
                nouveauNumero = ref('')
            } else {
                if (adresse.boolactif) {
                    dataAdresse.bactif = 1    
                } else {
                    dataAdresse.bactif = 0    
                }
                dataAdresse.numero = adresse.numero
                if (adresse.numeroextension !== null) {
                    dataAdresse.numeroextension = adresse.numeroextension
                }
                if (adresse.codepostal !== null) {
                dataAdresse.codepostal = adresse.codepostal
                }
                if (adresse.communepostale !== null) {
                    dataAdresse.communepostale = adresse.communepostale
                }
                if (adresse.extensioncp !== null) {
                    dataAdresse.extensioncp = adresse.extensioncp
                }
                if (adresse.egid !== null) {
                    dataAdresse.egid = adresse.egid
                }
                if (adresse.edid !== null) {
                    dataAdresse.edid = adresse.edid
                }
                if (adresse.coordoe !== null) {
                    dataAdresse.coordoe = adresse.coordoe
                }
                if (adresse.coordsn !== null) {
                    dataAdresse.coordsn = adresse.coordsn
                }
                if (adresse.accesdp !== null) {
                    if (adresse.accesdp == 'oui') {
                        dataAdresse.baccesdp = 1
                    } else if (adresse.accesdp == 'non') {
                        dataAdresse.baccesdp = 0
                    }
                }
            }
            const cuIdAdresse = dataAdresse.idadresse
            const cuNumero = dataAdresse.numero
            const cuNumeroExtension = dataAdresse.numeroextension
            let adrNumero
            let adrNumeroExtension
            lesData.messagesErreur.serverbackend = ref('')
            await sauveAdresse(lesData, dataAdresse)
            if (lesData.messagesErreur.serverbackend !== '') {
                dialogText.value = lesData.messagesErreur.serverbackend
                dialogTitle.value = "Sauvegarde impossible"
                dialog.value = true
            }
            await reloadAdresseRue()
            if (cuIdAdresse == 0) {
                const nbrAdr = lesData.dataThingRueAdresses.length
                //console.log(`${nbrAdr} ${cuNumero} ${cuNumeroExtension}`)
                for (let i=0; i<nbrAdr; i++) {
                    adrNumero = lesData.dataThingRueAdresses[i].numero
                    adrNumeroExtension = ""
                    if (lesData.dataThingRueAdresses[i].numeroextension !== null) {
                        adrNumeroExtension = lesData.dataThingRueAdresses[i].numeroextension    
                    }
                    if (adrNumero == cuNumero && adrNumeroExtension == cuNumeroExtension) {
                        demandeEditionAdresse(lesData.dataThingRueAdresses[i], i)
                        break    
                    }
                }
            }
        } else {
            lesData.messagesErreur.dataAdresse = ref('Sauvegarde refusée, donnée(s) invalide(s)')
        }
    }

    function quitteEditionRue() {
        lesData.clicGeorefRue = ref('x')
        lesData.messagesErreur.dataRue = ref('')
        if (lesData.idThingRueChoisie != '0') {
            getRueData(lesData)
        } else {
            lesData.idThingRueChoisie = ref('')    
        }
    }

    async function demandeSauveRue() {
        if ( btypeRueRules == true 
            && bnomRueRules == true && bnomCourtRueRules == true && bnomLongRueRules == true
            && banneeDecisionMuniRules == true && bcategorieNomRules == true
            && bestridRules == true && besidRules == true && bcodeRueRules == true 
            && bcoordOEMinRules == true && bcoordOEMaxRules == true && bcoordSNMinRules == true && bcoordSNMaxRules == true) {
            //console.log(JSON.stringify(lesData.dataThingRue))
            lesData.clicGeorefRue = ref('x')
            lesData.messagesErreur.dataRue = ref('')
            const dataRue = {
                idthing: lesData.idThingRueChoisie,
                idville: '',
                idtyperue: '',
                idcategorienom: '',
                bpublic: '',
                datedecisionmuni: '',
                article: '',
                prenom: '',
                nom: '',
                nomlong: '',
                nomcourt: '',
                coderue: '',
                estrid: '',
                esid: '',
                commentaire: '',
                coordminoe: '',
                coordminsn: '',
                coordmaxoe: '',
                coordmaxsn: '',
            }
            const rue = lesData.dataThingRue
            if (rue.idville !== null) {
                dataRue.idville = rue.idville
            } else {
                dataRue.idville = '632' //Lausanne    
            }
            dataRue.idtyperue = rue.idtyperue
            dataRue.idcategorienom = rue.idcategorienom
            if (rue.bpublic !== null) {
                dataRue.bpublic = rue.bpublic
            } else {
                dataRue.bpublic = ''    
            }
            if (rue.datedecisionmuni !== null) {
                dataRue.datedecisionmuni = rue.datedecisionmuni
            } else {
                dataRue.datedecisionmuni = ''    
            }
            if (rue.article !== null) {
                dataRue.article = rue.article
            } else {
                dataRue.article = ''    
            }
            if (rue.prenom !== null) {
                dataRue.prenom = rue.prenom
            } else {
                dataRue.prenom = ''    
            }
            dataRue.nom = rue.nom
            dataRue.nomlong = rue.nomlong
            dataRue.nomcourt = rue.nomcourt
            if (rue.coderue !== null) {
                dataRue.coderue = rue.coderue
            } else {
                dataRue.coderue = ''    
            }
            if (rue.estrid !== null) {
                dataRue.estrid = rue.estrid
            } else {
                dataRue.estrid = ''    
            }
            if (rue.esid !== null) {
                dataRue.esid = rue.esid
            } else {
                dataRue.esid = ''    
            }
            if (rue.commentaire !== null) {
                dataRue.commentaire = rue.commentaire
            } else {
                dataRue.commentaire = ''    
            }
            if (rue.coordminoe !== null) {
                dataRue.coordminoe = rue.coordminoe
            } else {
                dataRue.coordminoe = ''    
            }
            if (rue.coordminsn !== null) {
                dataRue.coordminsn = rue.coordminsn
            } else {
                dataRue.coordminsn = ''    
            }
            if (rue.coordmaxoe !== null) {
                dataRue.coordmaxoe = rue.coordmaxoe
            } else {
                dataRue.coordmaxoe = ''    
            }
            if (rue.coordmaxsn !== null) {
                dataRue.coordmaxsn = rue.coordmaxsn
            } else {
                dataRue.coordmaxsn = ''    
            }
 
            //console.log("dataRue")
            //console.log(dataRue)
            lesData.messagesErreur.serverbackend = ref('')
            await sauveRue(lesData, dataRue)
            if (lesData.messagesErreur.serverbackend !== '') {
                dialogText.value = lesData.messagesErreur.serverbackend
                dialogTitle.value = "Sauvegarde impossible"
                dialog.value = true
            }
            getRueData(lesData)
        } else {
            lesData.messagesErreur.dataRue = ref('Sauvegarde refusée, donnée(s) invalide(s)')
        }
    }

    async function reloadAdresseRue() {
        await getRueAdressesListe(lesData)
        lesData.idAdresseCarte = ref('')
        lesData.idAdresseEdition = ref('') 
        //console.log(lesData.dataThingRueAdresses)
    }

    const handleMapClickEventAdresse = (e) => {
        if (lesData.idAdresseEdition !== '') {
            //console.log(`map-click event x: ${e.x}, y: ${e.y}`);
            lesData.dataThingRueAdresses[lesData.indexAdresseEdition].coordoe = ref(e.x)
            lesData.dataThingRueAdresses[lesData.indexAdresseEdition].coordsn = ref(e.y)
        }
    }

    const handleMapClickEventRue = (e) => {
        //console.log(`map-click event x: ${e.x}, y: ${e.y}`)
        //console.log(lesData.clicGeorefRue)
        switch (lesData.clicGeorefRue) {
            case "minOE":
                lesData.dataThingRue.coordminoe = ref(e.x)
                break
            case 'minOEminSN':
                lesData.dataThingRue.coordminoe = ref(e.x)
                lesData.dataThingRue.coordminsn = ref(e.y)
                break
            case 'minSN':
                lesData.dataThingRue.coordminsn = ref(e.y)
                break
            case "maxOE":
                lesData.dataThingRue.coordmaxoe = ref(e.x)
                break
            case 'maxOEmaxSN':
                lesData.dataThingRue.coordmaxoe = ref(e.x)
                lesData.dataThingRue.coordmaxsn = ref(e.y)
                break
            case 'maxSN':
                lesData.dataThingRue.coordmaxsn = ref(e.y)
                break
        } 
    }

</script>