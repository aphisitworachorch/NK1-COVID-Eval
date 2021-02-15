<?php

namespace App\Http\Controllers;

use App\Models\CareGroupModel;
use App\Models\ChurchInfoModel;
use App\Models\QuestionaireAnswers;
use App\Models\QuestionairePrototype;
use App\Models\QuestionairePrototypeDesc;
use App\Models\CheckInModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionaireController extends Controller
{

    public function showForm(Request $request):\Inertia\Response
    {
        $translate = (strlen($request->translation) == 2) ? ($request->translation) : 'th';
        $question = QuestionairePrototypeDesc::with('questionPrototype')->where('translation',$translate)->get()->toJson();

        $careList = CareGroupModel::all();
        $careListText = [];
        foreach($careList as $cL){
            array_push($careListText,array(
                "value"=>$cL['id'],
                "text"=>$cL['care_name']
            ));
        }

        $churchList = ChurchInfoModel::all();
        $churchListText = [];
        foreach($churchList as $cL){
            array_push($churchListText,array(
                "value"=>$cL['id'],
                "text"=>$cL['church_name']
            ));
        }
        return Inertia::render('COVID/Evaluation'.strtoupper($translate),['form'=>$question,'care'=>$careListText,'church'=>$churchListText]);
    }

    public function showSession(Request $request){
        $session =  $request->session()->get('qrcode_id');
        $lang = $request->session()->get('lang');
        if($session && $lang){
            if($lang == "en"){
                return Inertia::render('COVID/ThankYouEN',['id'=>$insQa]);
            }
        }
    }

    public function makeQuestionaireTH():JsonResponse
    {
        $dataSet = array(
            1=>array(
                "question_type" => 1,
                "section_id" => 1,
                "question_title" => "มีไข้ / อุณหภูมิร่างกายมากกว่า 37.5 องศา",
                "translation" => "th",
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
                "translation" => "th",
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
                "translation" => "th",
                "question_details" => array(
                    "choice_1_3"=>array(
                        "title"=>"ไม่สามารถรับรสหรือกลิ่นได้ (อย่างใดอย่างนึง)",
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
                "translation" => "th",
                "question_details" => array(
                    "choice_1_4"=>array(
                        "title"=>"ท่านได้ใกล้ชิดผู้ป่วยที่ถูกยืนยัน หรือ ญาติจากพื้นที่ ควบคุมสูงสุดและเข้มงวด / ควบคุมสูงสุด หรือไม่ (สมุทรสาคร กรุงเทพมหานคร มหาสารคาม ปทุมธานี นนทบุรี สมุทรปราการ)",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>25
                    ),
                    "choice_2_4"=>array(
                        "title"=>"ท่านได้อาศัยในพื้นที่ ควบคุมสูงสุดและเข้มงวด / ควบคุมสูงสุด หรือไม่ (สมุทรสาคร กรุงเทพมหานคร มหาสารคาม ปทุมธานี นนทบุรี สมุทรปราการ)",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>20
                    )
                )
            )
        );
        return response()->json($this->questionaireToDB($dataSet));
    }

    public function makeQuestionaireEN():JsonResponse
    {
        $dataSet = array(
            1=>array(
                "question_type" => 1,
                "section_id" => 1,
                "question_title" => "Fever above 37.5 Celsius",
                "translation" => "en",
                "question_details" => array(
                    "choice_1_1"=>array(
                        "title"=>"Have a fever of 37.5 Celsius before Entering this place?",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                )
            ),
            2=>array(
                "question_type" => 1,
                "section_id" => 2,
                "question_title" => "Did you have one of Respiratory Symptoms",
                "translation" => "en",
                "question_details" => array(
                    "choice_1_2"=>array(
                        "title"=>"Cough",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                    "choice_2_2"=>array(
                        "title"=>"Sore Throat",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                    "choice_3_2"=>array(
                        "title"=>"Mucus / Runny Nose",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                    "choice_4_2"=>array(
                        "title"=>"Sputum",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>5
                    ),
                    "choice_5_2"=>array(
                        "title"=>"Hard of Breathing",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>15
                    ),
                )
            ),
            3=>array(
                "question_type" => 1,
                "section_id" => 3,
                "question_title" => "Did you have one of Neurological symptoms",
                "translation" => "en",
                "question_details" => array(
                    "choice_1_3"=>array(
                        "title"=>"Anosmia / Loss of Appetite / Loss of Taste (One of Them)",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>15
                    )
                )
            ),
            4=>array(
                "question_type" => 1,
                "section_id" => 4,
                "question_title" => "What did you do in 14 Days ? ",
                "translation" => "en",
                "question_details" => array(
                    "choice_1_4"=>array(
                        "title"=>"Near COVID-19 Confirmed Person or Have a neighbourhood from Controlled Area (Samut Sakhon , Bangkok , Maha Sarakham , Pathum Thani , Nonthaburi , Samut Prakan)",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>25
                    ),
                    "choice_2_4"=>array(
                        "title"=>"Stay within a day and from Controlled Area (Samut Sakhon , Bangkok , Maha Sarakham , Pathum Thani , Nonthaburi , Samut Prakan)",
                        "choices_type"=>[true,false],
                        "type"=>"true_or_false",
                        "weight"=>20
                    )
                )
            )
        );
        return response()->json($this->questionaireToDB($dataSet));
    }

    public function makeAllQuestionaire():JsonResponse
    {
        QuestionairePrototype::truncate();
        QuestionairePrototypeDesc::truncate();
        ChurchInfoModel::truncate();
        CareGroupModel::truncate();
        $churchName = ['สานสัมพันธ์นครราชสีมา 1 (NEXUS KR1)','สานสัมพันธ์นครราชสีมา 2 (NEXUS KR2)','สานสัมพันธ์อื่นๆ (NEXUS Family)','โบสถ์อื่นๆ (Other Church)','ไม่เข้าโบสถ์ (No Church)'];
        $careInfo = ['แคร์ในเมือง','แคร์จอหอ','แคร์โคกสูง','แคร์อื่นๆ','ไม่ได้เข้าร่วมแคร์','NIC Care'];
        foreach($churchName as $cN){
            ChurchInfoModel::create(
                array(
                    "church_name"=>$cN
                )
            );
        }
        foreach($careInfo as $cIF){
            CareGroupModel::create(
                array(
                    "care_name"=>$cIF
                )
            );
        }
        $this->makeQuestionaireEN();
        $this->makeQuestionaireTH();
        return response()->json(array(
            "status"=>"run !"
        ));
    }

    public function questionaireToDB(Array $packer):array
    {
        $countarr = count($packer);
        $i = 0;
        foreach($packer as $p_array){
            $question = new QuestionairePrototype;
            $question->sections_id = $p_array['section_id'];
            $question->question_type = $p_array['question_type'];
            $question->question_title = $p_array['question_title'];
            $question->translation = $p_array['translation'];
            $question->save();
            if($question->id){
                $question_det = new QuestionairePrototypeDesc;
                $question_det->questionaire_id = $question->id;
                $question_det->translation = $p_array['translation'];
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
            $request->session()->put('qrcode_id',$insQa->id);
            $request->session()->put('lang',$req['lang']);
        }
        if($req['lang'] === "EN"){
            if($insQa->id){
                return Inertia::render('COVID/ThankYouEN',['id'=>$insQa]);
            }
        }else if($req['lang'] === "TH"){
            if($insQa->id){
                return Inertia::render('COVID/ThankYouTH',['id'=>$insQa]);
            }
        }
    }

    public function checkIn(Request $request){
        if($request->id){
            $insQa = QuestionaireAnswers::with(['haveCare','haveChurch'])->where('id',$request->id)->get();
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
