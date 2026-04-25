# DOCUMENTATION DE PROCEDURES DOCKER

1. on lance la commande

# docker compose up -d

- up : Construire si nécessaire , crée et démarer les conteneur
- d(detached) : Lance le conteneur en arrière plan. cela permet de de continuer a utiliser le terminal.
  le cas écheans ou je voudrais voir si tout fonctionne via les logs alors je rétire le (-d).

# docker compose ps :

sert a voir les conteneur qui tournent actuellement, verifier l'état de ces conteneur

# docker compose stop

il sert a arreter les conteneurs sans les supprimer.

# docker compose down

il sert a arreter et supprimer les conteneurs.

# docker compose up -d --build

pour reconstruire l'image php si je modifie le Dockerfile

# docker compose logs -f NOM_CONTENEUR

verifier les logs d'erreur d'un seul conteneur spécifique.

# Mise en place de reverse Proxy avec Nginx Proxy Manager(NPM)

1. création de dossier réserver au proxy
   cmd : mkdir -p ~/homelab/proxy && cd ~/homelab/proxy
   ⬆️ : Création de dossiers /homelab/proxy
2. Création de docker-compose.yaml
   contenus du fichier :
   << services:
   npm:
   image: 'jc21/nginx-proxy-manager:latest'
   container_name: nginx-proxy-manager
   restart: unless-stopped
   ports: - '80:80' # Port HTTP public - '443:443' # Port HTTPS public - '81:81' # Interface d'administration Web
   volumes: - ./data:/data - ./letsencrypt:/etc/letsencrypt
   networks: - proxy-network

networks:
proxy-network:
external: true >> 3. procédure de mise en place du proxy

- Création du réseau commun
  cmd : sudo docker network create proxy-network
- Lancer NPM(nginx proxy manager)
  cmd: sudo docker compose up -d

# NB: En cas d'inéxecution de de la machine avec la commande docker compose up  -d on vérifie le serveur qui tourne sur le port occupé 
  * cmd : sudo lsof -i :NUMERO_PORT
pour suite du projet j'ai dû bloquer le port apache2 car il empechais l'execution du reverse proxy.