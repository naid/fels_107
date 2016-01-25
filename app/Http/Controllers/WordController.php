<?php
namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use App\Word;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WordController extends Controller
{
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

    public function index()
    {
        $words = Word::with('category')->paginate(20);
        return view('words.index', [
            'words' => $words,
            'user' => $this->user,
            'title' => 'Words',
        ]);
    }

    public function create()
    {
        $categories = Category::lists('name', 'id');
        return view('words.create', [
            'categories' => $categories,
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
            \Session::flash('flash_success', 'Word creation successful!');
        } catch (Exception $e) {
            \Session::flash('flash_error', 'Word creation failed.');
        }
        return redirect('/words');
    }

    public function edit($id)
    {
        try {
            $word = Word::findOrFail($id);
            $categories = Category::lists('name', 'id');
            $optionArray = explode(";", $word->options);
            return view('words.edit', [
                'word' => $word,
                'category' => $categories,
                'title' => 'Edit word',
                'user' => $this->user,
                'options' => $optionArray,
            ]);
        } catch (ModelNotFoundException $e) {
            \Session::flash('flash_error', 'Edit failed. The word cannot be found.');
        }
        return redirect('/words');
    }

    public function update(Request $request, $id)
    {
        try {
            $this->checkWord($request);
            $word = Word::findOrFail($id);
            $word->assign($request);
            \Session::flash('flash_success', 'Update successful!');
        } catch (ModelNotFoundException $e) {
            \Session::flash('flash_error', 'Update failed. The word cannot be found.');
        }
        return redirect('/words');
    }

    public function destroy($id)
    {
        try {
            $word = Word::findOrFail($id);
            $word->delete();
            \Session::flash('flash_success', 'Delete successful!');
        } catch (ModelNotFoundException $e) {
            \Session::flash('flash_error', 'Delete failed. The word cannot be found.');
        }
        return redirect('/words');
    }
}
