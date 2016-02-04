<?php
namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\Lesson;
use Exception;
use Illuminate\Http\Request;
use Session;

class LessonController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session()->keep('lessonId');
        session()->keep('maxQuestions');
        session()->keep('questionIndex');
    }

    public function index()
    {
        return view('lessons.index', [
            'lessons' => Lesson::where('user_id', $this->user->id)->get(),
            'categories' => Category::all(),
            'user' => $this->user,
            'title' => 'Lessons',
        ]);
    }

    public function store(Request $request)
    {
        try {
            session()->flash('questionIndex', 0);
            session()->flash('maxQuestions', 0);
            $lesson = new Lesson;
            $lesson->setLesson($this->user->id, $request->category_id);
            if ($lesson->generateLessonWords($this->user->id)) {
                session()->flash('lessonId', $lesson->id);
                return redirect('exam');
            }
        } catch (Exception $e) {
            session()->flash('flash_error', 'Lesson generation failed. Please try again.');
            return redirect()->back();
        }
        return redirect('lessons');
    }
}
