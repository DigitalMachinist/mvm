<?php

use GuzzleHttp\Client as Guzzle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadPasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guzzle = new Guzzle();
        $response = $guzzle->get(config('mvm.auth.password.bad_passwords_url'));

        $badPasswords = collect(explode("\n", $response->getBody()->getContents()))
            ->filter(function ($password) {
                return strlen($password) >= config('mvm.auth.password.min_length');
            })
            ->chunk($chunkSize = 100);

        echo "{$badPasswords->count()} chunks of {$chunkSize} to insert.\n";

        DB::transaction(function () use ($badPasswords) {
            DB::table('bad_passwords')->truncate();
            foreach ($badPasswords as $i => $chunk) {
                DB::table('bad_passwords')->insert($chunk->toArray());

                $chunkNum = $i + 1;
                echo "Chunk {$chunkNum} inserted.\n";
            }
        });
    }
}
