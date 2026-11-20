MEMBER 1 — AUTHENTICATION, DASHBOARDS, PUBLIC PAGES

Copy the folders into the matching locations of the shared Laravel project.
This archive contains the complete integrated routes/web.php from the source package.
It already includes Member 2's student complaint routes and the admin routes owned by
other modules. Do not replace it with a partial route file from another member; resolve
route changes together before merging.

IMPORTANT DEPENDENCIES
- DashboardController uses Complaint and PortalNotification models supplied by Member 2.
- The layout links to admin and super-admin route names supplied by the admin module.
- The profile-fields migration must run after the base create_users_table migration.
- If your Laravel project already has the default create_users_table migration or UserFactory,
  compare them before copying to avoid duplicate migration/class files.
- Existing layout styling is currently inline in layouts/app.blade.php. app.css/app.js and
  bootstrap.js are included as the requested Vite asset entry points; they are not automatically
  loaded by the current inline-style layout. Keep your project's existing Vite setup.

FILES INCLUDE: AuthController, EnsureRole, User, DashboardController, web routes, middleware
alias, login/register, student/admin dashboards, shared layout, home, UserFactory, user migrations,
CSS and JS entry points.

Do not commit .env or overwrite the shared database. Back up and review Git changes first.
