<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesQuestion;
use App\Models\MasterUser;
use App\Models\Notice;
use App\Models\SalesAdvertisement;
use App\Models\SalesquestionImage;

class AskQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($adv_id)
    {
        //
        $question = SalesQuestion::where('adv_id', $adv_id)->where("parent", 0)->get();
        if ($question) {
            foreach ($question as $key => $value) {
                $questionImages = SalesQuestionImage::where('qid', $value->question_id)->get();
                $replies = SalesQuestion::where('parent', $value->question_id)->get();
                foreach ($replies as $key => $value1) {
                    $user = MasterUser::where('user_id', $value1->user_id)->first();
                    $value1['userName'] = $user->first_name . " " . $user->last_name;
                }
                $user = MasterUser::where('user_id', $value->user_id)->first();
                foreach ($questionImages as $key => $value2) {
                    $filePath = public_path('uploads/salesquestion/' . $value2->img_file);
                    if (file_exists($filePath) && $value2->img_file != "") {
                        $value2['img_file'] = asset('uploads/salesquestion/' . $value2->img_file);
                    }
                }
                $value['images'] = $questionImages;
                $value['userName'] = $user->first_name . " " . $user->last_name;
                $value['replies'] = $replies;
            }
        }
        return response()->json(['questions' => $question], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function addSalesQuestion(Request $request)
    {
        $questionPostID = $request->adv_id;
        $question = new SalesQuestion();
        $question->user_id = $request->user_id;
        $question->adv_id = $request->adv_id;
        $question->question = $request->question;
        $question->parent = $request->parent ? $request->parent : 0;
        $question->status = 1;
        if ($question->save() && $request->file('images') && count($request->file('images')) > 0) {
            foreach ($request->file('images') as $allimg) {
                $salesquestionImage = new SalesquestionImage();
                if ($allimg->getClientOriginalName() != '') {
                    $filename = time() . $allimg->getClientOriginalName();
                    $allimg->move(public_path('uploads/salesquestion/'), $filename);
                    $uploadedFile = public_path('uploads/salesquestion/') . $filename;
                    $salesquestionImage->img_file = $filename;
                } else {
                    $salesquestionImage->img_file = '';
                }
                $salesquestionImage->postid = $questionPostID;
                $salesquestionImage->qid = $question->question_id;
                $salesquestionImage->save();
            }

            // Create a notice record for the registered user
            $notice = new Notice();
            $sale = SalesAdvertisement::find($request->adv_id);
            $notice->notice_type = 'register';
            $notice->postid = $question->user_id;
            $notice->user_id = $sale->user_id;
            $notice->status = 0;
            $notice->user_status = 0;
            $notice->notice_name = 'Register';
            $notice->save();
        }

        return response()->json(['message' => 'Question added succesfully'], 200);
    }
    public function askQuestion(Request $request)
    {
        // \DB::enableQueryLog();
        $userid = $request->user_id;
        $questions = SalesQuestion::select('PostAd.*', 'sales_questions.*')
            ->leftJoin('sales_advertisements AS PostAd', 'PostAd.adv_id', '=', 'sales_questions.adv_id')
            ->where('PostAd.user_id', $userid)
            ->where('sales_questions.parent', 0)
            ->orderByDesc('sales_questions.question_id')
            ->get();
        //dd(\DB::getQueryLog());
        $allques_data = [];
        if (!empty($questions)) {
            foreach ($questions as $key => $row) {
                $user = MasterUser::where('user_id', $row->user_id)->first();
                $allques_data[$key]['opinion'] = $row->adv_name;
                $allques_data[$key]['slug'] = $row->slug;
                $allques_data[$key]['questions'] = $row->question;
                $allques_data[$key]['user_id'] = $row->user_id;
                $allques_data[$key]['posted_by'] = !empty($user) ? $user->first_name . ' ' . $user->last_name : "";
                $allques_data[$key]['question_id'] = $row->question_id;
                $allques_data[$key]['created'] = $row->created;
            }
        }
        return response()->json(['data' => $allques_data]);
    }

    public function sentQuestions(Request $request, $questionId)
    {
        // \DB::enableQueryLog();
        $sentquestions = SalesQuestion::where('parent', $questionId)
            ->orderBy('question_id', 'desc')
            ->get();
        //  dd(\DB::getQueryLog());
        $allques_data = [];
        if (!empty($sentquestions)) {
            foreach ($sentquestions as $key => $row) {
                $user = MasterUser::where('user_id', $row->user_id)->first();
                $sale_adv = SalesAdvertisement::where('adv_id', $row->adv_id)->first();
                $allques_data[$key]['slug'] = $sale_adv->slug;
                $allques_data[$key]['opinion'] = $sale_adv->adv_name;
                $questionCount = SalesQuestion::where('parent', $questionId)->count();
                $allques_data[$key]['no_of_items'] = $questionCount;
                // $allques_data[$key]['no_of_items'] = 1;
                $allques_data[$key]['questions'] = $row->question;
                $allques_data[$key]['user_id'] = $row->user_id;
                $allques_data[$key]['sent_by'] = !empty($user) ? $user->first_name . ' ' . $user->last_name : "";
                $allques_data[$key]['question_id'] = $row->question_id;
                $allques_data[$key]['created'] = $row->created;
            }
        }
        return response()->json(['data' => $allques_data]);
    }

    public function viewAskReply(Request $request, $questionId)
    {

        // \DB::enableQueryLog();
        $viewAskAsReply = SalesQuestion::where('parent', $questionId)
            ->orderBy('question_id', 'desc')
            ->get();
        //dd(\DB::getQueryLog());
        $view_ask_as_reply_data = [];
        if (!empty($viewAskAsReply)) {
            foreach ($viewAskAsReply as $key => $row) {
                $user = MasterUser::where('user_id', $row->user_id)->first();
                $sale_adv = SalesAdvertisement::where('adv_id', $row->adv_id)->first();
                $view_ask_as_reply_data[$key]['slug'] = $sale_adv->slug;
                $view_ask_as_reply_data[$key]['opinion'] = $sale_adv->adv_name;
                // $view_ask_as_reply_data[$key]['no_of_items'] = 1;
                $questionCount = SalesQuestion::where('parent', $questionId)->count();
                $view_ask_as_reply_data[$key]['no_of_items'] = $questionCount;
                $view_ask_as_reply_data[$key]['reply'] = $row->question;
                $view_ask_as_reply_data[$key]['user_id'] = $row->user_id;
                $view_ask_as_reply_data[$key]['replied_by'] = !empty($user) ? $user->first_name . ' ' . $user->last_name : "";
                $view_ask_as_reply_data[$key]['question_id'] = $row->question_id;
                $view_ask_as_reply_data[$key]['created'] = $row->created;
            }
        }
        return response()->json(['data' => $view_ask_as_reply_data]);
    }

    public function answerTheQuestion(Request $request)
    {
        $questionInsertID = $request->question_id;
        $questionPostID = $request->adv_id;
        if (count($request->file('img_files')) > 0) {
            foreach ($request->file('img_files') as $allimg) {
                $salesquestionImage = new SalesquestionImage();
                if ($allimg->getClientOriginalName() != '') {
                    $filename = time() . $allimg->getClientOriginalName();
                    $filename = $this->cleanFilePath($filename);
                    // Assuming you have a function to clean file paths
                    $allimg->move(public_path('files/salesquestion/'), $filename);
                    $uploadedFile = public_path('files/salesquestion/') . $filename;
                    $salesquestionImage->img_file = $filename;
                } else {
                    $salesquestionImage->img_file = '';
                }
                $salesquestionImage->qid = $questionInsertID;
                $salesquestionImage->postid = $questionPostID;
                $salesquestionImage->save();
            }
        }

        return response()->json(['message' => 'Succesfully'], 200);
    }
}
