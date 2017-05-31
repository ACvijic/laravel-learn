<?php
namespace Tests\Helpers;
use Tests\TestCase as TestCase;
use Faker\Factory as Faker;
use \App\Model\Lesson;


abstract class ApiTester extends TestCase {
    
    protected $fake;
    
    
    
    function __construct() {
        $this->fake = Faker::create();
    }

    
    
    
    public function getJson($uri, $method = 'GET') {
        return json_decode($this->call($method, $uri)->getContent());
    }
    
    public function assertObjectHasAttributes() {
        $args = func_get_args();
        
        $object = array_shift($args);
        
        foreach ($args as $attrribute){
            $this->assertObjectHasAttribute($attrribute, $object);
        }
    }
    
    
    
    
}

