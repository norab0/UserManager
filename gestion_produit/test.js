import http from "k6/http";
import { check, sleep } from "k6";

// Configuration du test
export const options = {
  vus: 500,
  duration: "30s", // Tous les utilisateurs envoient leur requête en 30s
};

export default function () {
  const url = "http://host.docker.internal/gestion_produit/gestion_produit/api.php";

  // Formatage manuel du payload en utilisant une chaîne de caractères
  const payload = {
    name: `user${__VU}`,
    email: `user${__VU}@test.com`,
  };

  const headers = {
    "Content-Type": "application/x-www-form-urlencoded",
  };

  // Conversion du payload en x-www-form-urlencoded
  const encodedPayload = Object.keys(payload)
    .map((key) => `${encodeURIComponent(key)}=${encodeURIComponent(payload[key])}`)
    .join("&");

  const res = http.post(url, encodedPayload, { headers });

  check(res, {
    "status is 200": (r) => r.status === 200,
  });

  sleep(1); // Pause entre chaque requête
}
