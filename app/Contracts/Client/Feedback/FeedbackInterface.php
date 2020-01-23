<?php


namespace App\Contracts\Client\Feedback;


use App\Contracts\FormatInterface;

interface FeedbackInterface extends FormatInterface
{
    public function index();

    public function show(int $id);

    public function store($data);

    public function myFeedback($data);
}
