<?php

namespace App\Http\Controllers;

use App\Models\Questionare;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionnaireController extends Controller
{
    public function index()
    {
        return Inertia::render('Questionnaire/Questionnaire');
    }

   public function save(Request $request)
   {

 
       $request->validate([
           'name' => 'required|string',
           'questions' => 'required|array|max:10|min:2',
           'questions.*.question' => 'required|string',

           'questions.*.correctChoice' => 'required|integer',
           'questions.*.choices' => 'required|array|max:4',
       ]);
        $questionnaire = Questionare::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id
        ]);
       foreach($request->questions as $question) {
           $item =$questionnaire->questions()->create([
            'question' => $question['question'],
            
           ]);
           $correct_ans = $question['choices'][$question['correctChoice']];
           foreach($question['choices'] as $choice) {
            $item->choices()->create([
                'answer' => $choice,
                'is_correct' => $choice === $correct_ans
                // 'is_correct' => $choice === $question['correctChoice']
            ]);
           }
       }


       
   
       return redirect()->route('dashboard')->with('success', 'Questionnaire saved successfully!');
   }

   public function view($id)
   {
    $questionnaire = Questionare::with('questions.choices')->where('id', $id)->first();
    return Inertia::render('Questionnaire/Details', [
        'questionnaire' => $questionnaire
    ]);
   }

   public function destroy($id)
   {
    // dd('clicked');
       $questionnaire = Questionare::findOrFail($id);
       $questionnaire->delete();
       return redirect()->route('dashboard')->with('success', 'Questionnaire deleted successfully!');
   }


}
