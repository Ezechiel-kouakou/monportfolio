<template>
  <div class="min-h-screen bg-[#f3f2ef] font-sans text-[#000000e6]">
    
    <div class="bg-white border-b border-gray-200 shadow-sm overflow-hidden">
      <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row items-stretch">
        <div class="flex-1 px-4 md:px-8 py-16 md:py-24 space-y-6 self-center">
          <div class="inline-flex items-center gap-2 px-3 py-4 bg-transparent text-[#060b24] rounded-xs border-blue-100 text-[15px] md:text-[11px] font-light capitalize tracking-wider">
            <i class="ph ph-stack text-[25px] text-blue-400"></i> Ezechiel Kouakou Media Hub
          </div>
          <div class="w-16 h-1 bg-gradient-to-r from-[#060b24] to-transparent rounded-full"></div>
          <p class="text-[11px] text-amber-800 text-center font-medium">
            <i class="ph ph-warning-circle"></i> 
            Note : Pour visionner les vidéos sur Google Chrome, veuillez autoriser l'accès au réseau privé ou utiliser Edge/Safari.
          </p>
          <h1 class="text-3xl md:text-5xl font-black text-gray-900 leading-[1.1] tracking-tight">
            Médiathèque Technique <br>
          </h1>
          <p class="text-sm md:text-base text-gray-500 max-w-xl leading-relaxed">
            « Créé par les étudiants, fait pour les étudiants. » <br>
            Découvrez mes démonstrations de projets et présentations professionnelles, 
            hébergées sur mon infrastructure hybride Penguin(Linux Crostini) & Azure.
          </p>
          <div class="flex items-center gap-4 pt-2">
            <router-link to="/tableau-synthese" class="px-6 py-2.5 bg-[#060b24] text-white text-xs font-bold rounded-xs hover:bg-opacity-90 transition-all shadow-md flex items-center gap-2">
              <i class="ph ph-layout"></i> Voir les compétences
            </router-link>
          </div>
        </div>

        <div class="flex-1 relative min-h-[300px] md:min-h-full">
          <img src="../assets/image_host_self.jpg" alt="Illustration Mediatheque" class="absolute inset-0 w-full h-full object-cover object-center" />
          <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent pointer-events-none md:hidden"></div>
        </div>
      </div>
    </div>

    <main class="max-w-[1400px] mx-auto p-4 md:p-8 mt-4">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-9 space-y-8">

          <div v-if="loading" class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden animate-pulse">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
              <div class="h-5 w-5 bg-gray-200 rounded"></div>
              <div class="h-5 w-48 bg-gray-200 rounded"></div>
            </div>
            <div class="p-6">
              <div class="h-4 w-32 bg-gray-200 rounded mb-4"></div>
              <div class="aspect-video bg-gray-200 rounded-xs"></div>
              <div class="mt-6 space-y-2">
                <div class="h-6 w-56 bg-gray-200 rounded"></div>
                <div class="h-4 w-full bg-gray-100 rounded"></div>
                <div class="h-4 w-3/4 bg-gray-100 rounded"></div>
                <div class="h-3 w-24 bg-gray-100 rounded mt-2"></div>
              </div>
            </div>
          </div>

          <!-- VIDÉO PRINCIPALE -->
          <div v-else class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
              <i class="ph ph-identification-card text-[#060b24] text-xl"></i>
              <h3 class="font-bold text-gray-800">Présentation Professionnelle</h3>
            </div>
            <div class="p-6">
              <div v-if="presentationVideo">
                <div class="mb-4">
                  <span v-if="presentationVideo.mode_suppression === '15j'"
                        :class="presentationVideo.jours_restants <= 3 ? 'text-red-800 font-light animate-pulse' : 'text-amber-700'" 
                        class="text-[10px] flex items-center gap-1.5 bg-transparent px-3 py-1 w-fit">
                    <i class="ph-fill ph-hourglass-high"></i>
                    Suppression automatique dans {{ presentationVideo.jours_restants }} jours
                  </span>
                  <span v-else class="text-blue-700 text-[10px] flex items-center gap-1.5 bg-blue-50/50 px-3 py-1 rounded-xs w-fit">
                    <i class="ph-fill ph-shield-check"></i>
                    Conservation permanente
                  </span>
                </div>
                <div class="aspect-video bg-black rounded-xs overflow-hidden border border-gray-200 shadow-inner relative group">
                  
                  <div v-if="videoStates[presentationVideo.id]?.isWaiting && !videoStates[presentationVideo.id]?.hasError" 
                       class="absolute inset-0 bg-black/70 z-10 flex flex-col items-center justify-center text-center p-4 transition-all">
                    <div class="w-8 h-8 border-2 border-blue-400 border-t-transparent rounded-full animate-spin mb-3"></div>
                    <p class="text-xs text-white font-light tracking-wide animate-pulse">Merci de patienter, nous chargeons votre vidéo...</p>
                  </div>

                  <div v-if="videoStates[presentationVideo.id]?.hasError" 
                       class="absolute inset-0 bg-[#0f111a] z-10 flex flex-col items-center justify-center text-center p-6 transition-all border border-red-900/30">
                    <div class="w-12 h-12 bg-red-950/40 rounded-full flex items-center justify-center mb-3 border border-red-900/50">
                      <i class="ph ph-warning text-xl text-red-400"></i>
                    </div>
                    <h5 class="text-white font-medium text-xs">Échec du téléchargement</h5>
                    <p class="text-[10px] text-gray-400 mt-1 max-w-[250px] leading-relaxed">
                      Impossible de charger le média. Le serveur de streaming est momentanément indisponible.
                    </p>
                    <button @click="retryVideo(presentationVideo)" class="mt-4 px-3 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 text-[10px] rounded-xs transition-all flex items-center gap-1">
                      <i class="ph ph-arrows-clockwise"></i> Réessayer
                    </button>
                  </div>

                  <video :key="presentationVideo.nom_fichier" 
                         controls 
                         class="w-full h-full" 
                         crossorigin="anonymous"
                         @waiting="handleVideoWaiting(presentationVideo.id)"
                         @playing="handleVideoPlaying(presentationVideo.id)"
                         @error="handleVideoError(presentationVideo.id)"
                         @stalled="handleVideoWaiting(presentationVideo.id)">
                    <source :src="presentationVideo.nom_fichier" type="video/mp4">
                  </video>
                </div>
                <div class="mt-6">
                  <h2 class="text-xl font-black text-gray-900 capitalize">{{ presentationVideo.titre }}</h2>
                  <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ presentationVideo.description }}</p>
                  <p class="text-[8px] text-gray-400 mt-3 lowercase tracking-wide">
                    <i class="ph ph-calendar-blank"></i> publiée le {{ new Date(presentationVideo.date_creation).toLocaleDateString('fr-FR') }}
                  </p>
                  
                  <!-- BTN COMMENTAIRES UNIQUE -->
                  <div class="mt-4 pt-4 border-t border-gray-100">
                    <button @click="toggleComments(presentationVideo.id)" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1.5 transition-colors">
                      <i class="ph ph-chat-centered-text text-base"></i>
                      {{ activeCommentVideoId === presentationVideo.id ? 'Masquer les retours' : 'Laisser un commentaire / retour d\'expérience' }}
                    </button>
                  </div>

                  <!-- ZONE DE COMMENTAIRES DE LA VIDÉO PRINCIPALE -->
                  <div v-if="activeCommentVideoId === presentationVideo.id" class="mt-4 bg-gray-50 p-4 rounded-xs border border-gray-200 space-y-4 animate-fade-in">
                    <h4 class="text-xs font-bold text-gray-800">Espace Commentaires & Feedback</h4>
                    
                    <!-- Liste des commentaires existants -->
                    <div v-if="comments[presentationVideo.id]?.length" class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
                      <div v-for="c in comments[presentationVideo.id]" :key="c.id" class="bg-white p-3 rounded border border-gray-100 shadow-xs space-y-2">
                        <div class="flex items-center justify-between">
                          <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">🎮 {{ c.pseudo }}</span>
                          <span class="text-[9px] text-gray-400">{{ formatCommentDate(c.date_creation) }}</span>
                        </div>
                        <p class="text-xs text-gray-700 leading-relaxed">{{ c.contenu }}</p>
                        
                        <!-- Liste des réponses imbriquées -->
                        <div v-if="c.replies && c.replies.length" class="pl-4 border-l-2 border-gray-200 mt-2 space-y-2">
                          <div v-for="reply in c.replies" :key="reply.id" class="bg-gray-50 p-2 rounded text-[11px] space-y-1">
                            <div class="flex items-center justify-between">
                              <span class="font-bold text-gray-800">👑 {{ reply.pseudo }}</span>
                              <span class="text-[8px] text-gray-400">{{ formatCommentDate(reply.date_creation) }}</span>
                            </div>
                            <p class="text-gray-600">{{ reply.contenu }}</p>
                          </div>
                        </div>

                        <!-- Formulaire pour répondre -->
                        <div class="pt-1">
                          <button @click="setReplyTo(c.id)" class="text-[10px] text-gray-500 hover:text-blue-600 flex items-center gap-1 font-medium">
                            <i class="ph ph-arrow-bend-down-right"></i> Répondre
                          </button>
                          
                          <div v-if="replyingToId === c.id" class="mt-2 pl-4 space-y-2">
                            <div class="flex flex-col sm:flex-row gap-2">
                              <select v-model="newComment.pseudo" class="text-xs bg-white border border-gray-300 rounded px-2 py-1 flex-1">
                                <option value="" disabled>Sélectionner un pseudonyme</option>
                                <option v-for="p in kahootPseudos" :key="p" :value="p">{{ p }}</option>
                              </select>
                              <input v-model="newComment.customPseudo" type="text" placeholder="Ou tapez votre propre pseudo" class="text-xs border border-gray-300 rounded px-2 py-1 flex-1" />
                            </div>
                            <textarea v-model="newComment.contenu" placeholder="Votre réponse..." rows="2" class="w-full text-xs p-2 border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:outline-none"></textarea>
                            <div class="flex justify-end gap-2">
                              <button @click="cancelReply" class="px-2.5 py-1 text-[10px] bg-gray-200 text-gray-600 rounded">Annuler</button>
                              <button @click="submitComment(presentationVideo.id, c.id)" class="px-3 py-1 text-[10px] bg-blue-600 text-white rounded font-bold">Répondre</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-else class="text-[11px] text-gray-400 italic text-center py-4">Aucun commentaire pour le moment. Soyez le premier ! 🚀</div>

                    <!-- Formulaire principal (Commentaire de premier niveau) -->
                    <div v-if="!replyingToId" class="border-t border-gray-200 pt-3 space-y-3">
                      <div class="text-[11px] text-gray-500 font-medium">Laissez un retour ou faites une suggestion technique :</div>
                      <div class="flex flex-col sm:flex-row gap-2">
                        <select v-model="newComment.pseudo" class="text-xs bg-white border border-gray-300 rounded-xs p-2 flex-1">
                          <option value="" disabled>🎮 Choisir un pseudo Fun (style Kahoot)</option>
                          <option v-for="p in kahootPseudos" :key="p" :value="p">{{ p }}</option>
                        </select>
                        <input v-model="newComment.customPseudo" type="text" placeholder="Ou écrivez le vôtre" class="text-xs border border-gray-300 rounded-xs p-2 flex-1" />
                      </div>
                      <textarea v-model="newComment.contenu" placeholder="Ex: Excellente démonstration AD ! Des pistes d'améliorations sur la GPO ?" rows="3" class="w-full text-xs p-2.5 border border-gray-300 rounded-xs focus:ring-1 focus:ring-blue-500 focus:outline-none"></textarea>
                      <button @click="submitComment(presentationVideo.id)" class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xs hover:bg-blue-700 transition-colors w-full sm:w-auto">
                        Envoyer le commentaire
                      </button>
                    </div>
                  </div>

                </div>
              </div>
              
              <div v-else class="py-24 flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                  <i class="ph ph-hourglass-high text-2xl text-amber-500"></i>
                </div>
                <h4 class="text-gray-900 font-bold text-base">La vidéo n'a pas encore été rajoutée par son propriétaire.</h4>
                <div class="mt-4 px-5 py-2 bg-[#f0f7ff] border border-blue-100 rounded-xs text-[#060b24] text-xs font-light">
                  Date d'ajout prévue : jusqu'au 05/05/2026
                </div>
                <p class="text-[10px] text-gray-400 mt-4 lowercase italic tracking-tight">
                  <i class="ph ph-info"></i> merci de revenir de temps en temps visiter afin de rester informer.
                </p>
              </div>
            </div>
          </div>

          <div v-if="loading" class="space-y-4">
            <div class="h-5 w-40 bg-gray-200 rounded animate-pulse"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div v-for="i in 2" :key="i" class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden animate-pulse">
                <div class="aspect-video bg-gray-200"></div>
                <div class="p-4 space-y-2">
                  <div class="h-4 w-3/4 bg-gray-200 rounded"></div>
                  <div class="h-3 w-full bg-gray-100 rounded"></div>
                  <div class="h-3 w-2/3 bg-gray-100 rounded"></div>
                  <div class="flex justify-between mt-4 pt-3 border-t border-gray-50">
                    <div class="h-3 w-20 bg-gray-100 rounded"></div>
                    <div class="h-3 w-16 bg-gray-100 rounded"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- AUTRES VIDÉOS TECHNIQUES -->
          <div v-else class="space-y-4">
            <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
              <i class="ph ph-code text-[#060b24]"></i> Supports Techniques
            </h3>
            <div v-if="technicalVideos.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div v-for="video in technicalVideos" :key="video.id" class="bg-white rounded-xs border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                  <div class="aspect-video bg-black relative group">
                    
                    <div v-if="videoStates[video.id]?.isWaiting && !videoStates[video.id]?.hasError" 
                         class="absolute inset-0 bg-black/70 z-10 flex flex-col items-center justify-center text-center p-4 transition-all">
                      <div class="w-8 h-8 border-2 border-blue-400 border-t-transparent rounded-full animate-spin mb-3"></div>
                      <p class="text-xs text-white font-light tracking-wide animate-pulse">Merci de patienter, nous chargeons votre vidéo...</p>
                    </div>

                    <div v-if="videoStates[video.id]?.hasError" 
                         class="absolute inset-0 bg-[#0f111a] z-10 flex flex-col items-center justify-center text-center p-6 transition-all border border-red-900/30">
                      <div class="w-12 h-12 bg-red-950/40 rounded-full flex items-center justify-center mb-3 border border-red-900/50">
                        <i class="ph ph-warning text-xl text-red-400"></i>
                      </div>
                      <h5 class="text-white font-medium text-xs">Échec du téléchargement</h5>
                      <p class="text-[10px] text-gray-400 mt-1 max-w-[250px] leading-relaxed">
                        Impossible de charger le média. Le serveur de streaming est momentanément indisponible.
                      </p>
                      <button @click="retryVideo(video)" class="mt-4 px-3 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 text-[10px] rounded-xs transition-all flex items-center gap-1">
                        <i class="ph ph-arrows-clockwise"></i> Réessayer
                      </button>
                    </div>

                    <video :key="video.nom_fichier" 
                           controls 
                           preload="metadata" 
                           class="w-full h-full" 
                           crossorigin="anonymous"
                           @waiting="handleVideoWaiting(video.id)"
                           @playing="handleVideoPlaying(video.id)"
                           @error="handleVideoError(video.id)"
                           @stalled="handleVideoWaiting(video.id)">
                      <source :src="video.nom_fichier" type="video/mp4">
                    </video>
                  </div>
                  <div class="p-4">
                    <h4 class="font-bold text-gray-900 text-xs lowercase">{{ video.titre }}</h4>
                    <p class="text-[10px] text-gray-500 mt-2 leading-relaxed italic">{{ video.description }}</p>
                    <div class="mt-4 flex items-center justify-between border-t border-gray-50 pt-3">
                      <p class="text-[9px] text-gray-400 uppercase tracking-wide">
                        <i class="ph ph-calendar-blank"></i> {{ new Date(video.date_creation).toLocaleDateString('fr-FR') }}
                      </p>
                      <span v-if="video.mode_suppression === '15j'" 
                            :class="video.jours_restants <= 3 ? 'text-red-800 font-light' : 'text-gray-500'" 
                            class="text-[10px] flex items-center gap-1 uppercase tracking-tighter">
                        <i class="ph-fill ph-clock-countdown"></i> J-{{ video.jours_restants }}
                      </span>
                      <span v-else class="text-[9px] text-green-600 font-medium capitalize tracking-tighter">
                        <i class="ph-fill ph-infinity"></i> Permanent
                      </span>
                    </div>
                  </div>
                </div>

                <!-- SECTION RETOURS DE CHAQUE VIDÉO TECHNIQUE -->
                <div class="px-4 pb-4 border-t border-gray-50 pt-3">
                  <button @click="toggleComments(video.id)" class="text-[10px] font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <i class="ph ph-chat-centered-text"></i> 
                    {{ activeCommentVideoId === video.id ? 'Fermer' : 'Laisser un avis' }}
                  </button>

                  <div v-if="activeCommentVideoId === video.id" class="mt-3 bg-gray-50 p-3 rounded-xs border border-gray-100 space-y-3 animate-fade-in text-[11px]">
                    <div v-if="comments[video.id]?.length" class="space-y-3 max-h-[180px] overflow-y-auto">
                      <div v-for="c in comments[video.id]" :key="c.id" class="bg-white p-2 rounded border border-gray-100 space-y-1">
                        <div class="flex items-center justify-between font-semibold">
                          <span class="text-blue-600"><i class="ph ph-user"></i> {{ c.pseudo }}</span>
                          <span class="text-[8px] text-gray-400"><i class="ph ph-calendar"></i>{{ formatCommentDate(c.date_creation) }}</span>
                        </div>
                        <p class="text-gray-700 leading-tight">{{ c.contenu }}</p>

                        <!-- Réponses imbriquées -->
                        <div v-if="c.replies && c.replies.length" class="pl-3 border-l border-gray-200 mt-1 space-y-1">
                          <div v-for="reply in c.replies" :key="reply.id" class="bg-gray-50 p-1.5 rounded text-[10px]">
                            <span class="font-bold text-gray-800"><i class="ph ph-arrow-bend-double-up-left"></i> {{ reply.pseudo }} : </span>
                            <span class="text-gray-600">{{ reply.contenu }}</span>
                          </div>
                        </div>

                        <!-- Mini Répondre -->
                        <div>
                          <button @click="setReplyTo(c.id)" class="text-[9px] text-gray-400 hover:text-blue-600">Répondre</button>
                          <div v-if="replyingToId === c.id" class="mt-2 space-y-1.5">
                            <input v-model="newComment.customPseudo" type="text" placeholder="Pseudo" class="w-full text-[10px] p-1 border rounded" />
                            <textarea v-model="newComment.contenu" placeholder="Répondre..." rows="1" class="w-full text-[10px] p-1 border rounded"></textarea>
                            <div class="flex justify-end gap-1">
                              <button @click="cancelReply" class="px-1.5 py-0.5 text-[8px] bg-gray-200 rounded">X</button>
                              <button @click="submitComment(video.id, c.id)" class="px-2 py-0.5 text-[8px] bg-blue-600 text-white rounded">Ok</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Nouveau commentaire principal -->
                    <div v-if="!replyingToId" class="space-y-2 pt-2 border-t border-gray-200">
                      <select v-model="newComment.pseudo" class="w-full text-[10px] bg-white border border-gray-300 rounded p-1">
                        <option value="" disabled>Tu peux choisir un pseudo</option>
                        <option v-for="p in pseudoFun" :key="p" :value="p">{{ p }}</option>
                      </select>
                      <input v-model="newComment.customPseudo" type="text" placeholder="Ou tapez votre pseudo" class="w-full text-[10px] border border-gray-300 rounded p-1" />
                      <textarea v-model="newComment.contenu" placeholder="Votre avis (ex: GPO propre !)" rows="2" class="w-full text-[10px] p-1.5 border border-gray-300 rounded"></textarea>
                      <button @click="submitComment(video.id)" class="w-full py-1.5 bg-blue-600 text-white text-[10px] font-bold rounded hover:bg-blue-700 transition-colors">
                        Envoyer l'avis
                      </button>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div v-else class="p-12 border border-dashed border-gray-200 rounded-xs text-center opacity-40">
              <i class="ph ph-video-slash text-4xl mb-2"></i>
              <p class="text-[10px] font-light italic">Aucun support technique n'est disponible pour le moment.</p>
            </div>
          </div>

        </div>

        <div class="lg:col-span-3">

          <div v-if="loading" class="bg-white rounded-xs border border-gray-200 shadow-sm p-5 sticky top-8 animate-pulse">
            <div class="h-4 w-28 bg-gray-200 rounded mb-4"></div>
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="h-6 w-6 bg-gray-200 rounded"></div>
                <div class="space-y-1 flex-1">
                  <div class="h-3 w-full bg-gray-200 rounded"></div>
                  <div class="h-3 w-2/3 bg-gray-100 rounded"></div>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="h-6 w-6 bg-gray-200 rounded"></div>
                <div class="space-y-1 flex-1">
                  <div class="h-3 w-full bg-gray-200 rounded"></div>
                  <div class="h-3 w-2/3 bg-gray-100 rounded"></div>
                </div>
              </div>
              <hr class="border-gray-100">
              <div class="h-3 w-full bg-gray-100 rounded"></div>
              <div class="h-3 w-4/5 bg-gray-100 rounded"></div>
            </div>
          </div>

          <div v-else class="bg-white rounded-xs border border-gray-200 shadow-sm p-5 sticky top-8">
            <h4 class="text-[11px] font-black text-[#060b24] uppercase tracking-widest mb-4">Architecture</h4>
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <i class="ph ph-server text-xl text-blue-600"></i>
                <p class="text-[10px] text-gray-600 leading-tight">Stockage source : <br><b class="text-gray-900">Penguin (Local)</b></p>
              </div>
              <div class="flex items-start gap-3">
                <i class="ph ph-cloud-check text-xl text-green-600"></i>
                <p class="text-[10px] text-gray-600 leading-tight">Diffusion : <br><b class="text-gray-900">Tailscale Funnel</b></p>
              </div>
              <hr class="border-gray-100">
              <p class="text-[9px] text-gray-400 italic leading-relaxed">
                Le streaming est opéré via un tunnel sécurisé Tailscale Funnel, directement depuis mon serveur local Penguin.
              </p>
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, reactive } from 'vue';

