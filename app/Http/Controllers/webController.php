<?php

namespace App\Http\Controllers;
use App\Models\persons;
use App\Models\life_story;
use App\Models\nobel_prizes;
use App\Models\person_nobel;





use Illuminate\Http\Request;

class webController extends Controller
{
//    Person
//    Ham show person active
    public function person() {
        $user = persons::where('status','active')->orderByDesc('created_at')->get();

        return response()->json($user);
    }

    //    Ham show person active
    public function persondisable() {
        $user = persons::where('status','disable')->orderByDesc('created_at')->get();

        return response()->json($user);
    }

//  Ham add person
    public  function  addperson(Request $request) {
        $user=new persons([
            'name'=>$request->input('name'),
            'birthdate'=>$request->input('birthdate'),
            'deathdate'=> $request-> input('deathdate'),
            'gender'=>$request->input('gender'),
            'national'=>$request->input('national'),
            'img'=>$request->input('img'),
            'status'=>$request->input('status'),
        ]);
        $user->save();

        return response()->json('success add person');
    }
//    Ham update person
    public function updateperson(Request $request, $id) {
        $user=persons::find($id);
        $user->update($request->all());
        return response()->json('Success updated');
    }

//    Ham disable person
    public  function disableperson(Request $request,$id) {
        $user=persons::find($id);
        $user->update($request->all());
        return response()->json('success disable');
    }
// Ham active person
    public  function activeperson(Request $request,$id) {
        $user=persons::find($id);
        $user->update($request->all());
        return response()->json('success disable');
    }
    // Ham delete person
    public  function deleteperson(Request $request,$id) {
        $user=persons::find($id);
        $user->delete();
        return response()->json('delete success');
    }
//Life
//ham show life active
    public function life() {
        $life=life_story::where('status','active')->orderByDesc('created_at')->get();
        return response()->json($life);
    }
//    ham show life disable
    public function lifedisable() {
        $life=life_story::where('status','disable')->orderByDesc('created_at')->get();
        return response()->json($life);
    }
//    Ham add life
    public  function addlife (Request $request) {
        $life=  new life_story ([
            'person_id'=>$request->input('person_id'),
            'life'=>$request->input('life'),
            'childhood'=>$request->input('childhood'),
            'education'=>$request->input('education'),
            'experiment'=>$request->input('experiment'),
            'struggles'=>$request->input('struggles'),
            'time_line'=>$request->input('time_line'),
            'personalities'=>$request->input('personalities'),
            'achievements_detail'=>$request->input('achievements_detail'),
            'quote'=>$request->input('quote'),
            'books'=>$request->input('books'),
            'status'=>$request->input('status'),


        ]);
        $life->save();
        return response()->json('Success add life');
    }

//    Hàm update life
    public function updatelife(Request $request,$id) {
        $life=life_story::find($id);
        $life->update($request->all());
        return response()->json('success updated');
    }
//    Ham disable life
    public function disablelife(Request $request,$id) {
        $life=life_story::find($id);
        $life->update($request->all());
        return response()->json('disable updated');
    }
//    Ham delete
    public  function deletelife(Request $request,$id) {
        $life=life_story::find($id);
        $life->delete();
        return response()->json('delete success');
    }
//Prize
//Ham show prize
    public function prize() {
        $prize=nobel_prizes::where('status','active')->orderByDesc('created_at')->get();
        return response()->json($prize);
    }
//    ham show disable prize
    public function prizedisable() {
        $prize=nobel_prizes::where('status','disable')->orderByDesc('created_at')->get();
        return response()->json($prize);
    }
//    Ham add prize
    public  function  addprize(Request $request) {
        $prize=new nobel_prizes([
            'nobel_year'=>$request->input('nobel_year'),
            'nobel_name'=>$request->input('nobel_name'),
            'status'=> $request-> input('status'),

        ]);
        $prize->save();

        return response()->json('success add prize');
    }
//ham update prize
    public function updateprize(Request $request,$id) {
        $prize=nobel_prizes::find($id);
        $prize->update($request->all());
        return response()->json('success updated');
    }
//    ham delete prize
    public  function deleteprize(Request $request,$id) {
        $prize=nobel_prizes::find($id);
        $prize->delete();
        return response()->json('delete success');
    }
//    person nobel
//ham show pn
    public function pn() {
        $pn=person_nobel::where('status','active')->orderByDesc('created_at')->get();
        return response()->json($pn);
    }
//    ham show disable pn
    public function pndisable() {
        $pn=person_nobel::where('status','disable')->orderByDesc('created_at')->get();
        return response()->json($pn);
    }
//    ham add pn
    public  function  addpn(Request $request) {
        $pn=new person_nobel([
            'person_id'=>$request->input('person_id'),
            'nobel_id'=>$request->input('nobel_id'),
            'motivation'=> $request-> input('motivation'),
            'nobel_share'=> $request-> input('nobel_share'),
            'status'=>$request->input('status')

        ]);
        $pn->save();

        return response()->json('success add prize');
    }
//    Ham update pn
    public  function updatepn(Request $request,$person_id,$nobel_id) {
        $pns=person_nobel::where('nobel_id',$nobel_id)->where('person_id',$person_id);
        $pns->update($request->all());
        return response()->json('update success');
    }
//    ham delete pn
    public  function deletepn(Request $request,$person_id,$nobel_id) {
        $pns=person_nobel::where('nobel_id',$nobel_id)->where('person_id',$person_id);
        $pns->delete();
        return response()->json('delete success');
    }
//    public  function  testpn(Request $request) {
//        $pn = person_nobel::
//    }

//    ------------------------
//    Life and person
    public function personlife() {
        $users=persons::where('status','active')->orderByDesc('created_at')->get();
            foreach ($users as $user) {
               $life[]= $user->life_story;
            }
        return response()->json($users);
    }
//Person and  Prize

    public function personprize() {
        $users=persons::where('status','active')->orderByDesc('created_at')->get();
        foreach ($users as $user) {
            $life[]= $user->nobel;
        }
        return response()->json($users);
    }

//nobel and prize
    public  function nobelprize() {
        $nobel=nobel_prizes::where('status','active')->orderByDesc('created_at')->get();
        foreach ($nobel as $n) {
            $person[]=$n->person;
        }
        return response()->json($nobel);
    }


//------------------------------------------------


}