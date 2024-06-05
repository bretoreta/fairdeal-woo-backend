<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Requests\Admin\Reviews\GenerateRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewsController extends Controller
{
    public function index () {
        return Inertia::render('Admin/Reviews/Index');
    }

    public function result () {
        if(!session('openai_result')) {
            return redirect(route('admin.reviews.index'));
        }

        return Inertia::render('Admin/Reviews/Result', [
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

        return redirect(route('admin.reviews.result'))->with('openai_result', $result['choices'][0]['message']['content']);
    }
}
