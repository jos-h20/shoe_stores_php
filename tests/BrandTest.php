
<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Brand.php";
    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
        }
        function testGetBrandName()
        {
            // Arrange
            $brand_name = "Saloman";

            $test_brand = new Brand($brand_name);
            // Act
            $result = $test_brand->getBrandName();
            // Assert
            $this->assertEquals($brand_name, $result);
        }
        function testGetId()
        {
            // Arrange
            $brand_name = "Saloman";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            // Act
            $result = $test_brand->getId();
            // Assert
            $this->assertEquals($id, $result);
        }
        function testSave()
        {
            //Arrange
            $brand_name = "Saloman";
            $test_brand = new Brand($brand_name);
            $test_brand->save();
            //Act
            $result = Brand::getAll();
            //Assert
            $this->assertEquals($test_brand, $result[0]);
        }
        function testGetAll()
        {
            //Arrange
            $brand_name = "Saloman";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();
            $brand_name2 = "Crocs";
            $id2 = 2;
            $test_brand2 = new Brand($brand_name2, $id2);
            $test_brand2->save();
            //Act
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }
        function testDeleteAll()
        {
            //Arrange
            $brand_name = "Saloman";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();
            $brand_name2 = "Crocs";
            $id2 = 2;
            $test_brand2 = new Brand($brand_name2, $id2);
            $test_brand2->save();
            //Act
            Brand::deleteAll();
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([], $result);
        }
        function testFind()
       {
         //Arrange;
         $brand_name = "Saloman";
         $id = 1;
         $test_brand = new Brand($brand_name, $id);
         $test_brand->save();
         $brand_name2 = "Crocs";
         $id2 = 2;
         $test_brand2 = new Brand($brand_name2, $id2);
         $test_brand2->save();
         //Act;
         $result = Brand::find($test_brand->getId());
         //Assert
         $this->assertEquals($test_brand, $result);
       }
      //  function testGetStores()
      //  {
      //      // Arrange
      //      $brand_name = "Jim";
      //      $enrollment = "2016-03-01";
      //      $id = 1;
      //      $test_store = new Store($brand_name, $enrollment, $id);
      //      $test_store->save();
      //      $brand_name2 = "Joe";
      //      $enrollment2 = "2016-03-02";
      //      $id2 = 2;
      //      $test_store2 = new Store($brand_name2, $enrollment2, $id2);
      //      $test_store2->save();
      //      $brand_name = "Saloman";
      //      $id3 = 3;
      //      $test_brand = new Brand($brand_name, $id3);
      //      $test_brand->save();
      //      // Act
      //      $test_brand->addStore($test_store);
      //      $test_brand->addStore($test_store2);
      //      // Assert
      //      $this->assertEquals($test_brand->getStores(), [$test_store, $test_store2]);
      //  }
      //  function testAddStore()
      //  {
      //      // Arrange
      //      $brand_name = "Jim";
      //      $enrollment = "2016-03-01";
      //      $id = 1;
      //      $test_store = new Store($brand_name, $enrollment, $id);
      //      $test_store->save();
      //      $brand_name = "Saloman";
      //      $id2 = 2;
      //      $test_brand = new Brand($brand_name, $id2);
      //      $test_brand->save();
      //      // Act
      //      $test_brand->addStore($test_store);
      //      // Assert
      //      $this->assertEquals($test_brand->getStores(), [$test_store]);
      //  }
      //   function testDelete() {
      //       //Arrange;
      //       $brand_name = "Saloman";
      //       $id = 1;
      //       $test_brand = new Brand($brand_name, $id);
      //       $test_brand->save();
      //       $brand_name2 = "Crocs";
      //       $id2 = 2;
      //       $test_brand2 = new Brand($brand_name2, $id2);
      //       $test_brand2->save();
      //       //Act;
      //       $test_brand2->delete();
      //       //Assert;
      //       $this->assertEquals([$test_brand], Brand::getAll());
      //   }
      //   function testUpdate()
      //   {
      //       // Arrange
      //       $brand_name = "Saloman";
      //       $id = 1;
      //       $test_brand = new Brand($brand_name, $id);
      //       $test_brand->save();
      //       $new_brand_name = "Crocs";
      //       // Act
      //       $test_brand->update($new_brand_name);
      //       $result = [$test_brand->getBrandName()];
      //       // Assert
      //       $this->assertEquals(["Crocs"], $result);
      //   }
    }
?>
