# Cahier des Charges — GestionMorpho (Kasbah Royale)

---

## 1. Présentation du Projet

| Champ | Détail |
|---|---|
| **Nom du projet** | GestionMorpho — Kasbah Royale |
| **Type** | Application web de gestion hôtelière full-stack |
| **Contexte** | Système de gestion intégré pour un hôtel/riad de luxe couvrant la gestion des clients, des réservations, de la restauration, du spa et des ressources humaines |
| **Date** | 2026 |

---

## 2. Architecture Technique

| Couche | Technologie |
|---|---|
| **Backend** | Laravel 12 (PHP), API REST |
| **Frontend** | Vue.js 3 (Composition API), Vue Router |
| **Authentification** | Laravel Sanctum (tokens Bearer) |
| **Base de données** | SQLite (développement) |
| **Style** | Tailwind CSS, Material Symbols (Google) |
| **Déploiement** | Docker + Nginx |
| **Communication** | API JSON sur `http://localhost:8080` |

---

## 3. Acteurs du Système

| Rôle | Description |
|---|---|
| **Client** | Visiteur/client de l'hôtel — réservations, commandes, spa |
| **Admin** | Administrateur système — gestion globale de l'hôtel |
| **Staff RH** | Responsable RH — gestion du personnel et des absences |
| **Chef Personnel** | Chef de département — gestion des tâches et des équipes |
| **Staff** | Employé standard — consultation de son tableau de bord personnel |

---

## 4. Modules Fonctionnels

### 4.1 Module Authentification

- Inscription (Register) avec : nom, email, âge, CIN, téléphone, mot de passe
- Connexion (Login) avec génération de token Sanctum
- Déconnexion (invalidation du token)
- Récupération du profil connecté (`GET /api/auth/me`)
- Rôles disponibles : `client`, `admin`, `staff`
- Middleware de contrôle d'accès par rôle et par département

---

### 4.2 Module Client (Interface Kasbah Royale)

#### Page d'accueil (Home)
- Présentation luxe du riad (hero, galerie, spa, expériences)
- Navigation vers les sections : Rooms, SPA, Menu
- Accès au profil si l'utilisateur est connecté
- Footer avec newsletter et liens utiles

#### Gestion des Chambres
- Consultation de la liste des chambres avec image, nom, description, disponibilité et prix/nuit
- Réservation d'une chambre via modal :
  - Sélection de la date d'arrivée
  - Sélection de la date de départ
  - Calcul automatique du prix depuis le type de chambre
- Confirmation ou annulation de la réservation

#### Gestion du SPA
- Consultation des types de sessions SPA (nom, prix, description, disponibilité)
- Réservation d'une session SPA (date début, date fin)
- Validation de la session par le staff
- Affichage du prix total avant confirmation

#### Gestion de la Restauration
- Consultation du menu (plats avec image, description, prix, disponibilité)
- Passage de commandes avec sélection de plats
- Validation de commande

#### Profil Client
- Consultation et modification des informations personnelles

---

### 4.3 Module Admin

#### Dashboard
- Statistiques globales :
  - Total chambres / chambres disponibles
  - Total plats / plats disponibles
  - Total staff
  - Total départements
  - Total workshifts
  - Absences justifiées
- Liste des absences récentes (personnel, date, statut)
- Liste des tâches administratives avec statut (en cours / terminée)

#### Gestion des Chambres
- CRUD complet des chambres (nom, image, description, disponibilité, type)
- CRUD des types de chambre (nom, description, prix, disponibilité)

#### Gestion des Plats
- CRUD complet des plats (nom, image, description, prix, disponibilité)

#### Gestion des Départements
- CRUD des départements (nom, description, statut actif/inactif)

#### Gestion des WorkShifts
- CRUD des workshifts (département, date début, date fin, check-in, check-out)

#### Gestion des Sessions SPA
- CRUD des types de sessions SPA (nom, description, prix, statut)