const videos = ref([]);
const loading = ref(true);

// --- COMPOSANTE COMMENTAIRES ---
const activeCommentVideoId = ref(null);
const comments = ref({}); // { [videoId]: [comments] }
const replyingToId = ref(null);

const pseudoFun = [
  'TechExplorer', 'SysAdminPro', 'GigaOctet', 'PingPongExpert', 
  'CloudWalker', 'ActiveDirecTeam', 'KernelPanic', 'CtrlAltDefeat', 
  'BitCrusher', 'RecruteurCurieux', 'WifiWarrior', 'SubnetZero','ZeroTrust', '403 Forbidden', '404NotFound', '500InternalError', 'BlueScreen', 'PacketSniffer',
];

const newComment = reactive({
  pseudo: '',
  customPseudo: '',
  contenu: ''
});

// URL de ton API PHP
const API_COMMENTS_URL = 'https://www.ezechielkouakou.fr/api_comments.php';

const toggleComments = async (videoId) => {
  if (activeCommentVideoId.value === videoId) {
    activeCommentVideoId.value = null;
  } else {
    activeCommentVideoId.value = videoId;
    await fetchComments(videoId);
  }
};

const fetchComments = async (videoId) => {
  try {
    const response = await fetch(`${API_COMMENTS_URL}?video_id=${videoId}`);
    const data = await response.json();
    if (data.success) {
      comments.value[videoId] = data.comments;
    }
  } catch (e) {
    console.error("Erreur chargement commentaires", e);
  }
};

