<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
        }
        function testGetStoreName()
        {
            // Arrange
            $store_name = "Super Shoes";
            $test_store = new Store($store_name);
            // Act
            $result = $test_store->getStoreName();
            // Assert
            $this->assertEquals($store_name, $result);
        }
        function testGetId()
        {
            // Arrange
            $store_name = "Super Shoes";
            $id = 1;
            $test_store = new Store($store_name, $id);
            // Act
            $result = $test_store->getId();
            // Assert
            $this->assertEquals($id, $result);
        }
        function testSave()
        {
            //Arrange
            $store_name = "Super Shoes";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();
            //Act
            $result = Store::getAll();
            //Assert
            $this->assertEquals($test_store, $result[0]);
        }
        function testGetAll()
        {
            //Arrange
            $store_name = "Super Shoes";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();
            $store_name2 = "Sweet Sole";
            $id2 = 2;
            $test_store2 = new Store($store_name2, $id2);
            $test_store2->save();
            //Act
            $result = Store::getAll();
            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }
        function testDeleteAll()
        {
            //Arrange
            $store_name = "Super Shoes";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();
            $store_name2 = "Sweet Sole";
            $id2 = 2;
            $test_store2 = new Store($store_name2, $id2);
            $test_store2->save();
            //Act
            Store::deleteAll();
            $result = Store::getAll();
            //Assert
            $this->assertEquals([], $result);
        }
        function testFind()
       {
         //Arrange;
         $store_name = "Super Shoes";
         $id = 1;
         $test_store = new Store($store_name, $id);
         $test_store->save();
         $store_name2 = "Sweet Sole";
         $id2 = 2;
         $test_store2 = new Store($store_name2, $id2);
         $test_store2->save();
         //Act;
         $result = Store::find($test_store->getId());
         //Assert
         $this->assertEquals($test_store, $result);
       }
    //    function testGetBrands()
    //    {
    //        // Arrange
    //        $brand_name = "Saloman";
    //        $id = 1;
    //        $test_brand = new Brand($brand_name, $id);
    //        $test_brand->save();
    //        $brand_name2 = "Crocs";
    //        $id2 = 2;
    //        $test_brand2 = new Brand($brand_name2, $id2);
    //        $test_brand2->save();
       //
    //        $store_name = "Super Shoes";
    //        $id3 = 3;
    //        $test_store = new Store($store_name, $id3);
    //        $test_store->save();
    //        // Act
    //        $test_store->addBrand($test_brand);
    //        $test_store->addBrand($test_brand2);
    //        // Assert
    //        $this->assertEquals($test_store->getBrands(), [$test_brand, $test_brand2]);
    //    }
    //    function testAddBrand()
    //    {
    //        // Arrange
    //        $brand_name = "Saloman";
    //        $id = 1;
    //        $test_brand = new Brand($brand_name, $id);
    //        $test_brand->save();
    //        $store_name = "Super Shoes";
    //        $id3 = 3;
    //        $test_store = new Store($store_name, $id3);
    //        $test_store->save();
    //        // Act
    //        $test_store->addBrand($test_brand);
    //        // Assert
    //        $this->assertEquals($test_store->getBrands(), [$test_brand]);
    //    }
    //     function testDelete() {
    //         //Arrange;
    //         $store_name = "Super Shoes";
    //         $id = 1;
    //         $test_store = new Store($store_name, $id);
    //         $test_store->save();
    //         $store_name2 = "Sweet Sole";
    //         $id2 = 2;
    //         $test_store2 = new Store($store_name2, $id2);
    //         $test_store2->save();
    //         //Act;
    //         $test_store2->delete();
    //         //Assert;
    //         $this->assertEquals([$test_store], Store::getAll());
    //     }
    //     function testUpdate()
    //     {
    //         // Arrange
    //         $store_name = "Super Shoes";
    //         $id = 1;
    //         $test_store = new Store($store_name, $id);
    //         $test_store->save();
    //         $new_store_name = "Super Sweet Shoes";
    //         // Act
    //         $test_store->update($new_store_name);
    //         $result = [$test_store->getStoreName()];
    //         // Assert
    //         $this->assertEquals(["Super Sweet Shoes"], $result);
    //     }
    }
?>
