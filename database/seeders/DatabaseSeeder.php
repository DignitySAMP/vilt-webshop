<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use App\Models\SupplierOrder;
use App\Models\SupplierOrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = fake();

        $users = collect();
        $seedUserRelations = function (User $user) use ($faker): void {
            $user->contacts()->create([
                'name' => $faker->name(),
                'role' => $faker->jobTitle(),
                'email' => $faker->safeEmail(),
                'phone' => $faker->phoneNumber(),
            ]);
            $user->addresses()->create([
                'street' => $faker->streetName(),
                'number' => (string) $faker->buildingNumber(),
                'city' => $faker->city(),
                'postal' => $faker->postcode(),
                'area' => $faker->state(),
                'country' => $faker->country(),
            ]);
            if ($faker->boolean()) {
                $user->payment_methods()->create([
                    'name' => $faker->word(),
                    'type' => $faker->randomElement(['card', 'paypal', 'bank']),
                    'identifier' => $faker->creditCardNumber(),
                    'code' => (string) $faker->randomNumber(4),
                ]);
            }
        };

        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('test@example.com'),
        ]);
        $seedUserRelations($testUser);
        $users->push($testUser);

        foreach (range(1, 8) as $index) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);
            $seedUserRelations($user);
            $users->push($user);
        }

        $categoryData = [
            ['name' => 'Electronics', 'description' => 'Consumer tech and gadgets'],
            ['name' => 'Home', 'description' => 'Household essentials'],
            ['name' => 'Outdoors', 'description' => 'Outdoor and garden gear'],
            ['name' => 'Wellness', 'description' => 'Health and wellness'],
            ['name' => 'Office', 'description' => 'Office and productivity'],
            ['name' => 'Fashion', 'description' => 'Apparel and accessories'],
        ];
        $categories = collect($categoryData)->map(fn (array $data) => ItemCategory::create($data));

        $supplierNames = [
            'Aurora Imports',
            'Beacon Supplies',
            'Cobalt Wholesale',
            'Driftwood Traders',
            'Evergreen Partners',
            'Fieldstone Goods',
            'Harbor & Co',
            'Ivy Lane Distribution',
        ];

        $suppliers = collect($supplierNames)->map(function (string $name) use ($faker) {
            $supplier = Supplier::create([
                'name' => $name,
                'description' => $faker->sentence(),
            ]);
            $contactTotal = random_int(1, 3);
            foreach (range(1, $contactTotal) as $i) {
                $supplier->contacts()->create([
                    'name' => $faker->name(),
                    'role' => $faker->jobTitle(),
                    'email' => $faker->safeEmail(),
                    'phone' => $faker->phoneNumber(),
                ]);
            }

            return $supplier;
        });

        $itemTotal = random_int(30, 40);
        $items = collect(range(1, $itemTotal))->map(function (int $index) use ($faker, $categories, $suppliers) {
            $category = $categories->random();
            $supplier = $suppliers->random();

            return Item::create([
                'item_category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'name' => ucfirst($faker->word()).' '.$index,
                'description' => $faker->sentence(),
                'image' => 'https://picsum.photos/seed/'.uniqid('', true).'/600/400',
                'price' => $faker->randomFloat(2, 5, 500),
                'stock' => random_int(0, 200),
            ]);
        });

        $users->each(function (User $user) use ($faker, $items) {
            $orderCount = random_int(1, 3);
            foreach (range(1, $orderCount) as $i) {
                $status = $faker->boolean(40) ? 'finished' : 'pending';
                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => $status,
                ]);
                $lineItems = $items->random(random_int(1, 4));
                if ($lineItems instanceof Item) {
                    $lineItems = collect([$lineItems]);
                }
                $total = 0;
                foreach ($lineItems as $item) {
                    $quantity = random_int(1, 5);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'item_id' => $item->id,
                        'amount' => $quantity,
                        'price' => $item->price,
                    ]);
                    $total += $item->price * $quantity;
                }
                if ($status === 'finished') {
                    $order->payments()->create([
                        'method' => $faker->randomElement(['card', 'ideal', 'bank_transfer']),
                        'amount' => $total,
                    ]);
                }
            }
        });

        $suppliers->each(function (Supplier $supplier) use ($faker, $items) {
            if (! $faker->boolean(75)) {
                return;
            }
            foreach (range(1, 6) as $i) {
                $address = SupplierAddress::create([
                    'supplier_id' => $supplier->id,
                    'name' => $supplier->name.' Warehouse',
                    'street' => $faker->streetName(),
                    'number' => (string) $faker->buildingNumber(),
                    'city' => $faker->city(),
                    'postal' => $faker->postcode(),
                    'area' => $faker->state(),
                    'country' => $faker->country(),
                ]);
            }
            
            foreach (range(1, 15) as $i) {
                $statuses = ['pending', 'processing', 'completed'];
                $supplierOrder = SupplierOrder::create([
                    'supplier_id' => $supplier->id,
                    'status' => $statuses[array_rand($statuses)],
                ]);
                $selection = $items->random(random_int(5, 15));
                if ($selection instanceof Item) {
                    $selection = collect([$selection]);
                }
                foreach ($selection as $item) {
                    SupplierOrderItem::create([
                        'supplier_order_id' => $supplierOrder->id,
                        'item_id' => $item->id,
                        'amount' => random_int(5, 25),
                    ]);
                }
            }
        });
    }
}
