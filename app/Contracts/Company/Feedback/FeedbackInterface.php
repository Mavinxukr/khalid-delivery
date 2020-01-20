<?php


namespace App\Contracts\Company\Feedback;


use Illuminate\Http\Request;

interface FeedbackInterface
{
    public function index();

    public function show(int $id);

    public function store(Request $request);

    public function myFeedback(Request $request);
}
