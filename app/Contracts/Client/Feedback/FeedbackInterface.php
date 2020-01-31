<?php


namespace App\Contracts\Client\Feedback;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface FeedbackInterface extends FormatInterface
{
    public function index();

    public function show(int $id);

    public function store($data);

    public function myFeedback($data);

    public function getCompanyForFeedback(Request $request);

    public function storeCompanyFeedback(Request $request);
}
