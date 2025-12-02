<?php

namespace Database\Seeders;

use App\Models\Todolist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todolist::insert([
            [
                "name" => "Belajar Coding",
                "desc" => "Belajar coding dengan laravel",
                "is_done" => false
            ],
            [
                "name" => "Bersepeda",
                "desc" => "Bersepeda pagi keliling kota",
                "is_done" => false
            ]
        ]);
    }
}
