<?php

namespace App\Http\Controllers;

use App\Models\QuestionaireAnswers;
use App\Models\QuestionairePrototype;
use App\Models\QuestionairePrototypeDesc;
use App\Models\CheckInModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionaireController extends Controller
{

    public function showForm(Request $request):\Inertia\Response
    {
        $question = QuestionairePrototypeDesc::with('questionPrototype')->get()->toJson();
        return Inertia::render('COVID/Evaluation',['form'=>$question]);
    }

    public function makeQuestionaire():\Illuminate\Http\JsonResponse
    {
        $dataSet = array(
            1=>array(
                "question_type" => 1,
                "section_id" => 1,
                "question_title" => "มีไข้ / อุณหภูมิร่างกายมากกว่า 37.5 องศา",
                "question_details" => array(
                    "choice_1_1"=>array(
                        "title"=>"ท่านมีไข้ / อุณหภูมิร่างกายมากกว่า 37.5 องศาก่อนที่จะเข้าสถานที่ หรือไม่",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                )
            ),
            2=>array(
                "question_type" => 1,
                "section_id" => 2,
                "question_title" => "มีอาการของระบบทางเดินหายใจอย่างใดอย่างนึง",
                "question_details" => array(
                    "choice_1_2"=>array(
                        "title"=>"ไอ",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                    "choice_2_2"=>array(
                        "title"=>"เจ็บคอ",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                    "choice_3_2"=>array(
                        "title"=>"น้ำมูก",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                    "choice_4_2"=>array(
                        "title"=>"เสมหะ",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                    "choice_5_2"=>array(
                        "title"=>"หายใจลำบาก / เหนื่อย",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>15
                    ),
                )
            ),
            3=>array(
                "question_type" => 1,
                "section_id" => 3,
                "question_title" => "มีอาการทางระบบประสาทอย่างใดอย่างนึง",
                "question_details" => array(
                    "choice_1_3"=>array(
                        "title"=>"ไม่สามารถรับรสหรือกลิ่นได้",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>15
                    )
                )
            ),
            4=>array(
                "question_type" => 1,
                "section_id" => 4,
                "question_title" => "ในช่วง 14 วันที่ผ่านมา ท่านได้ทำ/ปฏิบัติ ตามตัวเลือกดังต่อไปนี้ หรือไม่",
                "question_details" => array(
                    "choice_1_4"=>array(
                        "title"=>"ท่านได้ใกล้ชิดผู้ป่วยที่ถูกยืนยัน หรือ ญาติจากพื้นที่ ควบคุมสูงสุดและเข้มงวด / ควบคุมสูงสุด หรือไม่",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>25
                    ),
                    "choice_2_4"=>array(
                        "title"=>"ท่านได้อาศัยในพื้นที่ ควบคุมสูงสุดและเข้มงวด / ควบคุมสูงสุด หรือไม่",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>20
                    )
                )
            )
        );
        return response()->json($this->questionaireToDB($dataSet));
    }

    public function questionaireToDB(Array $packer){
        $countarr = count($packer);
        $i = 0;
        QuestionairePrototype::truncate();
        QuestionairePrototypeDesc::truncate();
        foreach($packer as $p_array){
            $question = new QuestionairePrototype;
            $question->sections_id = $p_array['section_id'];
            $question->question_type = $p_array['question_type'];
            $question->question_title = $p_array['question_title'];
            $question->save();
            if($question->id){
                $question_det = new QuestionairePrototypeDesc;
                $question_det->questionaire_id = $question->id;
                $question_det->choices = json_encode($p_array['question_details']);
                $question_det->save();
                $i++;
            }
        }
        return (array(
            "actual"=>$countarr,
            "inserted"=>$i,
            "finished"=>$countarr == $i
        ));
    }

    public function insertData(Request $request){
        $req = $request->all();
        $insQa = QuestionaireAnswers::create(
            array(
                "name"=>$req['name'],
                "surname"=>$req['surname'],
                "church"=>$req['church'],
                "care_group"=>$req['care_group'],
                "answers"=>json_encode($req['answers']),
                "risk_score"=>$req['risk_score'],
                "risk_type"=>$req['risk_type']
            )
        );
        if($insQa->id){
            return Inertia::render('COVID/ThankYou',['id'=>$insQa]);
        }
    }

    public function checkIn(Request $request){
        if($request->id){
            $insQa = QuestionaireAnswers::find($request->id);
            return Inertia::render('COVID/CheckInInfo',['info'=>$insQa]);
        }
    }

    public function doCheckIn(Request $request){
        $rq = $request->all();
        print_r($rq);
        if($rq['user_id']){
            $cp = CheckInModel::create(
                array(
                    "user_id"=>$rq['user_id']
                )
            );
            if($cp->id){
                return response()->json(array("status"=>"ok"));
            }else{
                return response()->json(array("status"=>"bad"));
            }
        }
    }

    public function viewPerson(Request $request){
        $cnt = CheckInModel::all()->count();
        return Inertia::render('COVID/CountPerson',['counterQ'=>$cnt]);
    }

}
