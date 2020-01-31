<?php

namespace App\Http\Controllers\ApiClient\Feedback;

use App\Http\Controllers\Controller;
use App\Contracts\Client\Feedback\FeedbackInterface;
use App\Http\Requests\FeedbackRequest;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    private $feedback;

    public function __construct(FeedbackInterface $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * @api {get} client/feedback  Get feedback template  #Screen №9
     * @apiName  Get all feedback
     * @apiVersion 1.1.1
     * @apiGroup Client Feedback
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/feedback
     */

    public function index()
    {
        return $this->feedback->index();
    }

    /**
     * @api {post} client/feedback/create  Store feedback  #Screen №9
     * @apiName  Store feedback
     * @apiVersion 1.1.1
     * @apiGroup Client Feedback
     * @apiParam {String} comment Comment for finished order
     * @apiParam {Number} order_id Orders' id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/feedback/create
     */

    public function store(FeedbackRequest $request)
    {
        return $this->feedback->store($request);
    }

    /**
     * @api {get} client/my-feedback  My feedback  #Screen №32
     * @apiName   My feedback
     * @apiVersion 1.1.1
     * @apiGroup Client Feedback
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/my-feedback
     */

    public function getMyFeedback(Request $request)
    {
        return $this->feedback->myFeedback($request);
    }

    /**
     * @api {get} client/get-company-for-feedback  Get company for feedback  #Screen №32
     * @apiName   Get company for feedback
     * @apiVersion 1.1.1
     * @apiGroup Client Feedback
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/get-company-for-feedback
     */

    public function getCompanyForFeedback(Request $request)
    {
        return $this->feedback->getCompanyForFeedback($request);
    }

    /**
     * @api {post} client/store-company-feedback  Store company  feedback  #Screen №32
     * @apiName   Store company  feedback
     * @apiVersion 1.1.1
     * @apiGroup Client Feedback
     * @apiParam {String} comment Comment
     * @apiParam {Double} star Star ( 1 ,2.5,4.5....)
     * @apiParam {Number} company_id Company Id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/store-company-feedback
     */

    public function storeCompanyFeedback(Request $request)
    {
        return $this->feedback->storeCompanyFeedback($request);
    }


}
