<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \App\Model\Lesson;
use Tests\Helpers\ApiTester as ApiTester;

class LessonsTest extends ApiTester {
    
    use Factory;
    
    /** @test */
    public function it_fetches_lessons() {
        
        // arrange
        $this->times(5)->make(Lesson::class);
        
        //act
        $this->getJson('api/v1/lessons');
        
        //assert
        $this->assertTrue(true);
    }
    /** @test */
    public function it_fetches_a_lesson() {
        
        // arrange
        $this->make(Lesson::class);
        
        //act
        $lesson = $this->getJson('api/v1/lessons/1')->data;
        //assert
        $this->assertTrue(true);
        $this->assertObjectHasAttributes($lesson, 'body', 'title', 'status');
    }
    /** @test */
    function it_404s_if_a_lesson_is_not_found() {
        $this->getJson('api/v1/lessons/x');
        
        $response = $this->call('GET', 'api/v1/lessons/x');
        
        $this->assertEquals(404, $response->status());
        
    }
    
    protected function getStub() {
        return [
            'title' => $this->fake->sentence(2),
            'body' => $this->fake->paragraph(3),
            'some_bool' => $this->fake->boolean,
        ];
    }
    
}
