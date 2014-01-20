<?php

require __DIR__ . '/../vendor/autoload.php';

use Silex\WebTestCase;

class ImageTest extends WebTestCase
{  
    
    public function createApplication()
    {
        $app = require __DIR__.'/../app.php';
        $app['img_directory'] = __DIR__.'/img';
        $app['session.test'] = true;

        return $app;
    }
    
    public function testUploadNamedImage(){
        
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('form'));
        
        $button = $crawler->selectButton('submit');
        $form = $button->form();

        $form['file']->upload(__DIR__ . '/img/test_img.jpg');
        $name = "test_img_".rand(0,1000);
        $form['name'] = $name;
        $client->submit($form);
        
        $this->assertFileExists(__DIR__ . '/img/'.$name);
        
        unlink(__DIR__ . '/img/'.$name);

    }
    
    public function testImageNamedBlueDoesNotExists(){
        $client = $this->createClient();
        $crawler = $client->request('GET', '/blue');
        
        $this->assertEquals(404,$client->getResponse()->getStatusCode());

    }
    
    public function testImageNamedBlueDoExist(){
        $client = $this->createClient();
        $crawler = $client->request('GET', '/test_img.jpg');
        
        $this->assertTrue($client->getResponse()->isOk());
        
        $image = $crawler->filter('img');
        
        $this->assertEquals("img/test_img.jpg", $image->attr('src'));

        
    }
    


}

?>