#### Gestion du Personnel
- Création / modification / suppression des comptes staff
- Champs : nom, email, âge, CIN, téléphone, salaire, département, expériences (JSON), langues (JSON)

---

### 4.4 Module RH (Ressources Humaines)

#### Dashboard RH
- Statistiques : total workers, absences justifiées, absences non justifiées, total départements
- Liste de ses propres absences avec statut (justifiée / non justifiée)
- Liste des tâches du jour assignées

#### Gestion du Personnel
- Consultation et modification des informations du personnel
- Affectation des employés aux départements

#### Gestion des Absences
- Liste complète des absences avec :
  - Nom du personnel
  - Workshift associé
  - Date de l'absence
  - Statut : justifiée / non justifiée
  - PDF justificatif (lien de téléchargement)
- Création d'une nouvelle absence (sélection staff + workshift)
- Justification d'une absence avec upload de fichier PDF
- Compteurs en temps réel : total absences, justifiées, non justifiées

---

### 4.5 Module Chef Personnel

#### Dashboard Chef Personnel
- Statistiques : total personnel, tâches terminées, tâches en cours
- Vue par département avec liste du personnel (nom, email, téléphone, salaire)
- Gestion des tâches par département :
  - Création d'une tâche (nom, description, département)
  - Modification d'une tâche existante
  - Suppression d'une tâche
  - Suivi du statut (en cours / terminée)
- Suivi des absences de son équipe

---

### 4.6 Module Facturation & Paiements

- Génération de factures (bills) pour commandes et sessions SPA (relation polymorphique)
- Suivi du statut de paiement (`is_payed`)
- Gestion des paiements clients (création, consultation, suppression)
- Consultation et suppression des factures par le client

---

## 5. Modèle de Données

### Table `users`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| name | string | Nom complet |
| email | string (unique) | Adresse email |
| age | integer | Âge |
| CIN | string | Carte d'identité nationale |
| telephon | string | Numéro de téléphone |
| role | enum | `client`, `admin`, `staff` |
| salaire | string (nullable) | Salaire (staff uniquement) |
| departement_id | integer (nullable) | Département (staff uniquement) |
| experiences | JSON (nullable) | Liste des expériences |
| langages | JSON (nullable) | Langues parlées |
| password | string (nullable) | Mot de passe hashé |

### Table `departements`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| name | string | Nom du département |
| description | string | Description |
| is_active | boolean | Statut actif/inactif |

### Table `workshifts`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| departement_id | integer | Référence département |
| date_debut | date | Date de début |
| date_fin | date | Date de fin |
| check_in | date | Heure d'entrée |
| check_out | date | Heure de sortie |

### Table `absences`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| workshift_id | integer | Référence workshift |
| staff_id | integer | Référence utilisateur (staff) |
| is_justified | boolean | Justifiée ou non |
| pdf | string (nullable) | Chemin vers le fichier PDF |

### Table `tasks`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| name | string | Nom de la tâche |
| description | string | Description |
| departement_id | integer | Référence département |
| is_completed | boolean | Statut de complétion |

### Table `chamber_types`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| name | string | Nom du type |
| description | string | Description |
| prix | float | Prix par nuit |
| is_available | boolean | Disponibilité |

### Table `chambers`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| name | string | Nom de la chambre |
| image | string | Chemin de l'image |
| description | string | Description |
| is_available | boolean | Disponibilité |
| chamber_type_id | integer | Référence type de chambre |

### Table `reservations`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| date_enter | date | Date d'arrivée |
| date_sortie | date | Date de départ |
| prix | float | Prix total |
| user_id | integer | Référence client |
| chamber_id | integer | Référence chambre |

### Table `plats`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| name | string | Nom du plat |
| image | string | Chemin de l'image |
| description | string | Description |
| prix | float | Prix |
| is_available | boolean | Disponibilité |

### Table `commandes`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| date | date | Date de la commande |
| prix | float | Prix total |
| client_id | integer | Référence client |
| service_id | integer | Référence service (Restauration) |

