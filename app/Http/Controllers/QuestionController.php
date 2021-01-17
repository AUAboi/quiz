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
        $question = Question::select('id', 'question')->get()->random(2);
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
            if (isset($option['is_correct'])) {
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

        $question->options()->createMany($data);
        return redirect()->back();
    }

    public function destory($question_id)
    {
        return Question::find($question_id)->delete();
    }
}
