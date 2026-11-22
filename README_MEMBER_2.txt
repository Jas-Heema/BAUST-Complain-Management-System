MEMBER 2 — STUDENT COMPLAINT LIFECYCLE + SEEDING

Copy app/Http, app/Models, resources/views/complaints, database/migrations and
 database/seeders into the matching locations of the shared Laravel project.

ROUTES COORDINATION
- The requested routes are supplied as routes/member2_routes.patch.php because routes/web.php
  is shared with Member 1 and other modules.
- Merge these declarations into the existing routes/web.php INSIDE its auth group.
- Do not overwrite Member 1's routes/web.php with this patch.
- The source package's integrated routes/web.php already contains these routes; if using that
  file, do not add the patch again or route names will be duplicated.

MIGRATION ORDER
1. Member 1's create_users_table and add_profile_fields_to_users_table migrations.
2. create_complaint_categories_table.
3. create_complaints_table.
4. create_complaint_attachments_table.
5. create_complaint_status_histories_table.
6. create_portal_notifications_table.

The notification migration creates a table named `notifications`, matching the Laravel model
configuration in this package. Review that naming against any existing Laravel notifications
migration before merging.

The complaint controller stores evidence on Laravel's private `local` disk. It also includes
Storage facade import needed by secure attachment downloads.

Seeder creates demo admin accounts and complaint categories. Demo admin password is
Password123! (change it before any real use).

Never run `php artisan migrate:fresh --seed` against a database containing data you need; it drops
all tables. Back up first and coordinate migrations with the team.