const setReplyTo = (commentId) => {
  replyingToId.value = commentId;
  newComment.pseudo = '';
  newComment.customPseudo = '';
  newComment.contenu = '';
};

const cancelReply = () => {
  replyingToId.value = null;
};

const submitComment = async (videoId, parentId = null) => {
  const selectedPseudo = newComment.customPseudo.trim() || newComment.pseudo;
  
  if (!selectedPseudo || !newComment.contenu.trim()) {
    alert("Veuillez choisir un pseudo et écrire un message.");
    return;
  }

  try {
    const response = await fetch(API_COMMENTS_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        video_id: videoId,
        pseudo: selectedPseudo,
        contenu: newComment.contenu,
        parent_id: parentId
      })
    });
    
    const data = await response.json();
    if (data.success) {
      // Nettoyage du formulaire
      newComment.contenu = '';
      newComment.customPseudo = '';
      newComment.pseudo = '';
      replyingToId.value = null;
      
      // Recharger la liste des commentaires
      await fetchComments(videoId);
    }
  } catch (e) {
    console.error("Erreur envoi commentaire", e);
  }
};

const formatCommentDate = (dateStr) => {
  const options = { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' };
  return new Date(dateStr).toLocaleDateString('fr-FR', options);
};

// Objet réactif pour suivre l'état de chaque vidéo indépendamment
const videoStates = ref({});

// Stockage des timers pour éviter les fuites de mémoire
const waitingTimers = {};
const errorTimers = {};

const fetchData = async () => {
  loading.value = true;
  try {
    const response = await fetch('https://www.ezechielkouakou.fr/api_proxy.php');
    const data = await response.json();
    if (data.success) {
      videos.value = data.videos || [];
      
      // Initialisation par défaut de l'état réseau de chaque vidéo trouvée
      videos.value.forEach(v => {
        videoStates.value[v.id] = { isWaiting: false, hasError: false };
      });
    }
  } catch (e) {
 
  } finally {
    setTimeout(() => { loading.value = false; }, 1000);
  }
};

const handleVideoWaiting = (id) => {
  clearTimeout(waitingTimers[id]);
  clearTimeout(errorTimers[id]);

  waitingTimers[id] = setTimeout(() => {
    if (videoStates.value[id] && !videoStates.value[id].hasError) {
      videoStates.value[id].isWaiting = true;
    }
  }, 3000);

  errorTimers[id] = setTimeout(() => {
    if (videoStates.value[id]) {
      videoStates.value[id].isWaiting = false;
      videoStates.value[id].hasError = true;
    }
  }, 10000);
};

const handleVideoPlaying = (id) => {
  clearTimeout(waitingTimers[id]);
  clearTimeout(errorTimers[id]);
  if (videoStates.value[id]) {
    videoStates.value[id].isWaiting = false;
    videoStates.value[id].hasError = false;
  }
};

const handleVideoError = (id) => {
  clearTimeout(waitingTimers[id]);
  clearTimeout(errorTimers[id]);
  if (videoStates.value[id]) {
    videoStates.value[id].isWaiting = false;
    videoStates.value[id].hasError = true;
  }
};

const retryVideo = (video) => {
  if (videoStates.value[video.id]) {
    videoStates.value[video.id].hasError = false;
    videoStates.value[video.id].isWaiting = true;
  }
  const secureBackupUrl = video.nom_fichier;
  video.nom_fichier = '';
  setTimeout(() => {
    video.nom_fichier = secureBackupUrl;
  }, 50);
};

const presentationVideo = computed(() => 
  videos.value.find(v => v.type_video === 'presentation')
);

const technicalVideos = computed(() => 
  videos.value.filter(v => v.type_video === 'technique')
);

onMounted(fetchData);
</script>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css");
@import url("https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css");

.min-h-screen {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}

video {
  object-fit: contain;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}

.animate-pulse {
  animation: pulse 1.5s ease-in-out infinite;
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-out forwards;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-5px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>