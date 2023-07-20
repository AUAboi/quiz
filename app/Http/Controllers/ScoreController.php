<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'score' => 'required|min:0|max:' . Question::all()->count()
        ]);

        Score::create([
            'user_id' =>  auth()->id(),
            'score' => $request->score
        ]);

        return 'Successfully inserted';
    }
}
