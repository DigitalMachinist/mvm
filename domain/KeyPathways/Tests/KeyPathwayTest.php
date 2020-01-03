<?php

namespace Domain\Users\Tests;

use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class KeyPathwayTest extends TestCase
{
    use RefreshDatabase;

    function testKeyRelationship(): void
    {
        $key = factory(Key::class)->create();

        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id' => $key->id,
            ]);

        $this->assertEquals($key->id, $keyPathway->key()->value('id'));
    }

    function testPathwayRelationship(): void
    {
        $pathway = factory(Pathway::class)->create();

        $keyPathway = factory(KeyPathway::class)
            ->create([
                'pathway_id' => $pathway->id,
            ]);

        $this->assertEquals($pathway->id, $keyPathway->pathway()->value('id'));
    }
}
