<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reviews\GenerateRequest;
use Inertia\Inertia;
use OpenAI\Laravel\Facades\OpenAI;

class ReviewsController extends Controller
{
    public function index () {
        return Inertia::render('Employees/Reviews/Index');
    }

    public function result () {
        if(!session('openai_result')) {
            return redirect(route('employees.reviews.index'));
        }

        return Inertia::render('Employees/Reviews/Result', [
            'text' => session()->get('openai_result'),
        ]);
    }

    public function generate (GenerateRequest $request) {
        $topic = $request->topic;
        $tone = $request->tone;
        $additional_info = $request->additional_info;

        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user', 
                    'content' => "Generate an authentic positive google review about {$topic}. Use a {$tone} tone and make the review as original as possible. Here's additional info to help: {$additional_info}. Use a first person perspective.",
                ],
            ]
        ]);

        return redirect(route('employees.reviews.result'))->with('openai_result', $result['choices'][0]['message']['content']);
    }
}
