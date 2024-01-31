---
title: Customising stubs
---

You can customise the stubs used by the generators by publishing them:

```bash
php artisan vendor:publish --provider="Javaabu\Generators\GeneratorsServiceProvider" --tag="generators-stubs"
```

The stubs would be located in `stubs/vendors/generators` directory.
