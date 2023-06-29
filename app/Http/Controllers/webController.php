<?php

namespace App\Http\Controllers;

use App\Models\persons;
use App\Models\life_story;
use App\Models\nobel_prizes;
use App\Models\person_nobel;
use App\Models\blog;
use App\Models\users;



use http\Env\Response;
use Illuminate\Http\Request;

class webController extends Controller
{
    //    Person
    //    Ham show person active
    public function person()
    {
        $user = persons::where('status', 'active')->orderByDesc('created_at')->get();

        return response()->json($user);
    }

    //    Ham show person active
    public function persondisable()
    {
        $user = persons::where('status', 'disable')->orderByDesc('created_at')->get();

        return response()->json($user);
    }





//  Ham add person
    public  function  addperson(Request $request) {
            if($request->has('img')&& $request->has('pdf') && $request->has('avatar')) {
                $user=new persons([
                    'name'=>$request->input('name'),
                    'birthdate'=>$request->input('birthdate'),
                    'deathdate'=> $request-> input('deathdate'),
                    'gender'=>$request->input('gender'),
                    'national'=>$request->input('national'),
                    'status'=>$request->input('status'),
                ]);
                $img=array();
                $images=$request->file('img');
                foreach($images as $image){

                    $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('img'),$filename);
                    array_push($img,$filename);

                }
                $avatar=$request->file('avatar');
                $fileAvatar=time() . '_' . mt_rand(1000, 9999) . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('img'),$fileAvatar);

                $pdf=$request->file('pdf');
                $pdfname=time() . '_' . mt_rand(1000, 9999) . '.' . $pdf->getClientOriginalExtension();
                $pdf->move(public_path('pdf'),$pdfname);
                $user->img= join(',',$img);
                $user->avatar=$fileAvatar;
                $user->pdf=$pdfname;
                $user->save();
            }
            elseif ($request->has('img')&&$request->has('avatar')) {
                $user=new persons([
                    'name'=>$request->input('name'),
                    'birthdate'=>$request->input('birthdate'),
                    'deathdate'=> $request-> input('deathdate'),
                    'gender'=>$request->input('gender'),
                    'national'=>$request->input('national'),
                    'status'=>$request->input('status'),
                ]);
                $img=array();
                $images=$request->file('img');
                foreach($images as $image){

                    $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('img'),$filename);
                    array_push($img,$filename);

                }
                $avatar=$request->file('avatar');
                $fileAvatar=time() . '_' . mt_rand(1000, 9999) . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('img'),$fileAvatar);
                $user->avatar=$fileAvatar;
                $user->img= join(',',$img);

                $user->save();
            }
            elseif( $request->has('pdf')&&$request->has('avatar')) {
                $user=new persons([
                    'name'=>$request->input('name'),
                    'birthdate'=>$request->input('birthdate'),
                    'deathdate'=> $request-> input('deathdate'),
                    'gender'=>$request->input('gender'),
                    'national'=>$request->input('national'),
                    'status'=>$request->input('status'),
                ]);
                $pdf=$request->file('pdf');
                $pdfname=time() . '_' . mt_rand(1000, 9999) . '.' . $pdf->getClientOriginalExtension();
                $pdf->move(public_path('pdf'),$pdfname);
                $avatar=$request->file('avatar');
                $fileAvatar=time() . '_' . mt_rand(1000, 9999) . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('img'),$fileAvatar);
                $user->avatar=$fileAvatar;

                $user->pdf=$pdfname;
                $user->save();
            }
            elseif ($request->has('avatar')) {
                $user=new persons([
                    'name'=>$request->input('name'),
                    'birthdate'=>$request->input('birthdate'),
                    'deathdate'=> $request-> input('deathdate'),
                    'gender'=>$request->input('gender'),
                    'national'=>$request->input('national'),
                    'status'=>$request->input('status'),
                ]);

                $avatar=$request->file('avatar');
                $fileAvatar=time() . '_' . mt_rand(1000, 9999) . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('img'),$fileAvatar);
                $user->avatar=$fileAvatar;


                $user->save();
            }
            elseif ($request->has('img')) {
                $user=new persons([
                    'name'=>$request->input('name'),
                    'birthdate'=>$request->input('birthdate'),
                    'deathdate'=> $request-> input('deathdate'),
                    'gender'=>$request->input('gender'),
                    'national'=>$request->input('national'),
                    'status'=>$request->input('status'),
                ]);
                $img=array();
                $images=$request->file('img');
                foreach($images as $image){

                    $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('img'),$filename);
                    array_push($img,$filename);

                }


                $user->img= join(',',$img);

                $user->save();
            }
            else if($request->has('pdf')) {
                $user=new persons([
                    'name'=>$request->input('name'),
                    'birthdate'=>$request->input('birthdate'),
                    'deathdate'=> $request-> input('deathdate'),
                    'gender'=>$request->input('gender'),
                    'national'=>$request->input('national'),
                    'status'=>$request->input('status'),
                ]);
                $pdf=$request->file('pdf');
                $pdfname=time() . '_' . mt_rand(1000, 9999) . '.' . $pdf->getClientOriginalExtension();
                $pdf->move(public_path('pdf'),$pdfname);

                $user->pdf=$pdfname;
                $user->save();
            }
            else {
                $user=new persons([
                    'name'=>$request->input('name'),
                    'birthdate'=>$request->input('birthdate'),
                    'deathdate'=> $request-> input('deathdate'),
                    'gender'=>$request->input('gender'),
                    'national'=>$request->input('national'),
                    'status'=>$request->input('status'),
                ]);
                $user->save();
            }





        return response()->json('success add person');
    }

