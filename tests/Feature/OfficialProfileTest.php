<?php

namespace Tests\Feature;

use App\Models\Award;
use App\Models\CareerHistory;
use App\Models\Child;
use App\Models\Education;
use App\Models\Official;
use App\Models\Organization;
use App\Models\OrganizationalHistory;
use App\Models\Position;
use App\Models\TrainingHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfficialProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_officials_created_through_crud_appear_on_profile_pages()
    {
        // Create test positions
        $bupatiPosition = Position::create([
            'name' => 'Bupati',
            'slug' => 'bupati',
            'is_single' => true,
        ]);

        $opdPosition = Position::create([
            'name' => 'Kepala OPD',
            'slug' => 'kepala-opd',
            'is_single' => false,
        ]);

        // Create test organization
        $organization = Organization::create([
            'name' => 'Dinas Testing',
            'slug' => 'dinas-testing',
            'type' => 'opd',
        ]);

        // Create an official for Bupati position
        $bupatiOfficial = Official::create([
            'full_name' => 'Testing Bupati',
            'position_id' => $bupatiPosition->id,
            'slug' => 'testing-bupati',
            'status' => 'active',
        ]);

        // Create an official for Kepala OPD position
        $opdOfficial = Official::create([
            'full_name' => 'Testing Kepala OPD',
            'position_id' => $opdPosition->id,
            'organization_id' => $organization->id,
            'slug' => 'testing-kepala-opd',
            'status' => 'active',
        ]);

        // Test that Bupati profile page displays the correct official
        $response = $this->get('/profil/bupati');
        $response->assertStatus(200);
        $response->assertSee('Testing Bupati');

        // Test that organization profile page displays the correct Kepala OPD official
        $response = $this->get('/profil/dinas-testing');
        $response->assertStatus(200);
        $response->assertSee('Testing Kepala OPD');
    }

    public function test_admin_officials_page_displays_all_crud_data()
    {
        // Create test positions and officials
        $bupatiPosition = Position::create([
            'name' => 'Bupati',
            'slug' => 'bupati',
            'is_single' => true,
        ]);

        $official = Official::create([
            'full_name' => 'Test Official',
            'position_id' => $bupatiPosition->id,
            'slug' => 'test-official',
            'status' => 'active',
        ]);

        // Authenticate as admin (assuming we have a user)
        // For testing purposes we need to create a user or bypass auth
        $response = $this->actingAs(\App\Models\User::factory()->create([
            'role' => 'superadmin'
        ]))->get('/admin/officials');

        $response->assertStatus(200);
    }

    public function test_official_profile_page_displays_all_data()
    {
        $position = Position::create(['name' => 'Bupati', 'slug' => 'bupati']);
        $official = Official::factory()->create([
            'position_id' => $position->id,
            'status' => 'active',
            'biography' => 'This is a test biography.',
        ]);
        $child = Child::factory()->create(['official_id' => $official->id]);
        $career = CareerHistory::factory()->create(['official_id' => $official->id]);
        $education = Education::factory()->create(['official_id' => $official->id]);
        $training = TrainingHistory::factory()->create(['official_id' => $official->id]);
        $organization = OrganizationalHistory::factory()->create(['official_id' => $official->id]);
        $award = Award::factory()->create(['official_id' => $official->id]);

        $response = $this->get('/profil/bupati');

        $response->assertStatus(200);
        $response->assertSee($official->full_name);
        $response->assertSee($official->biography);
        $response->assertSee($child->name);
        $response->assertSee($career->title);
        $response->assertSee($education->institution);
        $response->assertSee($training->name);
        $response->assertSee($organization->organization_name);
        $response->assertSee($award->title);
    }
}
