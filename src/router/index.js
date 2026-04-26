import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ProjectsLibraryView from '../views/ProjectsLibraryView.vue'
import ContactView from '../views/Contact.vue'  
import TableauSyntheseView from '../views/TableauSynthese.vue'
import FormSyntheseView from '../views/FormSyntheseView.vue'
import videoView from '../views/videoView.vue'

// Importe tes futures pages de doc ici (ou utilise le lazy loading plus bas)
// import ApiDoc from '../views/docs/ApiDoc.vue' 

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/projets',
    name: 'library',
    component: ProjectsLibraryView
  },
  {
    path: '/contact',
    name: 'contact',
    component: ContactView
  },
  {
    path: '/tableau-synthese',
    name: 'tableauSynthese',
    component: TableauSyntheseView
  },
  {
    path: '/admin/ajouter-realisation',
    name: 'FormulaireSynthese',
    component: FormSyntheseView
  },
  {
    path: '/videos',
    name: 'Videos',
    component: videoView
  },
  // --- NOUVELLES ROUTES POUR TES DOCUMENTATIONS ---
  {
    path: '/doc/competence01',
    name: 'DocApi',
    component: () => import('../views/docs/Competence01.vue') // Lazy loading : crée ce fichier plus tard
  },
  {
    path: '/doc/competence07',
    name: 'DocInfrastructure',
    component: () => import('../views/docs/Competence07.vue')
  },
  {
    path: '/doc/competence11',
    name: 'DocStage',
    component: () => import('../views/docs/Competence11.vue')
  },
   {
    path: '/doc/competence14',
    name: 'DocChefProjet',
    component: () => import('../views/docs/Competence14.vue')
  },
    {
    path: '/doc/competence17',
    name: 'DocArchitecture',
    component: () => import('../views/docs/Competence17.vue')
  },
]

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes
})

export default router