//    Ham update person
    public function updateperson(Request $request, $id) {
        $user=persons::find($id);

        if($request->has('image') && $request->has('pdf') && $request->has('avatar')) {
            $img=array();
            $images=$request->file('image');
            $pdf=$request->file('pdf');
            $pdfname=time() . '_' . mt_rand(1000, 9999) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('pdf'),$pdfname);
            foreach($images as $image){

                $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img'),$filename);
                array_push($img,$filename);
            }


            $avatar=$request->file('avatar');
            $fileAvatar=time() . '_' . mt_rand(1000, 9999) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('img'),$fileAvatar);
            $user->avatar=$fileAvatar;

            $user->pdf=$pdfname;
            $user->save();
            $user->name = $request->input('name');
            $user->birthdate = $request->input('birthdate');
            $user->deathdate = $request->input('deathdate');
            $user->gender = $request->input('gender');
            $user->national = $request->input('national');
            $user->img = join(',', $img);
            $user->status = $request->input('status');
            $user->pdf=$pdfname;
            $user->save();
            return response()->json('Success updated');

        }
        else if ($request->has('image') ){
            $img=array();
            $images=$request->file('image');

            foreach($images as $image){

                $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img'),$filename);
                array_push($img,$filename);
            }
            $user->name = $request->input('name');
            $user->birthdate = $request->input('birthdate');
            $user->deathdate = $request->input('deathdate');
            $user->gender = $request->input('gender');
            $user->national = $request->input('national');
            $user->img = join(',', $img);
            $user->status = $request->input('status');

            $user->save();
            return response()->json('Success updated');
        }
        else if($request->has('pdf')) {

            $pdf=$request->file('pdf');
            $pdfname=time() . '_' . mt_rand(1000, 9999) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('pdf'),$pdfname);

            $user->name = $request->input('name');
            $user->birthdate = $request->input('birthdate');
            $user->deathdate = $request->input('deathdate');
            $user->gender = $request->input('gender');
            $user->national = $request->input('national');

            $user->status = $request->input('status');
            $user->pdf=$pdfname;
            $user->save();
            return response()->json('Success updated');
        }
        elseif ($request->has('image') && $request->has('avatar') ) {
            $img=array();
            $images=$request->file('image');

            foreach($images as $image){

                $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img'),$filename);
                array_push($img,$filename);
            }
            $avatar=$request->file('avatar');
            $fileAvatar=time() . '_' . mt_rand(1000, 9999) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('img'),$fileAvatar);
            $user->avatar=$fileAvatar;

            $user->name = $request->input('name');
            $user->birthdate = $request->input('birthdate');
            $user->deathdate = $request->input('deathdate');
            $user->gender = $request->input('gender');
            $user->national = $request->input('national');
            $user->img = join(',', $img);
            $user->status = $request->input('status');

            $user->save();
            return response()->json('Success updated');
        }
        elseif($request->has('pdf') && $request->has('avatar')) {

            $pdf=$request->file('pdf');
            $pdfname=time() . '_' . mt_rand(1000, 9999) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('pdf'),$pdfname);

            $avatar=$request->file('avatar');
            $fileAvatar=time() . '_' . mt_rand(1000, 9999) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('img'),$fileAvatar);
            $user->avatar=$fileAvatar;

            $user->name = $request->input('name');
            $user->birthdate = $request->input('birthdate');
            $user->deathdate = $request->input('deathdate');
            $user->gender = $request->input('gender');
            $user->national = $request->input('national');

            $user->status = $request->input('status');
            $user->pdf=$pdfname;
            $user->save();
            return response()->json('Success updated');
        }
        elseif($request->has('avatar')) {
            $avatar=$request->file('avatar');
            $fileAvatar=time() . '_' . mt_rand(1000, 9999) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('img'),$fileAvatar);
            $user->avatar=$fileAvatar;
            $user->birthdate = $request->input('birthdate');
            $user->deathdate = $request->input('deathdate');
            $user->gender = $request->input('gender');
            $user->national = $request->input('national');

            $user->status = $request->input('status');
            $user->save();
            return response()->json('Success updated');
        }
        else {
            $user->update($request->all());
            return  response()->json("Success updated");
        }


    }

    //    Ham disable person
    public  function disableperson(Request $request, $id)
    {
        $user = persons::find($id);
        $user->update($request->all());

        return response()->json('success disable');
    }
    // Ham active person
    public  function activeperson(Request $request, $id)
    {
        $user = persons::find($id);
        $user->update($request->all());
        return response()->json('success disable');
    }
    // Ham delete person
    public  function deleteperson(Request $request, $id)
    {
        $user = persons::find($id);
        $user->delete();
        return response()->json('delete success');
    }
    //Life
    //ham show life active
    public function life()
    {
        $life = life_story::where('status', 'active')->orderByDesc('created_at')->get();
        return response()->json($life);
    }
    //    ham show life disable
    public function lifedisable()
    {
        $life = life_story::where('status', 'disable')->orderByDesc('created_at')->get();
        return response()->json($life);
    }
    //    Ham add life
    public  function addlife(Request $request)
    {
        $life =  new life_story([
            'person_id' => $request->input('person_id'),
            'life' => $request->input('life'),
            'childhood' => $request->input('childhood'),
            'education' => $request->input('education'),
            'experiment' => $request->input('experiment'),
            'struggles' => $request->input('struggles'),
            'time_line' => $request->input('time_line'),
            'personalities' => $request->input('personalities'),
            'achievements_detail' => $request->input('achievements_detail'),
            'quote' => $request->input('quote'),
            'books' => $request->input('books'),
            'status' => $request->input('status'),


        ]);
        $life->save();
        return response()->json('Success add life');
    }

    //    Hàm update life
    public function updatelife(Request $request, $id)
    {
        $life = life_story::find($id);
        $life->update($request->all());
        return response()->json('success updated');
    }
    //    Ham disable life
    public function disablelife(Request $request, $id)
    {
        $life = life_story::find($id);
        $life->update($request->all());
        return response()->json('disable updated');
    }
    //    Ham delete
    public  function deletelife(Request $request, $id)
    {
        $life = life_story::find($id);
        $life->delete();
        return response()->json('delete success');
    }
    //Prize
    //Ham show prize
    public function prize()
    {
        $prize = nobel_prizes::where('status', 'active')->orderByDesc('created_at')->get();
        return response()->json($prize);
    }
    //    ham show disable prize
    public function prizedisable()
    {
        $prize = nobel_prizes::where('status', 'disable')->orderByDesc('created_at')->get();
        return response()->json($prize);
    }
    //    Ham add prize
    public  function  addprize(Request $request)
    {
        $prize = new nobel_prizes([
            'nobel_year' => $request->input('nobel_year'),
            'nobel_name' => $request->input('nobel_name'),
            'status' => $request->input('status'),

        ]);
        $prize->save();

        return response()->json('success add prize');
    }
    //ham update prize
    public function updateprize(Request $request, $id)
    {
        $prize = nobel_prizes::find($id);
        $prize->update($request->all());
        return response()->json('success updated');
    }
    //    ham delete prize
    public  function deleteprize(Request $request, $id)
    {
        $prize = nobel_prizes::find($id);
        $prize->delete();
        return response()->json('delete success');
    }
    //    person nobel
    //ham show pn
    public function pn()
    {
        $pn = person_nobel::where('status', 'active')->orderByDesc('created_at')->get();
        return response()->json($pn);
    }
    //    ham show disable pn
    public function pndisable()
    {
        $pn = person_nobel::where('status', 'disable')->orderByDesc('created_at')->get();
        return response()->json($pn);
    }
    //    ham add pn
    public  function  addpn(Request $request)
    {
        $pn = new person_nobel([
            'person_id' => $request->input('person_id'),
            'nobel_id' => $request->input('nobel_id'),
            'motivation' => $request->input('motivation'),
            'nobel_share' => $request->input('nobel_share'),
            'status' => $request->input('status')

        ]);
        $pn->save();

        return response()->json('success add prize');
    }
    //    Ham update pn
    public  function updatepn(Request $request, $person_id, $nobel_id)
    {
        $pns = person_nobel::where('nobel_id', $nobel_id)->where('person_id', $person_id);
        $pns->update($request->all());
        return response()->json('update success');
    }
    //    ham delete pn
    public  function deletepn(Request $request, $person_id, $nobel_id)
    {
        $pns = person_nobel::where('nobel_id', $nobel_id)->where('person_id', $person_id);
        $pns->delete();
        return response()->json('delete success');
    }
    //    public  function  testpn(Request $request) {
    //        $pn = person_nobel::
    //    }

    //    ------------------------
    //    Life and person
    public function personlife()
    {
        $users = persons::where('status', 'active')->orderByDesc('created_at')->get();
        foreach ($users as $user) {
            $life[] = $user->life_story;
        }
        return response()->json($users);
    }
    //Person and  Prize

    public function personprize() {
        $users=persons::orderByDesc('created_at')->get();
        foreach ($users as $user) {
            $prize[]= $user->nobel;
            $life[]= $user->life_story;
        }

        return response()->json($users);
    }

    //nobel and prize
    public  function nobelprize()
    {
        $nobel = nobel_prizes::where('status', 'active')->orderByDesc('created_at')->get();
        foreach ($nobel as $n) {
            $person[] = $n->person;
        }
        return response()->json($nobel);
    }


    //------------------------------------------------
    // Ham blog
    // Ham show blog
    public function showblog () {
        $blog=blog::where('status','active')->get();
        return response()->json($blog);
    }
    public function showdisableblog () {
        $blog=blog::where('status','disable')->get();
        return response()->json($blog);
    }

    public function addblog (Request $request) {
        if($request->has('img')) {
            $blog = new blog([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'content' => $request->input('content'),

                'status' => $request->input('status'),
            ]);
            $img = array();
            $images = $request->file('img');
            foreach ($images as $image) {

                $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img'), $filename);
                array_push($img, $filename);
            }
            $blog->img = join(',', $img);
            $blog->save();

        }
        else {


//                dd($request->input('status'));
            $blog= new blog([
                'title'=>$request->input('title'),
                'author'=>$request->input('author'),
                'content'=>$request->input('content'),

                'status'=>$request->input('status'),
            ]);
            $blog->save();
        }

        return response()->json("add success");
        }


        public  function updateblog(Request $request,$id) {
        $blog=blog::find($id);
        if($request->has('img')) {

            $blog->title=$request->input('title');
            $blog->author=$request->input('author');
            $blog->status=$request->input('status');
            $images = $request->file('img');
            $img=array();
            foreach ($images as $image) {

                $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img'), $filename);
                array_push($img, $filename);
            }
            $blog->img = join(',', $img);
            $blog->save();
            return response()->json('update success');
        }
        else {

            $blog->update($request->all());
        }
        }

        public  function deleteblog($id) {
        $blog=blog::find($id);
        $blog->delete();
        return response()->json('Delete success');
        }

//LOGIN AND LOGOUT
    public function login(Request $request) {
        $user=users::where('email',$request->email)->where('password',$request->password)->first();
       if($user) {
           $request->session()->put('user',$user['email']);
           return response()->json([session('user')]);
       }
       else {
           dd($request->all());
           return response()->json('login fail');
       }
    }

    public  function logout(Request $request) {
        session(['user' => null]);
        return response()->json('logout sucess');
    }




}