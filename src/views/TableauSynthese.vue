<template>
  <div
    class="min-h-screen bg-[#f3f2ef] font-sans text-[#000000e6] font-family: Verdana, Geneva, Tahoma, sans-serif; p-4 md:p-8"
  >

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div
      class="max-w-[1400px] mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4"
    >

      <div class="flex items-center gap-3">

        <div class="bg-transparent p-2 rounded hidden xs:block">
          <i class="ph ph-layout text-[#060b24] text-xl md:text-2xl"></i>
        </div>

        <div>
          <h1 class="text-lg md:text-xl font-bold tracking-tight leading-tight">
            Tableau de Synthèse Professionnelle
          </h1>

          <p class="text-[10px] md:text-[11px] text-gray-500 font-medium">
            Session BTS 2026 - Mis à jour le {{ miseAjourTotale }}
          </p>
        </div>

      </div>


      <button
        @click="imprimerPage"
        class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-xs text-xs md:text-sm font-medium hover:bg-gray-50 shadow-sm"
      >
        <i class="ph ph-printer"></i>
        Imprimer en PDF
      </button>

    </div>


    <!-- ===================================================== -->
    <!-- CONTENU PRINCIPAL -->
    <!-- ===================================================== -->

    <div
      class="max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6"
    >

      <!-- ================================================= -->
      <!-- COLONNE PRINCIPALE -->
      <!-- ================================================= -->

      <div class="lg:col-span-9 space-y-6">


        <!-- ================================================= -->
        <!-- SKELETON : CARTE PROFIL -->
        <!-- ================================================= -->

        <div
          v-if="loading"
          class="bg-white rounded-xs border border-gray-200 overflow-hidden shadow-sm animate-pulse"
        >

          <div class="h-20 bg-gray-200"></div>

          <div class="px-8 pb-6">

            <div class="flex justify-between items-start -mt-10">

              <div class="h-20 w-20 bg-gray-200 rounded-lg"></div>

              <div class="mt-12 h-8 w-40 bg-gray-200 rounded"></div>

            </div>

            <div class="mt-4 space-y-2">

              <div class="h-6 w-48 bg-gray-200 rounded"></div>

              <div class="h-4 w-72 bg-gray-200 rounded"></div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- CARTE PROFIL -->
        <!-- ================================================= -->

        <div
          v-else
          class="image-insert bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm"
        >

          <div class="h-20 bg-transparent"></div>

          <div class="px-8 pb-6">

            <div class="flex justify-between items-start -mt-10">

              <div class="bg-transparent p-1 rounded-x border-gray-200">

                <div
                  class="bg-transparent h-30 w-30 rounded-xs flex items-center justify-center border-gray-100"
                >

                  <img
                    src="../assets/ezechiel_photo.png"
                    alt="Photo de profil"
                    class="h-full w-full object-cover rounded-x"
                  />

                </div>

              </div>


              <div class="mt-12 flex justify-end">

                <a
                  :href="'https://' + profile.url"
                  target="_blank"
                  class="flex items-center gap-2 px-3 py-2 bg-white text-black font-medium rounded-xs text-[11px] md:text-sm border border-transparent hover:bg-white transition-colors max-w-[180px] md:max-w-none shadow-sm truncate"
                >

                  <i
                    class="ph ph-google-chrome-logo text-[#060b24] text-xl md:text-2xl"
                  ></i>

                  <span class="truncate">
                    {{ profile.url }}
                  </span>

                </a>

              </div>

            </div>


            <div class="mt-4">

              <h2
                class="text-xl md:text-2xl font-bold text-black capitalize"
              >
                {{ profile.nom }}
              </h2>


              <div
                class="flex flex-wrap items-center gap-x-3 gap-y-3 mt-2 text-xs md:text-sm text-gray-600 bg-transparent px-3 py-2 rounded-xs shadow-sm"
              >

                <span
                  class="font-semibold text-gray-800 whitespace-nowrap"
                >
                  Candidat n°{{ profile.candidat }}
                </span>


                <span class="hidden sm:inline text-gray-300">
                  |
                </span>


                <span class="whitespace-nowrap">
                  Option
                  <b class="text-[#060b24]">
                    {{ profile.option }}
                  </b>
                </span>


                <span class="hidden sm:inline text-gray-300">
                  |
                </span>


                <span class="flex items-center gap-1 whitespace-nowrap">

                  <i
                    class="ph ph-buildings text-[#060b24] text-lg"
                  ></i>

                  Efrei Paris

                </span>


                <span class="hidden lg:inline text-gray-300">
                  |
                </span>


                <button
                  @click="showExcelPreview = true"
                  class="flex items-center gap-1.5 px-3 py-1.5 bg-[#1d6f42] text-white rounded-xs text-[10px] md:text-[11px] font-bold hover:bg-opacity-90 transition-all shadow-sm"
                >

                  <i class="ph ph-file-xls text-base"></i>

                  Version Excel

                </button>


                <p
                  class="w-full text-gray-500 text-[10px] mt-1 lowercase tracking-tighter italic"
                >

                  <i
                    class="ph ph-info text-[#2e4ff2] text-base"
                  ></i>

                  Vous avez accès à la version Excel du tableau de synthèse

                </p>

              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- SKELETON : TABLEAU -->
        <!-- ================================================= -->

        <div
          v-if="loading"
          class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden animate-pulse"
        >

          <div
            class="p-5 border-b border-gray-100 bg-gray-50/50"
          >

            <div class="h-5 w-64 bg-gray-200 rounded"></div>

          </div>


          <div class="p-6 space-y-4">

            <!-- Header skeleton -->

            <div class="flex gap-4">

              <div
                class="h-4 w-1/4 bg-gray-200 rounded"
              ></div>

              <div
                class="h-4 w-16 bg-gray-200 rounded"
              ></div>

              <div
                v-for="i in 6"
                :key="i"
                class="h-4 flex-1 bg-gray-200 rounded"
              ></div>

            </div>


            <!-- Rows skeleton -->

            <div
              v-for="i in 5"
              :key="i"
              class="flex gap-4 items-center py-3 border-t border-gray-100"
            >

              <div
                class="h-4 w-1/4 bg-gray-100 rounded"
              ></div>

              <div
                class="h-4 w-16 bg-gray-100 rounded"
              ></div>

              <div
                v-for="j in 6"
                :key="j"
                class="flex-1 flex justify-center"
              >

                <div
                  class="h-4 w-4 bg-gray-100 rounded-full"
                ></div>

              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- TABLEAU RÉEL -->
        <!-- ================================================= -->

        <div
          v-else
          class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden"
        >

          <!-- Titre -->

          <div
            class="p-5 border-b border-gray-100 bg-gray-50/50"
          >

            <h3
              class="font-bold text-gray-800 flex items-center gap-2"
            >

              <i
                class="ph ph-list-checks text-[#060b24]"
              ></i>

              Tableau de Synthèse des Réalisations et Compétences

            </h3>

          </div>


          <!-- ================================================= -->
          <!-- TABLE -->
          <!-- ================================================= -->

          <div class="overflow-x-auto">

            <table
              class="w-full text-[13px] border-collapse"
            >

              <thead>

                <tr
                  class="bg-white text-gray-500 text-[10px] capitalize tracking-wider"
                >

                  <!-- Réalisation -->

                  <th
                    class="px-6 py-4 text-left font-black border-b border-r border-gray-100 w-1/4"
                  >
                    Réalisation
                  </th>


                  <!-- Période -->

                  <th
                    class="px-4 py-4 text-center font-black border-b border-r border-gray-100 w-24"
                  >
                    Période
                  </th>


                  <!-- ================================================= -->
                  <!-- COMPÉTENCES -->
                  <!--
                    Les icônes ont volontairement été supprimées ici.
                    Les intitulés restent simples et sobres.
                  -->
                  <!-- ================================================= -->

                  <th
                    v-for="skill in skillLabelsFull"
                    :key="skill"
                    class="px-2 py-4 text-center border-b border-r border-gray-100 bg-blue-50/30 text-[#060b24] lowercase first-letter:uppercase font-family: Verdana, Geneva, Tahoma, sans-serif; leading-tight min-w-[100px]"
                  >
                    {{ skill }}
                  </th>

                </tr>

              </thead>


              <tbody class="divide-y divide-gray-100">


                <!-- ================================================= -->
                <!-- AUCUNE DONNÉE -->
                <!-- ================================================= -->

                <tr v-if="realisations.length === 0">

                  <td
                    :colspan="2 + skillLabelsFull.length"
                    class="px-6 py-20 text-center"
                  >

                    <div
                      class="flex flex-col items-center gap-3 opacity-40"
                    >

                      <i
                        class="ph ph-folder-open text-5xl"
                      ></i>

                      <p
                        class="text-xs font-light lowercase tracking-widest italic"
                      >
                        aucune compétence n'a été rajoutée pour le moment.
                      </p>

                    </div>

                  </td>

                </tr>


                <!-- ================================================= -->
                <!-- RÉALISATIONS -->
                <!-- ================================================= -->

                <tr
                  v-else
                  v-for="real in realisations"
                  :key="real.id"
                  class="hover:bg-blue-50/20 transition-colors"
                >

                  <!-- Réalisation -->

                  <td
                    class="px-6 py-6 border-r border-gray-50"
                  >

                    <p
                      class="font-bold text-gray-900 leading-relaxed"
                    >
                      {{ real.libelle }}
                    </p>

                  </td>


                  <!-- Période -->

                  <td
                    class="px-4 py-6 text-center text-gray-500 font-medium border-r border-gray-50 italic whitespace-nowrap"
                  >
                    {{ real.periode }}
                  </td>


                  <!-- Compétences -->

                  <td
                    v-for="(check, i) in real.competences"
                    :key="i"
                    class="px-2 py-6 border-r border-gray-50 last:border-r-0"
                  >

                    <!-- Compétence validée -->

                    <div
                      v-if="check"
                      class="flex justify-center"
                    >

                      <span
                        class="text-[#060b24] font-black text-xs"
                      >

                        <i
                          class="ph ph-check-circle text-lg text-[#00ba2b]"
                        ></i>

                      </span>

                    </div>


                    <!-- Compétence non validée -->

                    <div
                      v-else
                      class="h-1.5 w-1.5 rounded-full bg-gray-200 mx-auto"
                    ></div>

                  </td>

                </tr>

              </tbody>

            </table>

          </div>


          <!-- ================================================= -->
          <!-- ACTIONS DU TABLEAU -->
          <!-- ================================================= -->

          <div
            class="p-6 bg-gray-50/30 border-t border-gray-100 flex flex-col items-center gap-4"
          >

            <a
              href="https://penguin.tailc4a1d9.ts.net"
              class="flex items-center gap-2 px-4 py-2 bg-[#060b24] text-white rounded-xs font-light text-sm hover:bg-opacity-90 transition-all shadow-md"
            >

              <i
                class="ph ph-plus-circle text-base"
              ></i>

              Ajouter des compétences

            </a>


            <div
              class="flex items-center gap-2 text-gray-400 max-w-md text-center"
            >

              <i
                class="ph ph-shield-check text-lg text-blue-600"
              ></i>

              <p
                class="text-[9px] leading-relaxed italic lowercase font-light"
              >
                l'ajout des compétences est accessible uniquement aux
                personnes habilitées à le faire pour des raisons de sécurité
                et d'intégrité des données professionnelles.
              </p>

            </div>

          </div>

        </div>

      </div>


      <!-- ===================================================== -->
      <!-- COLONNE PREUVES & DOCUMENTS -->
      <!-- ===================================================== -->

      <div class="lg:col-span-3 space-y-6">


        <!-- ================================================= -->
        <!-- SKELETON : DOCUMENTS -->
        <!-- ================================================= -->

        <div
          v-if="loading"
          class="bg-white rounded border border-gray-200 shadow-sm animate-pulse"
        >

          <div
            class="p-4 border-b border-gray-100"
          >

            <div
              class="h-5 w-40 bg-gray-200 rounded"
            ></div>

          </div>


          <div class="p-3 space-y-3">

            <div
              v-for="i in 5"
              :key="i"
              class="p-3 flex items-center gap-3"
            >

              <div
                class="h-8 w-8 bg-gray-200 rounded"
              ></div>

              <div
                class="flex-1 space-y-2"
              >

                <div
                  class="h-3 w-3/4 bg-gray-200 rounded"
                ></div>

                <div
                  class="h-2 w-1/2 bg-gray-100 rounded"
                ></div>

              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- DOCUMENTS RÉELS -->
        <!-- ================================================= -->

        <div
          v-else
          class="bg-white rounded border border-gray-200 shadow-sm sticky top-8"
        >

          <!-- Header -->

          <div
            class="p-4 border-b border-gray-100"
          >

            <h3
              class="font-light text-gray-800 text-sm flex items-center gap-2"
            >

              <i
                class="ph ph-folder-open text-[#060b24] text-xl"
              ></i>

              Preuves & Documents

            </h3>

          </div>


          <!-- ================================================= -->
          <!-- LISTE DES DOCUMENTS -->
          <!-- ================================================= -->

          <div class="p-3 space-y-2">

            <div
              v-for="doc in docs"
              :key="doc.id"
              class="group p-3 rounded-xs border border-transparent hover:border-gray-200 hover:bg-[#f3f4f6] transition-all"
            >

              <div class="flex items-start gap-3">


                <!-- ================================================= -->
                <!-- ICÔNE DE LA COMPÉTENCE -->
                <!-- ================================================= -->

                <div
                  class="flex-shrink-0 w-9 h-9 rounded-lg bg-white border border-gray-100 shadow-sm flex items-center justify-center"
                >

                  <i
                    :class="[
                      'ph',
                      doc.icon,
                      doc.iconColor,
                      'text-xl'
                    ]"
                  ></i>

                </div>


                <!-- ================================================= -->
                <!-- INFORMATIONS -->
                <!-- ================================================= -->

                <div
                  class="flex-1 min-w-0"
                >

                  <h4
                    class="text-xs font-bold text-gray-900 truncate"
                  >
                    {{ doc.nom }}
                  </h4>


                  <p
                    class="text-[9px] text-gray-500 mt-0.5 leading-tight"
                  >
                    {{ doc.competence }}
                  </p>


                  <!-- Actions -->

                  <div
                    class="flex items-center gap-3 mt-2"
                  >

                    <router-link
                      :to="doc.path"
                      class="text-[10px] font-bold text-blue-600 hover:underline flex items-center gap-1"
                    >

                      <i
                        class="ph ph-eye"
                      ></i>

                      Consulter

                    </router-link>


                    <span
                      class="text-gray-300"
                    >
                      |
                    </span>


                    <a
                      :href="doc.lien"
                      download
                      class="text-[10px] font-light text-gray-500 hover:text-red-700 flex items-center gap-1"
                    >

                      <i
                        class="ph ph-download-simple"
                      ></i>

                      PDF

                    </a>

                  </div>


                  <!-- Date -->

                  <p
                    class="text-[9px] text-gray-400 mt-1 uppercase tracking-tighter italic"
                  >
                    Mis à jour le {{ doc.date }}
                  </p>

                </div>


                <!-- ================================================= -->
                <!-- INDICATEUR PDF -->
                <!-- ================================================= -->

                <div
                  class="flex-shrink-0 pt-1 opacity-70 group-hover:opacity-100 transition-opacity"
                  title="Document PDF"
                >

                  <i
                    class="ph ph-file-pdf text-red-500 text-lg"
                  ></i>

                </div>

              </div>

            </div>

          </div>


          <!-- ================================================= -->
          <!-- VOIR PLUS DE DOCUMENTS -->
          <!-- ================================================= -->

          <div
            class="px-3 pb-3 pt-1"
          >

            <router-link
              to="/documents"
              class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-50 border border-gray-200 text-[#060b24] rounded-xs text-[11px] font-bold hover:bg-[#060b24] hover:text-white transition-all"
            >

              <i
                class="ph ph-folder-open text-base"
              ></i>

              Voir plus de documents

              <i
                class="ph ph-arrow-right text-sm"
              ></i>

            </router-link>

          </div>

        </div>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- MODAL EXCEL -->
    <!-- ===================================================== -->

    <div
      v-if="showExcelPreview"
      class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
    >

      <div
        class="bg-white w-full max-w-6xl h-[90vh] rounded-xs shadow-2xl flex flex-col overflow-hidden"
      >

        <!-- Header modal -->

        <div
          class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50"
        >

          <div
            class="flex items-center gap-2"
          >

            <i
              class="ph ph-file-xls text-[#1d6f42] text-2xl"
            ></i>

            <h3
              class="font-bold text-gray-800"
            >
              Aperçu du Tableau de Synthèse (Excel)
            </h3>

          </div>


          <button
            @click="showExcelPreview = false"
            class="text-gray-400 hover:text-red-500 transition-colors"
          >

            <i
              class="ph-bold ph-x text-xl"
            ></i>

          </button>

        </div>


        <!-- Excel -->

        <div
          class="flex-1 bg-gray-100 relative"
        >

          <iframe
            title="Visualisation du tableau de synthèse des compétences"
            :src="'https://view.officeapps.live.com/op/view.aspx?src=' + encodeURIComponent('https://www.ezechielkouakou.fr/docs/classeur_competences.xlsx')"
            class="w-full h-full border-none"
            allowfullscreen
          >
          </iframe>

        </div>


        <!-- Footer -->

        <div
          class="p-4 bg-gray-50 border-t border-gray-100 text-right"
        >

          <button
            @click="showExcelPreview = false"
            class="px-6 py-2 bg-[#060b24] text-white rounded-xs font-light text-xs hover:bg-opacity-90"
          >
            Fermer l'aperçu
          </button>

        </div>

      </div>

    </div>

  </div>
</template>


<script setup>

import { ref, onMounted } from 'vue';


/* ===================================================== */
/* DATE / HEURE */
/* ===================================================== */

const dateAujourdhui = new Date().toLocaleDateString(
  'fr-FR',
  {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  }
);


const heureActuelle = new Date().toLocaleTimeString(
  'fr-FR',
  {
    hour: '2-digit',
    minute: '2-digit'
  }
);


const miseAjourTotale = ref(
  `${dateAujourdhui} à ${heureActuelle}`
);


/* ===================================================== */
/* COMPÉTENCES */
/* ===================================================== */

/*
 * Les icônes ne sont volontairement PAS utilisées
 * dans le tableau de synthèse.
 *
 * Elles sont conservées uniquement dans la partie
 * "Preuves & Documents".
 */

const skillLabelsFull = [

  "Gérer le patrimoine informatique",

  "Répondre aux incidents",

  "Développer la présence en ligne",

  "Travailler en mode projet",

  "Mettre à disposition un service",

  "Organiser son développement pro"

];


/* ===================================================== */
/* PROFIL */
/* ===================================================== */

const profile = ref({
  nom: '',
  candidat: '',
  option: 'SISR',
  url: ''
});


/* ===================================================== */
/* DONNÉES DU TABLEAU */
/* ===================================================== */

const realisations = ref([]);

const loading = ref(true);

const showExcelPreview = ref(false);


/* ===================================================== */
/* DOCUMENTS */
/* ===================================================== */

const docs = ref([

  {
    id: 1,
    nom: "Compétence - 01",
    competence: "Gérer le patrimoine informatique",
    icon: "ph-desktop",
    iconColor: "text-blue-600",
    path: "/doc/competence01",
    lien: "/docs/Competence01.pdf",
    date: dateAujourdhui
  },

  {
    id: 2,
    nom: "Compétence - 07",
    competence: "Répondre aux incidents",
    icon: "ph-wrench",
    iconColor: "text-orange-500",
    path: "/doc/competence07",
    lien: "/docs/Competence07.pdf",
    date: dateAujourdhui
  },

  {
    id: 3,
    nom: "Compétence - 11",
    competence: "Développer la présence en ligne",
    icon: "ph-globe",
    iconColor: "text-purple-600",
    path: "/doc/competence11",
    lien: "/docs/Competence11.pdf",
    date: dateAujourdhui
  },

  {
    id: 4,
    nom: "Compétence - 14",
    competence: "Travailler en mode projet",
    icon: "ph-kanban",
    iconColor: "text-indigo-600",
    path: "/doc/competence14",
    lien: "/docs/Competence14.pdf",
    date: dateAujourdhui
  },

  {
    id: 5,
    nom: "Compétence - 17",
    competence: "Mettre à disposition un service",
    icon: "ph-cloud-check",
    iconColor: "text-cyan-500",
    path: "/doc/competence17",
    lien: "/docs/Competence17.pdf",
    date: dateAujourdhui
  }

]);


/* ===================================================== */
/* RÉCUPÉRATION DES DONNÉES */
/* ===================================================== */

const fetchData = async () => {

  loading.value = true;

  try {

    const response = await fetch(
      'https://www.ezechielkouakou.fr/api_proxy.php'
    );

    if (!response.ok) {
      throw new Error('Erreur Proxy Azure');
    }

    const data = await response.json();


    if (data.success) {

      profile.value = {

        nom: data.profile.nom,

        candidat: data.profile.candidat,

        option: data.profile.option_bts,

        url: data.profile.url_portfolio

      };


      realisations.value = data.realisations;

    }

  } catch (e) {

    console.error(
      "Erreur de récupération via le proxy :",
      e
    );

  } finally {

    setTimeout(
      () => {
        loading.value = false;
      },
      1000
    );

  }

};


/* ===================================================== */
/* IMPRESSION */
/* ===================================================== */

const imprimerPage = () => {

  window.print();

};


/* ===================================================== */
/* INITIALISATION */
/* ===================================================== */

onMounted(fetchData);

</script>


<style scoped>

@import url(
  "https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css"
);

@import url(
  "https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
);


/* ===================================================== */
/* POLICE */
/* ===================================================== */

.min-h-screen {

  font-family:
    Verdana,
    Geneva,
    Tahoma,
    sans-serif;

}


/* ===================================================== */
/* BANNIÈRE */
/* ===================================================== */

.image-insert {

  background:

    linear-gradient(
      to right,
      white 0%,
      rgba(255, 255, 255, 0.926) 35%,
      rgba(255,255,255,0) 60%
    ),

    url(../assets/image-backg.jpg)
    no-repeat
    center center / cover;

}


/* ===================================================== */
/* ANIMATION SKELETON */
/* ===================================================== */

@keyframes pulse {

  0%,
  100% {
    opacity: 1;
  }

  50% {
    opacity: 0.4;
  }

}


.animate-pulse {

  animation:
    pulse
    1.5s
    ease-in-out
    infinite;

}


@media print {

  .lg\:col-span-3,
  button {

    display: none !important;

  }


  .lg\:col-span-9 {

    width: 100% !important;

    grid-column:
      span 12 /
      span 12 !important;

  }


  .max-w-\[1400px\] {

    max-width: 100% !important;

  }


  .bg-\[#f3f2ef\] {

    background: white !important;

  }

}

</style>