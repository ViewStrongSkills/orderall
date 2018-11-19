<?php

use Illuminate\Database\Seeder;
use App\OperatingHour;
use App\MenuExtra;
use App\MenuItem;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Business::class, 25)->create()->each(function ($u) {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 7; $i++) {
          if ($value = rand(0,3) != 3) {
            $opening = $faker->time($format = 'H:i:s', $max = '10:00:00');
            OperatingHour::create([
              'opening_time' => $opening,
              'closing_time' => $faker->time($format = 'H:i:s', $min = $opening),
              'day' => $i,
              'entry_type' => 'App\Business',
              'entry_id' => $u->id,
            ]);
          }
        }
        for ($j=0; $j < mt_rand(1,4); $j++) {
          $u->tags()->save(factory(App\Tag::class)->make());
        }
        for ($k=0; $k < mt_rand(1,4); $k++) {
          $u->menus()->save(factory(App\Menu::class)->make())->each(function ($x) {
            $faker = Faker\Factory::create();
              $menuitem = MenuItem::create([
                      'price' => $faker->numberBetween(10, 20),
                      'discount' => $faker->numberBetween(1, 10),
                      'name' => $faker->word(),
                      'description' => $faker->paragraph(),
                      'category' => 'test-cat',
                      'image_path' => '739aaf363bbfa91612f09ac9cee380e0',
                      'menu_id' => $x->id,
              ]);
              for ($c=0; $c < 3; $c++) {
                MenuExtra::create([
                  'name' => $faker->word(),
                  'price' => mt_rand(0, 5),
                  'menu_item_id' => $menuitem->id,
                  'menu_extra_category_id' => 0,
                ]);
              }
          });
        }
      });
    }
}
