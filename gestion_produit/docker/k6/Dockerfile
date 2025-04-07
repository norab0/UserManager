# Utiliser l'image officielle de k6
FROM grafana/k6

# Définir le répertoire de travail dans le conteneur
WORKDIR /usr/src/app

# Copier le script de test dans le conteneur
COPY ./test.js /usr/src/app/

# Exposer un port si nécessaire (optionnel, pas utilisé directement par k6)
EXPOSE 8080

# Exécuter k6 avec le script de test
ENTRYPOINT ["k6", "run", "/usr/src/app/test.js"]
