<?php

	require_once 'src/Cuisine.php';
	require_once 'src/Restaurant.php';

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    $server = 'mysql:host=localhost;dbname=food_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

	class CuisineTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Cuisine::deleteAll();
			Restaurant::deleteAll();
		}

		function test_getName()
		{
			//Arrange;
			$name = 'Japanese';
			$test_cuisine = new Cuisine($name);

			//Act;
			$result = $test_cuisine->getName();

			//Assert;
			$this->assertEquals($name, $result);
		}

		function test_getId()
		{
			//Arrange;
			$name = 'Japanese';
			$id = 1;
			$test_cuisine = new Cuisine($name, $id);

			//Act;
			$result = $test_cuisine->getId();

			//Assert;
			$this->assertEquals($id, $result);
		}

		function test_getAll()
		{
			//Arrange;
			$name = 'Japanese';
			$test_cuisine = new Cuisine($name);
			$test_cuisine->save();

			$name2 = 'Korean';
			$test_cuisine2 = new Cuisine($name2);
			$test_cuisine2->save();

			//Act;
			$result = Cuisine::getAll();

			//Assert;
			$this->assertEquals([$test_cuisine, $test_cuisine2], $result);
		}

		function test_save()
		{
			//Arrange;
			$name = 'Japanese';
			$id = null;
			$test_cuisine = new Cuisine($name, $id);
			$test_cuisine->save();

			//Act;
			$result = Cuisine::getAll();

			//Assert;
			$this->assertEquals($test_cuisine, $result[0]);

		}

		function test_find()
		{
			//Arrange
			$name = 'Korean';
			$id = 1;
			$test_cuisine = new Cuisine($name, $id);
			$test_cuisine->save();

			//Act
			$result = Cuisine::find($test_cuisine->getId());
			
			//Assert
			$this->assertEquals($test_cuisine, $result);
		}

		function test_getRestaurants()
		{

			//Arrange;
			$cuisine_name = 'Korean';
			$id = 1;
			$test_cuisine = new Cuisine($cuisine_name, $id);
			$test_cuisine->save();

			$restaurant_name = 'House of Jessica';
			$location = 'Epicodus';
			$cuisine_id = $test_cuisine->getId();
			$test_restaurant = new Restaurant($restaurant_name, $location, $cuisine_id);
			$test_restaurant->save();

			$restaurant_name2 = 'House of Epicodus';
			$location2 = 'Oak and 6th';
			$cuisine_id2 = null;
			$test_restaurant2 = new Restaurant($restaurant_name2, $location2, $cuisine_id2);
			$test_restaurant2->save();

			//Act;
			$result = $test_cuisine->getRestaurants();

			//Assert;
			$this->assertEquals([$test_restaurant], $result);

		}

		function test_UpdateCuisine()
		{
			//Arrange;
			$cuisine_name = "Korean";
			$id = null;
			$test_cuisine = new Cuisine($cuisine_name, $id);
			$test_cuisine->save();

			$updated_cuisine_name = "Greek";

			//Act;
			$test_cuisine->updateCuisine($updated_cuisine_name);

			//Assert;
			$this->assertEquals("Greek", $test_cuisine->getName());
		}

		function testDeleteCuisine()
		{
			//Arrange;
			$name = 'Korean';
			$id = null;
			$test_cuisine = new Cuisine($name, $id);
			$test_cuisine->save();

			$name2 = 'Japanese';
			$id2 = null;
			$test_cuisine2 = new Cuisine($name2, $id2);
			$test_cuisine2->save();
			//Act;
			$test_cuisine->delete();
			//Assert;
			$this->assertEquals([$test_cuisine2], Cuisine::getAll());
		}

		function testDeleteRestaurant()
		{
			//Arrange;
			$name = 'Korean';
			$test_cuisine = new Cuisine($name);
			$test_cuisine->save();

			$name2 = 'Restaurant';
			$cuisine_id = $test_cuisine->getId();
			$id2 = null;
			$location = '111 SE St.';
			$test_restaurant = new Restaurant($name2, $location, $cuisine_id, $id2);
			$test_restaurant->save();

			//Act;
			$test_cuisine->delete();

			//Assert;
			$this->assertEquals([], Restaurant::getAll());
		}

	}

?>
