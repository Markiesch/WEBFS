<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Dish;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderTestSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $dishes = Dish::all();
        if ($users->isEmpty() || $dishes->isEmpty()) {
            Log::warning('No users or dishes found for OrderTestSeeder.');
            return;
        }
        $today = Carbon::today();
        foreach (range(0, 6) as $daysAgo) {
            $date = $today->copy()->subDays($daysAgo);
            // Maak 3-7 orders per dag
            $orderCount = rand(3, 7);
            for ($i = 0; $i < $orderCount; $i++) {
                $user = $users->random();
                $order = Order::create([
                    'user_id' => $user->id,
                    'created_at' => $date->copy()->setTime(rand(10, 22), rand(0, 59)),
                    'updated_at' => $date->copy()->setTime(rand(10, 22), rand(0, 59)),
                ]);
                // Voeg 1-4 order items toe
                $itemCount = rand(1, 4);
                for ($j = 0; $j < $itemCount; $j++) {
                    $dish = $dishes->random();
                    OrderItem::create([
                        'order_id' => $order->id,
                        'dish_id' => $dish->id,
                        'quantity' => rand(1, 3),
                        'price' => $dish->price,
                        'note' => Str::random(10),
                    ]);
                }
            }
            // Genereer direct het Excel-bestand voor deze dag
            Artisan::call('app:daily-sales-summary', ['date' => $date->format('Y-m-d')]);
        }
    }
}
