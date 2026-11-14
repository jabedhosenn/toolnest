<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Plan;
use App\Models\RecentTool;
use App\Models\Subscription;
use App\Models\Tool;
use App\Models\ToolFavorite;
use App\Models\ToolTag;
use App\Models\UsageLog;
use App\Models\User;
use Database\Seeders\ToolDirectorySeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_endpoint_returns_the_seeded_categories_in_order(): void
    {
        $this->seed(ToolDirectorySeeder::class);
        $this->seed(ToolDirectorySeeder::class);

        $this->getJson('/api/categories')
            ->assertOk()
            ->assertJsonCount(9, 'data')
            ->assertJsonPath('data.0.name', 'Text Tools')
            ->assertJsonPath('data.1.name', 'Fancy Text')
            ->assertJsonPath('data.8.name', 'Utilities');

        $this->assertDatabaseCount('categories', 9);
        $this->assertDatabaseCount('tools', 12);
    }

    public function test_tools_endpoint_filters_active_tools_by_category_and_paginates_results(): void
    {
        $category = Category::factory()->create(['slug' => 'text-tools']);
        $firstTool = Tool::factory()->for($category)->create([
            'slug' => 'word-counter',
            'sort_order' => 1,
            'is_featured' => true,
        ]);
        Tool::factory()->for($category)->create([
            'slug' => 'sentence-counter',
            'sort_order' => 2,
            'is_featured' => true,
        ]);
        Tool::factory()->for($category)->create([
            'slug' => 'case-converter',
            'sort_order' => 3,
            'is_featured' => false,
        ]);
        Tool::factory()->for($category)->create([
            'slug' => 'inactive-tool',
            'is_active' => false,
            'is_featured' => true,
        ]);
        $otherCategory = Category::factory()->create(['slug' => 'other-category']);
        Tool::factory()->for($otherCategory)->create([
            'slug' => 'other-category-tool',
            'is_featured' => true,
        ]);
        $hiddenCategory = Category::factory()->create(['slug' => 'hidden-category', 'is_active' => false]);
        Tool::factory()->for($hiddenCategory)->create(['is_featured' => true]);

        $this->getJson('/api/tools?category=text-tools&featured=true&per_page=1')
            ->assertOk()
            ->assertJsonPath('data.0.id', $firstTool->id)
            ->assertJsonPath('data.0.category.slug', 'text-tools')
            ->assertJsonPath('meta.total', 2)
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonPath('meta.last_page', 2);
    }

    public function test_tool_detail_endpoint_returns_the_tool_and_its_category(): void
    {
        $category = Category::factory()->create(['slug' => 'developer-tools']);
        $tool = Tool::factory()->for($category)->create(['slug' => 'json-formatter']);

        $this->getJson('/api/tools/json-formatter')
            ->assertOk()
            ->assertJsonPath('data.id', $tool->id)
            ->assertJsonPath('data.category.slug', 'developer-tools')
            ->assertJsonPath('data.route_name', $tool->route_name)
            ->assertJsonPath('data.component_identifier', $tool->component_identifier);
    }

    public function test_tool_detail_endpoint_returns_404_for_an_inactive_tool(): void
    {
        $tool = Tool::factory()->create([
            'slug' => 'inactive-tool',
            'is_active' => false,
        ]);

        $this->getJson('/api/tools/'.$tool->slug)->assertNotFound();
    }

    public function test_popular_tools_endpoint_returns_only_active_popular_tools(): void
    {
        $popularTool = Tool::factory()->create([
            'slug' => 'popular-tool',
            'is_popular' => true,
            'sort_order' => 1,
        ]);
        Tool::factory()->create(['is_popular' => false]);
        Tool::factory()->create(['is_popular' => true, 'is_active' => false]);

        $this->getJson('/api/tools/popular?per_page=1')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', $popularTool->slug)
            ->assertJsonPath('meta.total', 1);
    }

    public function test_featured_tools_endpoint_returns_only_featured_tools(): void
    {
        $featuredTool = Tool::factory()->create([
            'slug' => 'featured-tool',
            'is_featured' => true,
        ]);
        Tool::factory()->create(['is_featured' => false]);

        $this->getJson('/api/tools/featured')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', $featuredTool->slug);
    }

    public function test_tool_search_endpoint_returns_matching_tagged_tools(): void
    {
        $tool = Tool::factory()->create(['slug' => 'markdown-preview']);
        ToolTag::factory()->for($tool)->create([
            'name' => 'markdown',
            'slug' => 'markdown',
        ]);
        Tool::factory()->create(['slug' => 'json-formatter']);

        $this->getJson('/api/tools/search?q=markdown')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', 'markdown-preview')
            ->assertJsonPath('data.0.tags.0', 'markdown');
    }

    public function test_tool_search_endpoint_requires_a_query_and_returns_422(): void
    {
        $this->getJson('/api/tools/search')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['q']);
    }

    public function test_directory_models_persist_their_relationships(): void
    {
        $category = Category::factory()->create();
        $tool = Tool::factory()->for($category)->create();
        $tag = ToolTag::factory()->for($tool)->create();
        $user = User::factory()->create();
        $favorite = ToolFavorite::factory()->for($user)->for($tool)->create();
        $recentTool = RecentTool::factory()->for($user)->for($tool)->create();
        $plan = Plan::factory()->create();
        $subscription = Subscription::factory()->for($user)->for($plan)->create();
        $usageLog = UsageLog::factory()->for($user)->for($tool)->create();

        $this->assertSame($category->id, $tool->category()->firstOrFail()->id);
        $this->assertSame($tool->id, $category->tools()->firstOrFail()->id);
        $this->assertSame($tool->id, $tag->tool()->firstOrFail()->id);
        $this->assertSame($user->id, $favorite->user()->firstOrFail()->id);
        $this->assertSame($tool->id, $favorite->tool()->firstOrFail()->id);
        $this->assertSame($tool->id, $tool->favoritedBy()->firstOrFail()->id);
        $this->assertSame($favorite->id, $user->toolFavorites()->firstOrFail()->id);
        $this->assertSame($tool->id, $recentTool->tool()->firstOrFail()->id);
        $this->assertSame($user->id, $recentTool->user()->firstOrFail()->id);
        $this->assertSame($recentTool->id, $user->recentTools()->firstOrFail()->id);
        $this->assertSame($user->id, $subscription->user()->firstOrFail()->id);
        $this->assertSame($plan->id, $subscription->plan()->firstOrFail()->id);
        $this->assertSame($subscription->id, $plan->subscriptions()->firstOrFail()->id);
        $this->assertSame($tool->id, $usageLog->tool()->firstOrFail()->id);
        $this->assertSame($user->id, $usageLog->user()->firstOrFail()->id);
        $this->assertSame($usageLog->id, $user->usageLogs()->firstOrFail()->id);
        $this->assertSame($tool->id, $user->favoriteTools()->firstOrFail()->id);
    }

    public function test_tool_favorites_reject_duplicate_user_tool_pairs(): void
    {
        $user = User::factory()->create();
        $tool = Tool::factory()->create();
        ToolFavorite::factory()->for($user)->for($tool)->create();

        $this->expectException(QueryException::class);

        ToolFavorite::factory()->for($user)->for($tool)->create();
    }
}