### Table `commande_plat` (pivot)
| Champ | Type | Description |
|---|---|---|
| commande_id | integer | Référence commande |
| plat_id | integer | Référence plat |

### Table `type_spa_sessions`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| name | string | Nom du type |
| description | string | Description |
| prix | float | Prix |
| status | boolean | Disponibilité |

### Table `spa_sessions`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| type_spa_session_id | integer | Référence type SPA |
| client_id | integer | Référence client |
| date_debut | date | Date de début |
| date_fin | date | Date de fin |
| prix | float | Prix |
| is_validated | boolean | Validée par le staff |

### Table `bills`
| Champ | Type | Description |
|---|---|---|
| id | integer | Clé primaire |
| billable_id | integer | ID de l'entité facturée |
| billable_type | string | Type de l'entité (Commande / SpaSession) |
| montant | float | Montant de la facture |
| is_payed | boolean | Statut de paiement |

---

## 6. API REST — Endpoints Principaux

### Authentification
| Méthode | Endpoint | Description |
|---|---|---|
| POST | `/api/auth/register` | Inscription |
| POST | `/api/auth/login` | Connexion |
| POST | `/api/auth/logout` | Déconnexion |
| GET | `/api/auth/me` | Profil connecté |

### Admin
| Méthode | Endpoint | Description |
|---|---|---|
| GET | `/api/admin/stats` | Statistiques globales |
| GET | `/api/admin/absences` | Liste des absences |
| GET | `/api/admin/staff/all` | Liste du personnel |
| POST | `/api/admin/staff/add` | Ajouter un staff |
| PUT | `/api/admin/staff/{id}/edit` | Modifier un staff |
| DELETE | `/api/admin/staff/{id}/delete` | Supprimer un staff |

### Ressources CRUD
| Ressource | Endpoint |
|---|---|
| Départements | `/api/departements` |
| Workshifts | `/api/workshifts` |
| Types de chambre | `/api/chamberTypes` |
| Chambres | `/api/chambers` |
| Types SPA | `/api/typeSpaSession` |
| Plats | `/api/plats` |
| Absences | `/api/absences` |
| Tâches | `/api/tasks` |
| Sessions SPA | `/api/spaSessions` |
| Réservations | `/api/reservations` |
| Commandes | `/api/commandes` |
| Factures | `/api/bills` |
| Paiements | `/api/payments` |

---

## 7. Contrôle d'Accès

| Groupe | Middleware appliqué |
|---|---|
| Routes RH | `auth:sanctum` + `role:staff` + `departement:RH` |
| Routes Chef Personnel | `auth:sanctum` + `role:staff` + `departement:ChefPersonnel` |
| Routes Client | `auth:sanctum` + `role:client` |
| Routes Admin | À sécuriser (middleware commenté en développement) |

---

## 8. Déploiement

| Composant | Détail |
|---|---|
| **Docker Compose** | Services : backend (Laravel), frontend (Vue/Vite), Nginx |
| **Nginx** | Reverse proxy configuré dans `nginx/default.conf`, port 8080 |
| **Storage** | Images chambres/plats dans `storage/app/public/` |
| **PDF Absences** | Stockés dans `storage/app/public/` |
| **Lien symbolique** | `public/storage` → `storage/app/public` |

---

## 9. Points d'Amélioration Identifiés

| Priorité | Point |
|---|---|
| 🔴 Haute | Les middlewares d'authentification Admin sont commentés — sécurité à renforcer impérativement |
| 🔴 Haute | Absence de guards de navigation Vue Router (routes non protégées côté frontend) |
| 🟠 Moyenne | Certaines requêtes frontend n'envoient pas le header `Authorization` Bearer |
| 🟠 Moyenne | La validation de commande restaurant (`validationCommande.vue`) n'est pas finalisée |
| 🟡 Basse | Pas de pagination côté frontend |
| 🟡 Basse | Pas de système de notifications (absences, nouvelles réservations) |
| 🟡 Basse | Base de données SQLite à migrer vers MySQL/PostgreSQL en production |
