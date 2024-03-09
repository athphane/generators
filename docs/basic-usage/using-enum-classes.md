---
title: Using Enum classes
sidebar_position: 4
---

If you want to use a PHP Enum class for a column instead of a MySQL `enum` or `set` type, you can indicate to the generator that the column should use an Enum class by adding a comment to the column in the format `enum:<EnumClass>`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrderStatuses;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();           
            $table->string('status')->index()->comment('enum:' . OrderStatuses::class);
            $table->timestamps();
        });
    }
}
```

Now the generator will utilize the `OrderStatuses` Enum class when generating all the relevant code for the `status` column.
