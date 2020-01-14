<?php


namespace App\Interfaces\Client\Feedback;


interface FeedbackInterface
{
    public function index();

    public function show(int $id);

    public function store($data);

    public function myFeedback($data);
}
