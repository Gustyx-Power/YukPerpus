<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'judul' => $this->faker->sentence(3),
            'pengarang' => $this->faker->name,
            'penerbit' => $this->faker->company,
            'tahun_terbit' => $this->faker->year,
            'jumlah_halaman' => $this->faker->numberBetween(50, 1000),
            'stok' => $this->faker->numberBetween(1, 100),
            'deskripsi' => $this->faker->paragraph,
            'category_id' => Category::factory(),
            'status' => $this->faker->randomElement(['tersedia', 'dipinjam', 'rusak']),
        ];
    }
}