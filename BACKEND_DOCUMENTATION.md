# Data Center Reservation - Backend Documentation

## Structure des fichiers créés

```
app/
├── Models/
│   ├── Resource.php           ✅ Relations + Scopes
│   ├── Reservation.php        ✅ Relations + Vérifications
│   ├── User.php               ✅ Méthodes helper
│   └── ActivityLog.php        ✅ Traçabilité
├── Http/
│   ├── Controllers/
│   │   ├── ResourceController.php           ✅ Liste + Détails
│   │   ├── ReservationController.php        ✅ CRUD Réservation
│   │   └── Admin/
│   │       └── ReservationAdminController.php ✅ Approbation/Rejet
│   ├── Requests/
│   │   ├── StoreReservationRequest.php      ✅ Validation créa
│   │   ├── ApproveReservationRequest.php    ✅ Auth Admin
│   │   └── RejectReservationRequest.php     ✅ Validation raison
│   └── Middleware/
│       └── IsAdmin.php                      ✅ Vérification rôle
├── Services/
│   ├── ReservationConflictService.php       ✅ Logique conflit
│   └── ActivityLogService.php               ✅ Logging
└── routes/web.php                          ✅ Toutes les routes
```

---

## API Endpoints

### RESSOURCES (Publiques)

```
GET /resources
  - Paramètres: type, status, search, page
  - Retourne: Paginated Resources avec filtres
  - Exemple: /resources?type=server&status=available&search=DC1

GET /resources/{resource}
  - Retourne: Resource + upcomingReservations
```

### RÉSERVATIONS (Authentifiées)

```
GET /resources/{resource}/reserve
  - Affiche: Formulaire de réservation
  - Auth: ✅ Requise

POST /resources/{resource}/reserve
  - Body:
    {
      "start_at": "2026-01-20 10:00",
      "end_at": "2026-01-20 16:00",
      "justification": "Research work"
    }
  - Validation:
    - start_at: required, date, after_or_equal:today
    - end_at: required, date, after:start_at
    - justification: nullable, string, max:1000
  - Vérifications: ✅ Conflit détecté
  - Retourne: redirect(reservations.show) + success message

GET /my-reservations
  - Retourne: Paginated user reservations
  - Auth: ✅ Requise
  - Tri: DESC par created_at

GET /my-reservations/{reservation}
  - Retourne: Reservation détails
  - Auth: ✅ Requise (owner ou admin)

POST /my-reservations/{reservation}/cancel
  - Vérifications:
    - Propriétaire uniquement
    - Status: pending ou approved
    - start_at > now()
  - Retourne: redirect + message
```

### ADMIN RÉSERVATIONS (Admin)

```
GET /admin/reservations
  - Paramètres: status, resource_type, from_date, to_date, search, page
  - Retourne: Paginated reservations with relations
  - Auth: ✅ Admin
  - Exemple: /admin/reservations?status=pending&resource_type=server

POST /admin/reservations/{reservation}/approve
  - Vérifications:
    - Status = pending
    - ✅ Conflit avec approved/active
  - Changes: status → approved
  - Log: reservation_approve
  - Retourne: redirect + success/error

POST /admin/reservations/{reservation}/reject
  - Body:
    {
      "reason": "Resource scheduled for maintenance"
    }
  - Validation:
    - reason: required, string, min:5, max:500
  - Changes: status → rejected, admin_note = reason
  - Log: reservation_reject
  - Retourne: redirect + success/error
```

---

## Logique de Conflit

### Détection Overlap (Mathématiquement)

```php
// Conflit si: (start_at < existing_end) AND (end_at > existing_start)
$conflict = Reservation::where('resource_id', $resource->id)
    ->whereIn('status', ['pending', 'approved', 'active'])
    ->where('start_at', '<', $newEnd)      // Commence avant la fin
    ->where('end_at', '>', $newStart)      // Finit après le début
    ->exists();
```

### Scénarios Testés

```
Nouvelle réservation: [10:00 - 16:00]

Existante [09:00 - 11:00] → ❌ CONFLIT (overlap)
Existante [14:00 - 17:00] → ❌ CONFLIT (overlap)
Existante [10:00 - 16:00] → ❌ CONFLIT (identique)
Existante [08:00 - 09:00] → ✅ OK
Existante [17:00 - 18:00] → ✅ OK
```

