
<script setup>
const linkedinUrl = "https://www.linkedin.com/";
// Remplace cette URL par celle de ton profil LinkedIn.

const maintenanceStarted = "23 octobre 2026";
</script>

<template>
  <main class="maintenance-page">
    <header class="maintenance-header">
      <a class="brand" href="/" aria-label="Portfolio Ezechiel KOUAKOU">
        <span class="brand-mark">EK</span>

        <span class="brand-text">
          <strong>Ezechiel KOUAKOU</strong>
          <small>Portfolio informatique · Systèmes & Réseaux</small>
        </span>
      </a>
    </header>

    <section class="maintenance-content">
      <div class="maintenance-icon" aria-hidden="true">
        <svg
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="1.6"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="M12 3 2.8 19h18.4L12 3Z" />
          <path d="M12 9v4" />
          <path d="M12 16h.01" />
        </svg>
      </div>

      <div class="status">
        <span class="status-dot"></span>
        Maintenance technique en cours
      </div>

      <h1>Une intervention technique est en cours.</h1>

      <p class="intro">
        Mon portfolio est temporairement indisponible pendant une
        opération de maintenance. Je procède à des vérifications
        techniques et aux ajustements nécessaires avant sa remise en ligne.
      </p>

      <article class="details">
        <h2>Pourquoi cette intervention ?</h2>

        <p>
          Azure App Service a signalé une mise à jour de sécurité
          du runtime PHP intégré. Certains services dépendant de PHP
          nécessitent des vérifications de compatibilité.
        </p>

        <p>
          <strong>Priorité :</strong> contrôler le fonctionnement
          des composants concernés, corriger les éventuelles
          incompatibilités et valider les services avant leur réactivation.
        </p>
      </article>

      <div class="actions">
        <a
          class="button button-primary"
          :href="linkedinUrl"
          target="_blank"
          rel="noopener noreferrer"
        >
          Suivre mon actualité sur LinkedIn
          <span aria-hidden="true">↗</span>
        </a>
      </div>

      <p class="note">
        Merci pour votre compréhension.
        Le portfolio sera de nouveau accessible après les vérifications.
      </p>
    </section>

    <footer>
      <strong>Ezechiel KOUAKOU</strong>
      <span>Portfolio personnel · {{ maintenanceStarted }}</span>
    </footer>
  </main>
</template>

<style scoped>
.maintenance-page {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  color: #171923;
  background: #fff;
  font-family: Inter, "Segoe UI", Arial, sans-serif;
}

.maintenance-header {
  padding: 24px 6%;
  border-bottom: 1px solid #e2e8f0;
}

.brand {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  color: inherit;
  text-decoration: none;
}

.brand-mark {
  width: 42px;
  height: 42px;
  display: grid;
  place-items: center;
  border-radius: 10px;
  color: white;
  background: #173b75;
  font-weight: 800;
}

.brand-text {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.brand-text strong {
  font-size: 15px;
}

.brand-text small {
  color: #64748b;
  font-size: 12px;
}

.maintenance-content {
  width: min(700px, 100%);
  margin: auto;
  padding: 64px 24px;
  text-align: center;
}

.maintenance-icon {
  width: 78px;
  height: 78px;
  display: grid;
  place-items: center;
  margin: 0 auto 24px;
  border: 1px solid #dbeafe;
  border-radius: 22px;
  color: #2563eb;
  background: #eff6ff;
}

.maintenance-icon svg {
  width: 38px;
  height: 38px;
}

.status {
  display: inline-flex;
  align-items: center;
  gap: 9px;
  margin-bottom: 22px;
  padding: 9px 14px;
  border: 1px solid #bfdbfe;
  border-radius: 999px;
  color: #173b75;
  background: #eff6ff;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.6px;
  text-transform: uppercase;
}

.status-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #2563eb;
}

h1 {
  margin: 0 0 18px;
  font-size: clamp(30px, 5vw, 43px);
  line-height: 1.2;
  letter-spacing: -1.2px;
}

.intro {
  max-width: 570px;
  margin: 0 auto;
  color: #64748b;
  font-size: 16px;
  line-height: 1.8;
}

.details {
  margin-top: 30px;
  padding: 24px;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  background: #f8fafc;
  text-align: left;
}

.details h2 {
  margin: 0 0 14px;
  font-size: 16px;
}

.details p {
  margin: 0 0 12px;
  color: #64748b;
  font-size: 14px;
  line-height: 1.8;
}

.details p:last-child {
  margin-bottom: 0;
}

.details strong {
  color: #171923;
}

.actions {
  display: flex;
  justify-content: center;
  margin-top: 26px;
}

.button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  min-height: 46px;
  padding: 0 20px;
  border: 1px solid #173b75;
  border-radius: 8px;
  color: white;
  background: #173b75;
  font-size: 14px;
  font-weight: 650;
  text-decoration: none;
  transition: background 0.2s, transform 0.2s;
}

.button:hover {
  background: #214b8e;
  transform: translateY(-1px);
}

.note {
  margin-top: 22px;
  color: #94a3b8;
  font-size: 12px;
  line-height: 1.7;
}

footer {
  display: flex;
  flex-direction: column;
  gap: 6px;
  padding: 22px;
  border-top: 1px solid #e2e8f0;
  color: #64748b;
  text-align: center;
  font-size: 12px;
}

footer strong {
  color: #171923;
}

@media (max-width: 480px) {
  .maintenance-header {
    padding: 18px 20px;
  }

  .maintenance-content {
    padding: 44px 20px;
  }

  .details {
    padding: 19px;
  }

  .button {
    width: 100%;
  }
}
</style>
