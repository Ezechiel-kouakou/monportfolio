<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <meta name="theme-color" content="#ffffff">

  <title>Maintenance technique | Ezechiel KOUAKOU</title>
  <meta name="description" content="Le portfolio d'Ezechiel KOUAKOU fait actuellement l'objet d'une maintenance technique.">

  <style>
    :root {
      --blue: #2563eb;
      --blue-dark: #173b75;
      --text: #171923;
      --muted: #64748b;
      --border: #e2e8f0;
      --background: #f8fafc;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      color: var(--text);
      background: #fff;
      font-family: Inter, "Segoe UI", Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
    }

    header {
      width: 100%;
      padding: 24px 6%;
      border-bottom: 1px solid var(--border);
    }

    .brand {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      color: inherit;
      text-decoration: none;
    }

    .brand-mark {
      display: grid;
      place-items: center;
      width: 42px;
      height: 42px;
      border-radius: 10px;
      color: #fff;
      background: var(--blue-dark);
      font-weight: 800;
      letter-spacing: -1px;
    }

    .brand-name {
      font-weight: 750;
      letter-spacing: -0.3px;
    }

    .brand-subtitle {
      display: block;
      margin-top: 3px;
      color: var(--muted);
      font-size: 12px;
      font-weight: 400;
    }

    main {
      flex: 1;
      display: grid;
      place-items: center;
      padding: 64px 20px;
    }

    .maintenance {
      width: 100%;
      max-width: 700px;
      text-align: center;
    }

    .icon-wrap {
      display: grid;
      place-items: center;
      width: 88px;
      height: 88px;
      margin: 0 auto 28px;
      border: 1px solid #dbeafe;
      border-radius: 24px;
      color: var(--blue);
      background: #eff6ff;
    }

    .status {
      display: inline-flex;
      align-items: center;
      gap: 9px;
      margin-bottom: 22px;
      padding: 9px 14px;
      border: 1px solid #bfdbfe;
      border-radius: 999px;
      color: var(--blue-dark);
      background: #eff6ff;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.7px;
      text-transform: uppercase;
    }

    .status-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--blue);
    }

    h1 {
      margin-bottom: 20px;
      font-size: clamp(30px, 5vw, 46px);
      line-height: 1.15;
      letter-spacing: -1.5px;
    }

    .intro {
      max-width: 570px;
      margin: 0 auto;
      color: var(--muted);
      font-size: 17px;
      line-height: 1.8;
    }

    .details {
      margin-top: 32px;
      padding: 24px;
      border: 1px solid var(--border);
      border-radius: 16px;
      background: var(--background);
      text-align: left;
    }

    .details h2 {
      margin-bottom: 12px;
      font-size: 15px;
    }

    .details p {
      color: var(--muted);
      font-size: 14px;
      line-height: 1.8;
    }

    .details strong {
      color: var(--text);
    }

    .actions {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 28px;
    }

    .button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 9px;
      min-height: 46px;
      padding: 0 20px;
      border: 1px solid var(--border);
      border-radius: 9px;
      color: var(--text);
      background: #fff;
      font-size: 14px;
      font-weight: 650;
      text-decoration: none;
      transition: background 0.2s, transform 0.2s;
    }

    .button:hover {
      background: #f1f5f9;
      transform: translateY(-1px);
    }

    .button-primary {
      border-color: var(--blue-dark);
      color: #fff;
      background: var(--blue-dark);
    }

    .button-primary:hover {
      background: #214b8e;
    }

    .note {
      margin-top: 24px;
      color: #94a3b8;
      font-size: 12px;
      line-height: 1.7;
    }

    footer {
      padding: 22px 16px;
      border-top: 1px solid var(--border);
      color: var(--muted);
      text-align: center;
      font-size: 12px;
      line-height: 1.8;
    }

    footer strong {
      color: var(--text);
    }

    @media (max-width: 480px) {
      header {
        padding: 18px 20px;
      }

      main {
        padding: 44px 20px;
      }

      .intro {
        font-size: 15px;
      }

      .details {
        padding: 19px;
      }

      .actions {
        flex-direction: column;
      }

      .button {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <header>
    <a class="brand" href="#" aria-label="Portfolio Ezechiel KOUAKOU">
      <span class="brand-mark">EK</span>
      <span>
        <span class="brand-name">Ezechiel KOUAKOU</span>
        <span class="brand-subtitle">Portfolio informatique · Systèmes & Réseaux</span>
      </span>
    </a>
  </header>

  <main>
    <section class="maintenance" aria-labelledby="title">

      <div class="icon-wrap" aria-hidden="true">
        <svg width="42" height="42" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="1.6"
             stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 3 2.8 19h18.4L12 3Z"/>
          <path d="M12 9v4"/>
          <path d="M12 16h.01"/>
        </svg>
      </div>

      <div class="status">
        <span class="status-dot"></span>
        Maintenance technique en cours
      </div>

      <h1 id="title">Le site fait peau neuve.</h1>

      <p class="intro">
        Mon portfolio est temporairement indisponible pendant une
        intervention de maintenance. Je procède à des mises à jour
        techniques afin de maintenir la compatibilité, la stabilité
        et la sécurité des services hébergés.
      </p>

      <div class="details">
        <h2>Que se passe-t-il actuellement ?</h2>
        <p>
          À la suite d'une notification relative aux mises à jour de
          l'environnement serveur, une intervention est nécessaire sur
          PHP et sur certains services qui en dépendent.
          <br><br>
          <strong>Objectif :</strong> effectuer les vérifications,
          adapter les composants concernés et contrôler le bon
          fonctionnement des services avant leur remise en ligne.
        </p>
      </div>

      <div class="actions">
        <a class="button button-primary"
           href="https://www.linkedin.com/"
           target="_blank" rel="noopener noreferrer">
          Suivre mon actualité sur LinkedIn
        </a>
        <a class="button" href="mailto:">
          Me contacter
        </a>
      </div>

      <p class="note">
        Merci pour votre patience. Le site sera de nouveau accessible
        une fois les vérifications techniques terminées.
      </p>

    </section>
  </main>

  <footer>
    <strong>Ezechiel KOUAKOU</strong> · Portfolio personnel<br>
    Systèmes, réseaux et infrastructures informatiques
  </footer>
</body>
</html>

<!-- <script setup>
import { ref } from "vue";
import Navbar from "../components/Navbar.vue";
import Hero from "../components/Hero.vue";
import Stats from "../components/Stats.vue";
import Experiences from "../components/ExperienceSection.vue";
import Projets from "../components/Projets.vue";
import ModalCV from "../components/ModalCV.vue";
import ModalContact from "../components/ModalContact.vue";

const isModalOpen = ref(false); 
const isContactModalOpen = ref(false);
</script>

<template>
  <main
    class="min-h-screen w-full bg-[#020617] text-white selection:bg-blue-500/30"
  >
    <Navbar @open-contact="isContactModalOpen = true" />

    <Hero>
      <template #actions>
        <button
          @click="isModalOpen = true"
          class="button px-8 py-4 light (zinc-100) bg-zinc-100/90 text-black rounded-br-lg font-bold lowercase tracking-widest transition-all duration-300 shadow-[inset_0_-4px_8px_rgba(0,0,0,0.1),_inset_0_4px_8px_rgba(255,255,255,0.8),_0_10px_25px_rgba(0,0,0,0.5)] border border-white/20 hover:bg-white hover:scale-105 active:scale-95"
        >
          Voir mon CV
        </button>
      </template>
    </Hero>

    <Stats />
    <Experiences />
    <Projets />

    <ModalCV :isOpen="isModalOpen" @close="isModalOpen = false" />

    <ModalContact
      :isOpen="isContactModalOpen"
      @close="isContactModalOpen = false"
    />
  </main>
</template> -->