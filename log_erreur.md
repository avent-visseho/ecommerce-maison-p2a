Internal Server Error

Copy as Markdown
Illuminate\Database\QueryException
vendor/laravel/framework/src/Illuminate/Database/Connection.php:824
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'effective' in 'SELECT' (Connection: mysql, SQL: select min(`effective`) as aggregate from `product_variants` where `product_variants`.`product_id` = 2 and `product_variants`.`product_id` is not null and `is_active` = 1 and `product_variants`.`deleted_at` is null)

LARAVEL
12.35.1
PHP
8.4.1
UNHANDLED
CODE 42S22
500
GET
http://127.0.0.1:8000/shop

Exception trace
13 vendor frames

app/Models/Product.php
app/Models/Product.php:128

123            return $this->effective_price;
124        }
125
126        $variantMinPrice = $this->activeVariants()
127            ->selectRaw('COALESCE(COALESCE(sale_price, price), ?) as effective', [$this->price])
128            ->min('effective');
129
130        return min($this->effective_price, $variantMinPrice ?? $this->effective_price);
131    }
132
133    /**
134     * Get maximum price (product or variants).
135     */
136    public function getMaxPriceAttribute()
137    {
138        if (!$this->hasVariants()) {
139            return $this->effective_price;
140
5 vendor frames

app/Models/Product.php
app/Models/Product.php:170

5 vendor frames

resources/views/public/shop/index.blade.php
resources/views/public/shop/index.blade.php:258

13 vendor frames

app/Http/Middleware/TrackVisitor.php
app/Http/Middleware/TrackVisitor.php:36

1 vendor frame

app/Http/Middleware/SetLocale.php
app/Http/Middleware/SetLocale.php:50

1 vendor frame

app/Http/Middleware/CheckMaintenanceMode.php
app/Http/Middleware/CheckMaintenanceMode.php:26

43 vendor frames

public/index.php
public/index.php:20

1 vendor frame

Queries
1-10 of 12
mysql
select * from `sessions` where `id` = 'WYoA2mJimtjzgpV2kqEVDiqzWWSaFe5L9DnComZB' limit 1
3.5ms
mysql
select * from `users` where `id` = 1 limit 1
1.11ms
mysql
insert into `site_visits` (`ip_address`, `user_agent`, `url`, `referer`, `session_id`, `user_id`, `visited_at`, `updated_at`, `created_at`) values ('127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/shop', 'http://127.0.0.1:8000/', 'WYoA2mJimtjzgpV2kqEVDiqzWWSaFe5L9DnComZB', 1, '2025-12-29 01:53:57', '2025-12-29 01:53:57', '2025-12-29 01:53:57')
6.79ms
mysql
select count(*) as aggregate from `products` where `is_active` = 1 and `stock` > 0 and `products`.`deleted_at` is null
0.96ms
mysql
select * from `products` where `is_active` = 1 and `stock` > 0 and `products`.`deleted_at` is null order by `created_at` desc limit 12 offset 0
1.09ms
mysql
select * from `categories` where `categories`.`id` in (1)
0.93ms
mysql
select * from `categories` where `is_active` = 1 and `parent_id` is null
0.99ms
mysql
select * from `brands` where `is_active` = 1
0.91ms
mysql
select count(*) as aggregate from `products` where `is_active` = 1 and `products`.`deleted_at` is null
1.04ms
mysql
select * from `products` where `products`.`category_id` = 1 and `products`.`category_id` is not null and `products`.`deleted_at` is null
1.08ms


1
2


Headers
host
127.0.0.1:8000
connection
keep-alive
sec-ch-ua
"Chromium";v="142", "Google Chrome";v="142", "Not_A Brand";v="99"
sec-ch-ua-mobile
?0
sec-ch-ua-platform
"Linux"
upgrade-insecure-requests