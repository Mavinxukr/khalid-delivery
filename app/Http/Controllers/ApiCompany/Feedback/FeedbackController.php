<?php

namespace App\Http\Controllers\ApiCompany\Feedback;

use App\Http\Controllers\Controller;
use App\Contracts\Company\Feedback\FeedbackInterface;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    private $feedback;

    public function __construct(FeedbackInterface $feedback)
    {
        $this->feedback = $feedback;
    }

    public function index()
    {
        return $this->feedback->index();
    }

    public function store(Request $request)
    {
        return $this->feedback->store($request);
    }

    /**
     * @api {get} company/company-profile/my-feedback  Get company feedback  #Screen 8
     * @apiName  Get company feedback
     * @apiVersion 1.1.1
     * @apiGroup Company  Feedback
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/company-profile/my-feedback
     */


    public function getMyFeedback(Request $request)
    {
        return $this->feedback->myFeedback($request);
    }
}
