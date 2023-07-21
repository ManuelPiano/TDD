<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Property;

class PropertiesTest extends TestCase
{
    use RefreshDatabase;
    private $routePrefix = 'api.properties.';


    /** @test */
    public function can_get_all_properties()
	{
		// Create Property so that the response returns it.
		$property = Property::factory()->create();
		
		$response = $this->getJson(route('api.properties.index'));
		// We will only assert that the response returns a 200 
		// status for now.
		$response->assertOk(); 
		
		// Add the assertion that will prove that we receive what we need 
		// from the response.
		$response->assertJson([
			'data' => [
				[
					'id' => $property->id,
					'type' => $property->type,  
					'price' => $property->price,  
					'description' => $property->description,
				]
			]
		]);
	}
    /** @test */
    /** @test */
	
    public function can_store_a_property()
    {
        // Build a non-persisted Property factory model.
        $newProperty = Property::factory()->make();

        $response = $this->postJson(
            route('api.properties.store'),
            $newProperty->toArray()
        );
        // We assert that we get back a status 201:
        // Resource Created for now.
        $response->assertCreated();
        // Assert that at least one column gets returned from the response
        // in the format we need .
        $response->assertJson([
             'data' => ['type' => $newProperty->type]
         ]);
        // Assert the table properties contains the factory we made.
        $this->assertDatabaseHas(
             'properties', 
             $newProperty->toArray()
         );
    }

    /** @test */
	public function can_update_a_property() 
	{
        $existingProperty = Property::factory()->create();  
    $updatedPropertyData = Property::factory()->make()->toArray();
      
    $response = $this->putJson(  
        route($this->routePrefix . 'update', $existingProperty),  
        $updatedPropertyData
    );  
    $response->assertJson([  
        'data' => [  
            // We keep the ID from the existing Property.
            'id' => $existingProperty->id,  
            // Verify that the fields have been updated.
            'type' => $updatedPropertyData['type'],
            'price' => $updatedPropertyData['price'],
            'description' => $updatedPropertyData['description'],
        ]
    ]);  
      
    // Now, we need to refresh the `$existingProperty` instance from the database to get the updated values.
    $existingProperty->refresh();

    $this->assertDatabaseHas(  
        'properties',  
        $existingProperty->toArray()  
    );
	}


    /** @test */
	public function can_delete_a_property() 
	{
		$existingProperty = Property::factory()->create();

		$this->deleteJson(
			route($this->routePrefix . 'destroy', $existingProperty)
		)->assertNoContent(); 
		// You can also use assertStatus(204) instead of assertNoContent() 
	    // in case you're using a Laravel version that does not have this assertion. 
        // (I believe it is available from v7.x onwards)

		// Finally we just assert the `properties` table does not contain the model that we just deleted.
		$this->assertDatabaseMissing(  
			'properties',  
			$existingProperty->toArray()  
		);
	}
}
