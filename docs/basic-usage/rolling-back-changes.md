---
title: Rolling back changes
sidebar_position: 3
---

If you want to roll back the changes made by the generator, you can run the following command.

```bash
php artisan generate:rollback
```

:::danger

If you run this command you will lose all uncommitted changes. So make sure any changes you want to keep are commited before running this command.

:::
