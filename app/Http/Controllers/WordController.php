<?php
namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\User;
use App\Word;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Session;

class WordController extends Controller
{
    protected $categories;

    public function __construct()
    {
        parent::__construct();
        $this->categories = Category::lists('name', 'id');
    }

    protected function checkWord($request)
    {
        return $this->validate($request, [
            'word' => 'required',
            'meaning' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'sound' => 'mimes:wav,mp3,mp4,mpeg,mpg',
        ]);
    }

    public function index(Request $request)
    {
        if (!empty($request->input('category'))) {
            $learnedWords = new Lesson;
            $categoryId = $request->input('category');
            switch ($categoryId) {
                case Word::STATUS_ALL:
                    $currentCategoryWordIds = Word::with('category')
                        ->lists('id');
                    break;
                default:
                    $currentCategoryWordIds = Word::with('category')
                        ->where('category_id', $categoryId)
                        ->lists('id');
                    break;
            }
            $wordQueryBuilder = Word::with('category')
                ->whereIn('id', $currentCategoryWordIds);

            switch ($request->input('status')) {
                case Word::STATUS_LEARNED:
                    $wordQueryBuilder->whereIn('id', $learnedWords->getLearnedWords($this->user->id));
                    break;
                case Word::STATUS_UNLEARNED:
                    $wordQueryBuilder->whereNotIn('id', $learnedWords->getLearnedWords($this->user->id));
                    break;
                default:
                    break;
            }

            $words = $wordQueryBuilder->paginate(Word::NUMBER_WORDS);

            return view('words.index', [
                'user' => $this->user,
                'categories' => $this->categories,
                'words' => $words,
                'title' => Word::TITLE,
                'status' => $request->input('status'),
                'categoryId' => $categoryId,
            ]);
        }

        $words = Word::with('category')
            ->paginate(Word::NUMBER_WORDS);
        return view('words.index', [
            'user' => $this->user,
            'categories' => $this->categories,
            'words' => $words,
            'title' => Word::TITLE,
            'status' => Word::STATUS_ALL,
            'categoryId' => Word::STATUS_ALL,
        ]);
    }

    public function create()
    {
        return view('words.create', [
            'categories' => $this->categories,
            'user' => $this->user,
            'title' => 'Words',
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->checkWord($request);
            $word = new Word;
            $word->assign($request);
            session()->flash('flash_success', 'Word creation successful!');
        } catch (Exception $e) {
            session()->flash('flash_error', 'Word creation failed.');
        }
        return redirect('/words');
    }

    public function edit($id)
    {
        try {
            $word = Word::findOrFail($id);
            $optionArray = explode(";", $word->options);
            return view('words.edit', [
                'word' => $word,
                'category' => $this->categories,
                'title' => 'Edit word',
                'user' => $this->user,
                'options' => $optionArray,
            ]);
        } catch (ModelNotFoundException $e) {
            session()->flash('flash_error', 'Edit failed. The word cannot be found.');
        }
        return redirect('/words');
    }

    public function update(Request $request, $id)
    {
        try {
            $this->checkWord($request);
            $word = Word::findOrFail($id);
            $word->assign($request);
            session()->flash('flash_success', 'Update successful!');
        } catch (ModelNotFoundException $e) {
            session()->flash('flash_error', 'Update failed. The word cannot be found.');
        }
        return redirect('/words');
    }

    public function destroy($id)
    {
        try {
            $word = Word::findOrFail($id);
            $word->delete();
            session()->flash('flash_success', 'Delete successful!');
        } catch (ModelNotFoundException $e) {
            session()->flash('flash_error', 'Delete failed. The word cannot be found.');
        }
        return redirect('/words');
    }
}
