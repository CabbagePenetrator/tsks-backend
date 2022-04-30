<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CollectionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_collections_can_be_viewed()
    {
        $collections = Collection::factory()->count(3)->create();

        $this->get(route('collections'))
            ->assertOk()
            ->assertJson([
                'collections' => $collections->toArray(),
            ]);
    }

    public function test_a_collection_can_be_viewed()
    {
        $collection = Collection::factory()->create();

        $this->get(route('collections.show', $collection))
            ->assertOk()
            ->assertJson([
                'collection' => $collection->toArray(),
            ]);
    }

    public function test_a_collection_can_be_created()
    {
        Storage::fake('icons');

        $icon = UploadedFile::fake()->image('icon.jpg');

        $this
            ->post(route('collections.store'), [
                'name' => 'A new collection',
                'icon' => $icon,
                'color' => '#CC5F88',
            ])
            ->assertCreated()
            ->assertJson([
                'collection' => [
                    'name' => 'A new collection',
                    'icon' => "icons/{$icon->hashName()}",
                    'color' => '#CC5F88',
                ]
            ]);

        Storage::assertExists("icons/{$icon->hashName()}");

        $this->assertDatabaseHas(Collection::class, [
            'name' => 'A new collection',
            'icon' => "icons/{$icon->hashName()}",
            'color' => '#CC5F88',
        ]);
    }

    public function test_a_collection_can_be_updated()
    {
        Storage::fake('icons');

        $icon = UploadedFile::fake()->image('icon.jpg');

        $old = Collection::factory()->create();

        $new = Collection::factory()->make([
            'icon' => $icon,
        ]);

        $this
            ->put(route('collections.update', $old), $new->toArray())
            ->assertNoContent();

        Storage::assertExists("icons/{$icon->hashName()}");

        $this->assertDatabaseHas(Collection::class, [
            'name' => $new->name,
            'color' => $new->color,
            'icon' => "icons/{$icon->hashName()}",
        ]);
    }

    public function test_a_collection_can_be_deleted()
    {
        $collection = Collection::factory()->create();

        $this->delete(route('collections.destroy', $collection))
            ->assertNoContent();

        $this->assertDatabaseMissing(Collection::class, [
            'id' => $collection->id,
        ]);
    }
}
