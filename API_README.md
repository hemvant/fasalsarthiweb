# Farming App API (Laravel)

API for the FarmingApp mobile app: social login (Google/Facebook), user profile, and future farming features.

## Folder structure

- **`routes/api.php`** – API routes (prefix: `/api/v1`)
- **`app/Http/Controllers/Api/`**
  - **`AuthController.php`** – Google/Facebook login (token or code exchange), logout
  - **`UserController.php`** – Get/update user profile (e.g. mobile)
- **`app/Models/User.php`** – User model with `provider`, `provider_id`, `mobile` (nullable), `password` (nullable for social users)

## Setup

1. **Sanctum** (installed)
   ```bash
   php artisan migrate
   ```

2. **Environment** – add to `.env`:
   ```env
   # Google OAuth (for code exchange from mobile)
   GOOGLE_CLIENT_ID=your-google-client-id.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=your-google-client-secret

   # Facebook OAuth
   FACEBOOK_APP_ID=your-facebook-app-id
   FACEBOOK_APP_SECRET=your-facebook-app-secret
   ```

3. **CORS** – If the app runs on a different origin (e.g. Expo web or device), allow it in `config/cors.php` or middleware so `/api/*` accepts requests from the app origin.

## Endpoints

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/v1/auth/google` | No | Body: `{ "access_token": "..." }`. Returns `{ token, user }`. |
| POST | `/api/v1/auth/google/code` | No | Body: `{ "code", "redirect_uri" }`. Exchange Google code for `{ token, user }`. |
| POST | `/api/v1/auth/facebook` | No | Body: `{ "access_token": "..." }`. Returns `{ token, user }`. |
| POST | `/api/v1/auth/facebook/code` | No | Body: `{ "code", "redirect_uri" }`. Exchange Facebook code for `{ token, user }`. |
| POST | `/api/v1/auth/logout` | Bearer | Revoke current token. |
| GET | `/api/v1/user` | Bearer | Get current user. |
| PATCH | `/api/v1/user` | Bearer | Update user. Body: `{ "name"?, "mobile"? }`. |

User object: `{ id, name, email, mobile, provider }`.

## Mobile app base URL

Set in the app (e.g. `FarmingApp/src/config/api.ts` or env):

- Local: `http://localhost:8000` (simulator) or `http://YOUR_IP:8000` (device)
- Production: your Laravel API URL
