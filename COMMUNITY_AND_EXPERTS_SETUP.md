# Farmer Community & Expert Portal – Setup

## Overview

- **Mobile API** (Farmer Community): Feed, create post, post detail, like/comment/reply/follow/report. Uses Sanctum auth.
- **Expert Web Portal** (PWA): Google OAuth only, expert registration, dashboard, answer questions, articles, profile.
- **Admin Panel**: Dashboard stats, manage experts/posts/answers/reports/problem categories/users/expert articles.

## Environment

- Run migrations: `php artisan migrate`
- Seed problem categories: `php artisan db:seed --class=ProblemCategorySeeder` (or full `php artisan db:seed` after adding to `DatabaseSeeder`).
- **Expert Google OAuth** (`.env`):
  - `GOOGLE_CLIENT_ID=...`
  - `GOOGLE_CLIENT_SECRET=...`
  - `GOOGLE_REDIRECT_URI={{ APP_URL }}/expert/auth/google/callback`
- Install Socialite: `composer require laravel/socialite`

## Roles & Middleware

- **Farmer**: API under `auth:sanctum` (mobile app).
- **Expert**: Web routes under `auth`, `user.not_banned`, `expert` (approved expert profile).
- **Admin**: Web routes under `admin` guard (separate `admins` table).

## Key Routes

- **API** (prefix `api/v1`): `GET/POST community/posts`, `GET community/posts/{id}`, `POST community/posts/{id}/like`, `POST community/answers/{id}/like`, `POST community/comments`, `POST community/follow/{userId}`, `POST community/report`, `GET community/crops`, `GET community/problem-categories`.
- **Expert**: `/expert` (landing), `/expert/login`, `/expert/auth/google`, `/expert/register`, `/expert/dashboard`, `/expert/questions`, `/expert/articles`, `/expert/profile`.
- **Admin**: `/admin/community/experts`, `/admin/community/posts`, `/admin/community/reports`, `/admin/community/problem-categories`, `/admin/community/users`, `/admin/community/articles`.

## PWA (Expert Portal)

- Manifest: `public/expert-manifest.json`
- Service worker: `public/expert-sw.js`
- Optional: add 192x192 and 512x512 icons at `public/images/icon-192.png` and `public/images/icon-512.png` for install prompt.

## Database

- **community_posts**: user_id, crop_id, problem_category_id, body, status, featured, report_count, likes_count, comments_count, expert_replied, comments_locked, is_solved.
- **community_answers**: community_post_id, user_id, body, is_pinned, is_best_answer, likes_count.
- **expert_profiles**: user_id, qualification, experience, specialization, certificate_path, status (pending/approved/rejected/suspended), rating, total_answers, availability, verified, suspended_at, admin_notes.
- **reports**: reportable_type/id, user_id, reason, details, status, resolved_by (admin), resolved_at.
- **expert_articles**: user_id, expert_article_category_id, title, slug, body, featured_image, status, featured, approved.

## Notes

- Farmers create posts with min 20 chars, up to 3 images, crop and problem category. Feed supports latest/trending filters.
- Expert answers can include image/PDF attachments. Admin can pin answers and mark best answer.
- Expert articles require admin approval (approve sets `approved` and `status = published`).
