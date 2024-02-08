---
title: Available generators
sidebar_position: 2
---

The available generators and what they generate are given below:

```bash
# creates database/factories/ProductFactory.php
php artisan generate:factory products --create

# adds permissions to database/seeders/PermissionsSeeder.php
php artisan generate:permissions products --create

# creates app/Models/Product.php
# adds subject type and morph map to app/Providers/AppServiceProvider.php
php artisan generate:model products --create

# creates app/Policies/ProductPolicy.php
php artisan generate:policy products --create

# creates app/Http/Requests/ProductsRequest.php
php artisan generate:request products --create
```
