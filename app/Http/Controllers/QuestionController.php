<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    public function index()
    {
        $question = Question::select('id', 'question')->inRandomOrder()->get();

        return $question;
    }

    public function show()
    {
        $question = Question::all();
        return $question;
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'question' => 'required',
            'option' => 'required',
        ]);


        $question = new Question();
        $question->question = $request->input('question');
        $question->save();

        $data = [];
        foreach ($request->option as $option) {
            if (($option['is_correct'])) {
                $data[] = [
                    'option' => $option['name'],
                    'is_correct' => 1,
                ];
            } else {

                $data[] = [
                    'option' => $option['name'],
                    'is_correct' => 0,
                ];
            }
        }

        if (!$question->options()->createMany($data)) {
            return "Error occured";
        }
        return "Added successfully";
    }

    public function destroy($question_id)
    {
        if (Question::find($question_id)->delete()) {
            return "Deleted successfully";
        }
        return "Error";
    }
}
