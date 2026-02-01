Illuminate\Database\QueryException
vendor/laravel/framework/src/Illuminate/Database/Connection.php:824
SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`ecommerce-maison-p2a`.`users`, CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE) (Connection: mysql, SQL: insert into `users` (`name`, `email`, `password`, `updated_at`, `created_at`) values (visseho ezechiel, ezev77@gmail.com, $2y$12$d5zmCgkaNqRqJUDR7/Vw4uhWxriysqMrJisk6qPv5WgmUnziiQuD2, 2026-02-01 10:22:26, 2026-02-01 10:22:26))

LARAVEL
12.35.1
PHP
8.4.1
UNHANDLED
CODE 23000
500
POST
http://127.0.0.1:8000/register

