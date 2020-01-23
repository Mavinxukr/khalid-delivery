<?php


namespace App\Contracts\Company\Feedback;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface FeedbackInterface extends FormatInterface
{
    public function index();

    public function show(int $id);

    public function store(Request $request);

    public function myFeedback(Request $request);
}
