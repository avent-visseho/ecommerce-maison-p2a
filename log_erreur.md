Internal Server Error

Copy as Markdown
Illuminate\Database\UniqueConstraintViolationException
vendor/laravel/framework/src/Illuminate/Database/Connection.php:819
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'grand-plateau-ovale-en-bois-dacacia' for key 'products_slug_unique' (Connection: mysql, SQL: insert into `products` (`name`, `description`, `long_description`, `price`, `sale_price`, `sku`, `stock`, `low_stock_alert`, `category_id`, `brand_id`, `main_image`, `is_active`, `is_featured`, `slug`, `updated_at`, `created_at`) values (Grand Plateau Ovale - en Bois d’Acacia, <div><strong>Univers du produit<br><br></strong>L’art du service naturel, le détail fait toute la différence. Le plateau ovale en bois d’acacia réinvente l’art de recevoir en mariant authenticité naturelle et design contemporain. Ses lignes douces et équilibrées mettent en valeur la noblesse du bois d’acacia, reconnu pour ses teintes chaleureuses et ses veinures uniques.<br><br>À la fois décoratif et fonctionnel, ce plateau sublime vos présentations lors d’un Tea Time ou d’un apéro…. Élégant sans ostentation, il s’intègre partout dans la maison et transforme chaque moment en une expérience conviviale.</div>, <div>Un accessoire essentiel de décoration d’intérieur pour mettre en scène vos bougies, senteurs ou tout simplement l’utiliser comme un vide poche.<br><br><strong>Caractéristiques clés</strong><br>29cm x 10,60cm<br>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;Design naturel et contemporain<br>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;Matériau durable et résistant à l’humidité&nbsp;<br>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;Surface lisse et ergonomique&nbsp;<br>- Finition bois<br>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;Utilisation : service, présentation et décoration d’intérieur&nbsp;<br>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;Entretien : nettoyage à la main recommandé</div>, 20, ?, PROD-XM6ZQ3VA, 35, 10, 3, ?, products/KrG8Q5cAk3nh7vjm08A9WyNBG2QM8a4vxmh7Iy4I.jpg, 1, 1, grand-plateau-ovale-en-bois-dacacia, 2025-12-30 18:27:52, 2025-12-30 18:27:52))

LARAVEL
12.35.1
PHP
8.4.1
UNHANDLED
CODE 23000
500
POST
http://127.0.0.1:8000/admin/products

Exception trace
15 vendor frames

app/Http/Controllers/Admin/ProductController.php
app/Http/Controllers/Admin/ProductController.php:79

74                $images[] = $image->store('products', 'public');
75            }
76            $validated['images'] = $images;
77        }
78
79        Product::create($validated);
80
81        return redirect()->route('admin.products.index')
82            ->with('success', 'Produit créé avec succès.');
83    }
84
85    public function edit(Product $product)
86    {
87        $categories = Category::active()->get();
88        $brands = Brand::active()->get();
89
90        return view('admin.products.edit', compact('product', 'categories', 'brands'));
91
5 vendor frames

app/Http/Middleware/AdminMiddleware.php
app/Http/Middleware/AdminMiddleware.php:26

1 vendor frame

app/Http/Middleware/TrackVisitor.php
app/Http/Middleware/TrackVisitor.php:36

1 vendor frame

app/Http/Middleware/SetLocale.php
app/Http/Middleware/SetLocale.php:50

1 vendor frame

app/Http/Middleware/CheckMaintenanceMode.php
app/Http/Middleware/CheckMaintenanceMode.php:26

45 vendor frames

public/index.php
public/index.php:20

1 vendor frame

Queries