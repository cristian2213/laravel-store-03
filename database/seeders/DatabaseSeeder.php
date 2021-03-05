<?php

namespace Database\Seeders;


use App\Models\Cart;
use App\Models\User;
use App\Models\Image;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
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
        //? make() : lo crea en memoria
        //? create() : lo crea en la base de datos
        //? User::factory()->count(5)->make(); : crea 5 en memoria
        //? \App\Models\User::factory(10)->create(); el argumento en el factory determina el numero de instancias a crear
        //? Payment::factory()->make(['order_id', $order->id]); se pasa el parametro a ser asoaciado como fk
        // ? $user->orders()->save(Order::factory()->make()); crea una instancia de Order asociada al usuario
        // ? $order->products()->attach([1 => ['quantity' => 4], 2 => ['quantity' => 5], 3 => ['quantity' => 3]]) poblar con datos las tablas pivotes, para poder ver los datos que fueron agregado se debe hacer otra vez el proceso de instanciar a una order, en este caso se hace con el metodo fresh() el cual permite traer los datos actualizado, asi: $order = $order->fresh(), luego de esto lo unico que se debe hacer es acceder a los datos por medio de la relacion creada con anterioridad, $order->products, recordar que el 1 y los demas numeros hace referencia a la posicion del producto


        //? $api = resolve('HelpSpot\API'); => intancia la clase automaticamente, la resulve
        //? $cookie->getName(); metodo para obtener la cookie a través de tinker
        //? $cookie->getExpiresTime(); obtener el tiempo de expiracion
        /* --------------------------------------------------------------------------------------------------------------------------- */


        //* creacion de imagenes que tiene un usuario
        $users = User::factory(20)
            ->create() // hasta aqui se crean los usuarios
            ->each(function ($user) {
                $image = Image::factory()
                    ->user()
                    ->make(); // por cada iteracion se crea una imagen del factory
                $user->image()->save($image); // se guarda la imagen asociada con el usuario por medio del imageable_type "App\Models\User"
            });
        /* --------------------------------------------------------------------------------------------------------------------------- */

        //* creacion de instancia de ordenes
        $orders = Order::factory(10)
            ->make() // se hacen en memoria las instancias de Order
            ->each(function ($order) use ($users) {  // se iteran los datos de la consulta, y se adgunto los usuarios //creados
                $order->customer_id = $users->random()->id; // se agrega a cada instancia de Order el id de un usuario //aleatorio
                $order->save(); // se guarda la instancia

                // Cuando la orden se crea entonces vamos a generar un pago, en este caso todo es aleatoriio
                $payment = Payment::factory()->make();
                //$payment->order_id = $order->id;
                //$payment->save();

                $order->payment()->save($payment); // creacion del pago a través de la relacion
            });
        /* --------------------------------------------------------------------------------------------------------------------------- */

        //* creacion de instancia de carritos
        $carts = Cart::factory(20)->create();
        /* --------------------------------------------------------------------------------------------------------------------------- */

        //* creacion de instancia de productos
        $products = Product::factory(50)
            ->create()
            ->each(function ($product) use ($orders, $carts) {
                $order = $orders->random(); // una ordern aleatoria
                $cart = $carts->random(); // un carrito aleatorio

                // asociacion de una orden a una producto en la tabla pivote y luego se adjunta la id del producto
                $order->products()->attach([
                    $product->id => ['quantity' => mt_rand(1, 3)]
                ]);

                $cart->products()->attach([
                    $product->id => ['quantity' => mt_rand(1, 3)]
                ]);

                // se le pasa el numero que imagenes que debe devolver por iteracion de forma alatoria
                $images = Image::factory(mt_rand(2, 4))->make();

                // saveMany es igual a save, simplemente este permite guardar una collection de imagenes, con save, solo se guardaria una imagen
                $product->images()->saveMany($images);
            });

        /* --------------------------------------------------------------------------------------------------------------------------- */
    }
}
