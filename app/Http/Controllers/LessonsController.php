<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Lesson;
use Illuminate\Support\Facades\Response;
use App\Cubes\Transformers\LessonTransformer as LessonTransformer;

class LessonsController extends ApiController {

    /**
     *
     * @var Cubes\Transformers\LessonTransformer
     */
    protected $lessonTransformer;

    public function __construct(LessonTransformer $lessonTransformer) {

        $this->lessonTransformer = $lessonTransformer;

        // TO DO api authentication
        //$this->beforeFilter();
        //$this->middleware('auth')->only('store'); // middleware doesnt work because of session life between requests
    }

    public function index() {

        // 1. All is bad
        // 2. No way to attach metta data
        // 3. Linking the db structure to the API output
        // 4. No way to signal headers/response codes
        //return Lesson::all(); // really bad practice

        $lessons = Lesson::all();

        return $this->respond([
                    'data' => $this->lessonTransformer->transformCollection($lessons->all()),
        ]);
    }

    public function show($id) {

        $lesson = Lesson::find($id);

        if (!$lesson) {
            return $this->respondNotFound('Lesson does not exist.');

//            return $this->respondWithError(404, 'Lesson does not exist');
//            return Response::json([
//                'error' => [
//                    'message' => 'Lesson does not exist'
//                ],
//            ], 404 );
        }

        return $this->respond([
            'data' => $this->lessonTransformer->transform($lesson),
                //'data' => $this->transform($lesson->toArray()),
        ]);
    }

    public function store(Request $request) {
        if (!$request->input('title') || !$request->input('body')) {
            // return some kind of response
            // 400, 403, *422*
            // provide a message

            return $this->setStatusCode(422)
                            ->respondWithError('Parameters failed validation for lesson.');
        }

        $this->validate(request(), [
            'title' => 'required|max:191',
            'body' => 'required|max:191'
        ]);

        $lesson = new Lesson();
        $lesson->title = request('title');
        $lesson->body = request('body');
        $lesson->save();

        return $this->setStatusCode(201)->respond([
                    'message' => 'Lesson successfully created',
        ]);
    }

}
