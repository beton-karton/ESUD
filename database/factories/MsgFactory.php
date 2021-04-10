<?php

namespace Database\Factories;

use App\Models\Msg;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MsgFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Msg::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'msg' => Str::random(5).' '.Str::random(10).' '.Str::random(15)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
