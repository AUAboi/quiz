<?php

namespace App\Imports;

use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\PersistRelations;

class QuestionsImport implements PersistRelations, WithHeadingRow, OnEachRow
{


    public function onRow(Row $row)
    {

        $question = Question::create([
            'question'     => $row['question'],
        ]);

        $question->options()->create([
            'question_id' => $question->id,
            'option' => $row['optiona'],
            'is_correct' => false,
        ]);
        $question->options()->create([
            'question_id' => $question->id,
            'option' => $row['optionb'],
            'is_correct' => false,
        ]);
        $question->options()->create([
            'question_id' => $question->id,
            'option' => $row['optioncorrect'],
            'is_correct' => true,
        ]);
    }
}