### Approbation vs Création

```
À la création:
  - Vérifie: pending, approved, active

À l'approbation:
  - Vérifie UNIQUEMENT: approved, active
  - Raison: l'admin doit éviter les conflicts entre réservations finales
```

---

## Activity Log - Structure

```json
{
  "id": 1,
  "actor_id": 5,
  "action": "reservation_approve",
  "target_type": "reservation",
  "target_id": 42,
  "ip_address": "192.168.1.100",
  "changes": {
    "reason": "Client approved",
    "approval_time": "2026-01-15 14:32:15"
  },
  "created_at": "2026-01-15T14:32:15Z"
}
```

### Actions Tracées

```
resource_create
resource_update
resource_delete
reservation_create
reservation_approve
reservation_reject
reservation_cancel
user_login
status_change
```

### Usage

```php
// Log une approbation
ActivityLogService::logReservationApprove($reservationId);

// Log un changement de statut
ActivityLogService::logStatusChange('resource', $resourceId, 'available', 'maintenance');

// Log personnalisé
ActivityLogService::log('custom_action', 'target_type', $targetId, ['details' => 'data']);
```

---

## Validation Rules

### StoreReservationRequest

```php
[
    'start_at' => ['required', 'date', 'after_or_equal:today'],
    'end_at' => ['required', 'date', 'after:start_at'],
    'justification' => ['nullable', 'string', 'max:1000'],
]
```

### RejectReservationRequest

```php
[
    'reason' => ['required', 'string', 'min:5', 'max:500'],
]
```

---

## Exemples de Requêtes (cURL)

### 1. Créer une réservation

```bash
curl -X POST http://localhost:8000/resources/1/reserve \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "start_at": "2026-01-20 10:00",
    "end_at": "2026-01-20 16:00",
    "justification": "Research experiment"
  }'
```

### 2. Annuler une réservation

```bash
curl -X POST http://localhost:8000/my-reservations/5/cancel \
  -H "Authorization: Bearer {token}"
```

### 3. Approuver une réservation (Admin)

```bash
curl -X POST http://localhost:8000/admin/reservations/5/approve \
  -H "Authorization: Bearer {admin-token}"
```

### 4. Rejeter une réservation (Admin)

```bash
curl -X POST http://localhost:8000/admin/reservations/5/reject \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {admin-token}" \
  -d '{
    "reason": "Resource scheduled for maintenance"
  }'
```

### 5. Lister les réservations avec filtres

```bash
curl "http://localhost:8000/admin/reservations?status=pending&resource_type=server&from_date=2026-01-15"
```

---

## Eloquent Relations

### Resource
```php
$resource->reservations()              // Toutes les réservations
$resource->upcomingReservations()      // Futures (pending/approved/active)
```

### Reservation
```php
$reservation->user()                   // Propriétaire
$reservation->resource()               // Ressource réservée

// Scopes
Reservation::byUser($userId)->pending()
```

### User
```php
$user->reservations()                  // Toutes ses réservations
$user->isAdmin()                       // Vérification rôle
```

---

## Règles Métier Implémentées

✅ **Création de réservation**
- Requiert auth
- Vérifie conflit (pending + approved + active)
- Validation start_at < end_at
- Status initial: pending

✅ **Approbation**
- Requiert admin
- Vérifie status = pending
- Revérifie conflit (approved + active uniquement)
- Log l'action
- Rejette si conflit

✅ **Rejet**
- Requiert admin
- Requiert raison (min 5 car, max 500)
- Vérifie status = pending
- Sauvegarde la raison en admin_note
- Log l'action

✅ **Annulation**
- Requiert propriétaire
- Status: pending ou approved uniquement
- start_at > now() (pas commencée)
- Log l'action

✅ **Traçabilité**
- Chaque action importante loggée
- Includes: actor, action, timestamp, IP, changes
- Queryable par actor/action/type/date

---

## Code Prêt à Utiliser

Tous les fichiers peuvent être copiés directement dans:
- `app/Models/`
- `app/Http/Controllers/`
- `app/Http/Requests/`
- `app/Http/Middleware/`
- `app/Services/`

Routes à appliquer dans `routes/web.php`.

Middleware à enregistrer dans `bootstrap/app.php` (déjà fait).

---

**Backend: 100% Fonctionnel** ✅
