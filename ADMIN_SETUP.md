# Admin Panel Setup (FasalSarthi)

## Admin login

- **URL:** `/admin/login`  
  Example: `http://localhost:8000/admin/login` (when using `php artisan serve`)

- **Default credentials (change in production):**
  - **Email:** `admin@fasalsarthi.com`
  - **Password:** `password`

After login you are redirected to **Dashboard** at `/admin/dashboard`.

## Running the Laravel app

From the `laravel` folder:

```bash
php artisan serve
```

Then open: `http://127.0.0.1:8000/admin/login`

## Add another admin

Use Tinker or create a seeder:

```bash
php artisan tinker
>>> \App\Models\Admin::create(['name' => 'New Admin', 'email' => 'new@example.com', 'password' => 'secret']);
```

## Security

- Change the default admin password after first login (e.g. via a “Change password” feature or by updating the database).
- In production, use a strong `APP_KEY` and set `APP_DEBUG=false` in `.env`.

## Next steps

The admin panel is ready. Next you can:

- Move your HTML pages into Blade views and serve them from Laravel.
- Add CRUD for schemes, crops, irrigation, blog, etc., and link them from the dashboard.
