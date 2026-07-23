<template>
  <div class="min-h-screen bg-[#fafafc] pt-32 px-6">
    <div class="max-w-7xl mx-auto mb-12 md:mb-16 text-black dark:text-white transition-colors duration-500 flex flex-col md:flex-row items-center justify-between gap-6">
       <h1 class="text-4xl font-light text-black mb-12">
      Bibliothèque complète des projets
    </h1>

    <router-link to="/" class="text-[#050926] hover:underline mb-8 inline-block">
      ← Retour à l'accueil
    </router-link>
</div> 
    <div class="white md:grid-cols-3 lg:grid-cols-4 gap-3 grid-cols-1 grid ">
      <div
        v-for="project in projetsLib"
        :key="project.id"
        class="bg-white/5 p-6 rounded-sm border border-white/10 shadow-lg transition-all duration-500 hover:bg-white/10"
      >
      <img :src="project.img" :alt="project.title" class="w-full h-48 object-cover  mb-4" />
        <h3 class="text-[#050926] font-bold">{{ project.title }}</h3>
        <p class="text-gray-800 mt-8 mb-6 font-family-['tahoma']">{{ project.description }}</p> 
 <div class="flex items-center gap-4 mt-4 justify-space-between">
     <div
            v-for="tech in project.technos"
            :key="tech.name"
            class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center"
            :title="tech.name"
          >
            <img
              :src="tech.icon"
              :alt="tech.name"
              class="w-4 h-4 object-contain"
            />
          </div>       
  
  <a :href="project.Documentation" target="_blank" class="text-blue-400 hover:underline mt-4 inline-block ml-8">
          Documentation
        </a>  
        <!-- <a href="/src/assets/projet-ecotechnologie.png"></a> -->

        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="max-w-7xl mx-auto px-6 py-12 text-center text-sm text-gray-500 mt-12 transition-colors duration-500">
      &copy; 2026 Ezechiel Kouakou. Tous droits réservés. | Des Questions ? <router-link to="/contact" class="text-blue-400 hover:underline">Contactez-moi</router-link>
    </div>
  </footer>
</template>

<script>
export default {
  name: "ProjectsLibraryView",
  data() {
    return {
      projetsLib: [
        {
          id: 1,
          img:"/src/assets/API-REST.png",
          title: "ApiRest",
          description: "Test technique portant sur la création d'une API REST en Node.js avec Express et TypeScript.",
          technos: [
            { name: "Express", icon: "https://cdn.simpleicons.org/express/FFFFFF" },
            { name: "TypeScript", icon: "https://cdn.simpleicons.org/typescript/3178C6" },
            { name: "Node.js", icon: "https://cdn.simpleicons.org/nodedotjs/339933" },
          ],
          Documentation: "https://github.com/Ezechiel-kouakou/ApiRest/blob/main/README.md"
        },
        {
          id: 2,
          img: "https://cdn.simpleicons.org/docker/2496ED",
          title: "Homelab",
          description: "Système de monitoring Docker pour mon infrastructure Debian.",
          technos: [
            { name: "Docker", icon: "https://cdn.simpleicons.org/docker/2496ED" },
            { name: "Nginx", icon: "https://cdn.simpleicons.org/nginx/009639" },
            { name: "Debian", icon: "https://cdn.simpleicons.org/debian/A81D33" },
          ],
        },
        {
          id: 3,
          img: "https://cdn.simpleicons.org/debian/A81D33",
          title: "SPRS Deployment",
          description: "Déploiement de SPRS sur Debian avec transfert FTP sécurisé.",
          technos: [
            { name: "Debian", icon: "https://cdn.simpleicons.org/debian/A81D33" },
            { name: "FileZilla", icon: "https://cdn.simpleicons.org/filezilla/EF4E34" },
            { name: "VirtualBox", icon: "https://cdn.simpleicons.org/virtualbox/183A61" },
          ],
        },
        {
          id: 4,
          img: "/src/assets/projet-ecotechnologie.png",
          title: "ecotechnologie",
          description: "Ecotechnologie, c'est bien plus qu'un simple site web, c'est un écosystème. Ce projet s'inscrit dans le cadre de mon parcours académique en BTS SIO. Il vise à créer une application de vente en ligne. ",
          technos: [
            { name: "Techno1", icon: "https://cdn.simpleicons.org/techno1/000000" },
            { name: "Techno2", icon: "https://cdn.simpleicons.org/techno2/000000" },
          ],
        },
        // {
        //   id: 5,
        //   title: "Projet X",
        //   description: "Description du projet X.",
        //   technos: [
        //     { name: "TechnoA", icon: "https://cdn.simpleicons.org/technoA/000000" },
        //     { name: "TechnoB", icon: "https://cdn.simpleicons.org/technoB/000000" },
        //   ],
        // }
      ],
    };
  },
};
</script>

<style scoped>
/* Ajoute du style si besoin ici */

</style>