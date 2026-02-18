# Dynamic Theme Setup (Laravel)

Theme colors are configurable from **Admin Panel → Site Settings**. The website uses these values everywhere via CSS variables. Colors are stored in the **`theme_settings`** table.

## 1. Database: `theme_settings` table

Migration: `database/migrations/xxxx_create_theme_settings_table.php`

| Column            | Type     | Default   |
|-------------------|----------|-----------|
| id                | bigint   | -         |
| name              | string   | 'Default' |
| primary_color     | string   | #059669   |
| secondary_color   | string   | #047857   |
| accent_color      | string   | #10B981   |
| text_dark_color   | string   | #1a1a1a  |
| text_light_color  | string   | #666666   |
| background_color  | string   | #ffffff   |
| success_color     | string   | #10B981   |
| warning_color     | string   | #F59E0B   |
| error_color       | string   | #EF4444   |
| is_active         | boolean  | true      |
| created_at        | timestamp| -         |
| updated_at        | timestamp| -         |

- **Model:** `App\Models\ThemeSetting` (fillable, cache via `getActive()`, `toColorArray()`).
- Run migration: `php artisan migrate`
- Seed default row: `php artisan db:seed --class=ThemeSeeder`

## 2. Admin Panel

- Go to **Admin → Site Settings** (after logging in as admin).
- The **Theme Colors** section is at the top.
- For each color you can:
  - Use the **color picker** (square) to choose visually.
  - Or type a **hex code** (e.g. `#059669`) in the text field.
- Click **Save Settings** to apply.

### Theme keys

| Key           | Default   | Usage                    |
|---------------|-----------|--------------------------|
| Primary       | #059669   | Main brand, buttons, nav |
| Secondary     | #047857   | Gradients, hover         |
| Accent        | #10B981   | Highlights, links        |
| Text Dark     | #1a1a1a  | Headings, body           |
| Text Light    | #666666   | Muted text               |
| Background    | #ffffff   | Page background          |
| Success       | #10B981   | Success states           |
| Warning       | #F59E0B   | Warnings                 |
| Error         | #EF4444   | Errors                   |

## 3. How it works

- **Config:** `config/theme.php` holds default values (used when no row in `theme_settings` exists).
- **Storage:** Values are stored in the **`theme_settings`** table. Model: `App\Models\ThemeSetting`. One active row (e.g. `is_active = true` or first row) is used site-wide. Cache key: `theme_settings_active`.
- **Layout:** `AppServiceProvider` passes `themeCssVars` to `layouts.app`. The layout injects a `<style>` block that sets `:root { --primary-green: ...; --light-green: ...; ... }`.
- **CSS:** `public/css/theme.css` already uses these variables (e.g. `var(--primary-green)`). When admin changes colors and saves, `ThemeSetting` is updated and cache is cleared; the next page load uses the new colors.

## 4. Adding more theme options

1. Add a new column in a **migration** for `theme_settings` (e.g. `link_color`).
2. Add the column to **`ThemeSetting`** model `$fillable` and to **`toColorArray()`** (e.g. `'theme_link' => $this->link_color`).
3. Add the key and default in **`config/theme.php`** (`defaults` and `css_map`).
4. Add validation and save logic in **`SiteSettingController`** (theme_* request keys and mapping to the new column).
5. Add an input in **`resources/views/admin/settings/edit.blade.php`** in the Theme Colors section.
6. In **`AppServiceProvider`**, add the new variable to `$themeVars` (from `$colors` or defaults).
7. Use the new variable in **`public/css/theme.css`** (e.g. `color: var(--link);`).

## 5. API for mobile app

- **GET** `/api/v1/theme` returns JSON with all theme colors (public, no auth).
- Use this in the FarmingApp to fetch brand colors from the server and apply them dynamically.

Example response:

```json
{
  "theme": {
    "theme_primary": "#059669",
    "theme_secondary": "#047857",
    "theme_accent": "#10B981",
    "theme_text_dark": "#1a1a1a",
    "theme_text_light": "#666666",
    "theme_background": "#ffffff",
    "theme_success": "#10B981",
    "theme_warning": "#F59E0B",
    "theme_error": "#EF4444",
    "gradient_primary": "linear-gradient(135deg, #059669 0%, #047857 100%)"
  }
}
```

## 6. Seeder

- **ThemeSeeder** inserts one row into **`theme_settings`** with default colors (only if the table is empty).
- Run `php artisan migrate` then `php artisan db:seed --class=ThemeSeeder`, or run `php artisan db:seed` (ThemeSeeder is called from DatabaseSeeder).

## 7. Cache

- `ThemeSetting::getActive()` is cached (key: `theme_settings_active`). The model clears this cache on `saved` and `deleted`. After changing theme in admin, the next page load uses the new colors.
- If you change theme directly in the DB, run `php artisan cache:clear` or `ThemeSetting::clearCache()` to see updates.
