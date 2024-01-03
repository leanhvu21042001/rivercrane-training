# Tài liệu tổng

## Cách tạo dự án

```sh
# Tạo ứng dụng
composer create-project laravel/laravel <app_name>

# Chạy ứng dụng
php artisan serve
```

## Cách tạo model và migration

```sh
# Tạo model, thêm --migration để tự động tạo migration cho model.
php artisan make:model <ModelName> --migration

# Chạy migration để tạo table sau khi đã điền tên table và điền toàn bộ table fields phù hợp.
php artisan migrate
```

## Cách tạo Seeder và Factory đồng thời sử dụng Facker

```sh
# Tạo Seeder
php artisan make:seeder <SeederName>

# Tạo Factory
php artisan make:factory <FactoryName>

# Chạy Seeder để tạo dữ liệu mẫu sau khi đã setup xong Seeder vào SeederDatabase.php
# và factory dùng faker để xử lý dữ liệu mẫu.
php artisan db:seed
```

- Refs:
  - [seeding](https://laravel.com/docs/10.x/seeding#writing-seeders)

```php
// Example
<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     *Run the database seeds.
     *
     *@return void
     */
    public function run()
    {
        return User::factory()->count(1000)->create();
    }
}


<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
    }
}

```

```php

<?php // Use UserSeeder Here
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
    }
}
```

- [factory](https://laravel.com/docs/10.x/seeding#using-model-factories)

```php
// Example
<?php namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => fake()->name(),
            "email" => fake()
                ->unique()
                ->safeEmail(),
            "password" => fake()->password(),
            "remember_token" => Str::random(100),
            "verify_email" => fake()->randomElement([
                null,
                fake()
                    ->unique()
                    ->safeEmail(),
            ]),
            "is_active" => fake()->randomElement([0, 1]),
            "is_delete" => fake()->randomElement([0, 1]),
            "last_login_at" => fake()->dateTimeThisYear(),
            "last_login_ip" => fake()->ipv4(),
            "created_at" => fake()->dateTimeThisDecade(),
            "updated_at" => fake()->dateTimeThisDecade(),
        ];
    }
}
```

## Câu lệnh rút gọn tạo controller, model, seeder, factory, migration, policy

- [Origin Docs](https://laravel.com/docs/10.x/eloquent#generating-model-classes)
- [Read more detail](https://stackoverflow.com/questions/43187735/laravel-create-model-controller-and-migration-in-single-artisan-command)

```sh

# To Generate a migration, seeder, factory and resource controller for the model

php artisan make:model <ModelName> -a

Other Options
-c, --controller # Create a new controller for the model

-f, --factory # Create a new factory for the model

--force # Create the class even if the model already exists

-m, --migration # Create a new migration file for the model

-s, --seed # Create a new seeder file for the model

-p, --pivot # Indicates if the generated model should be a custom intermediate table model

-r, --resource # Indicates if the generated controller should be a resource controller

# For More Help
php artisan make:model <ModelName> -help

```

## Cách tạo một **Symlink** từ /storage -> /public

- B1: Tạo folder trong `/storage/app/public`
- B2: Vào file `filesystems.php` để cập nhập thông tin `links`

```php
'links' => [
        // public_path('storage') => storage_path('app/public'),
        public_path('uploads') => storage_path('app/uploads'),
    ],
```

- B3: Chạy câu lệnh để tự động tạo `symlink`

```sh
php artisan storage:link
```

> Mặc định laravel sẽ lưu những file upload lên vào `/storage/app/public` và cần tạo một `symbolic link` để liên kết từ `/storage` đến `/public`.

- Các xử lý khác nếu không muốn lưu vào /storage [Laravel Public Files with No Symlink: in Public Folder Instead of Storage](https://laraveldaily.com/post/laravel-public-files-with-no-symlink-in-public-folder-instead-of-storage)

<!--  -->
