<?php

namespace App\Http\Controllers;

use App\Models\Msg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
//use Validator;

class MsgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index()
    {
        $res = DB::table('msgs as a')
                    ->join('users as b','a.user_id','b.id')
                    ->select('a.id as msg_id', 'a.msg as msg_body', 'a.image as msg_image', 'b.name as user_name')
                    ->where('a.parent_id', 0)
                    ->paginate(5);
        
        foreach($res as $el){
            $child = DB::table('msgs as a')
                    ->join('users as b','a.user_id','b.id')
                    ->select('a.id as msg_id', 'a.msg as msg_body', 'a.image as msg_image', 'b.name as user_name')
                    ->where('a.parent_id', $el->msg_id)
                    ->get();
            /*$obj = (object)[
                'row' => $el,
                'child' => $child
            ];
            array_push($result, $obj);*/
  
            $el->child = $child;    
        }
        //dd($res);
        return view('index',['msg' => $res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $val_rules = [
            'msg' => 'required|max:1000',
            'image' => [Rule::dimensions()
                                ->maxWidth(500)
                                ->maxHeight(500)
                                ->minHeight(100)
                                ->minHeight(100)
                        ]
        ];
        $val = Validator::make($request->all(),$val_rules);
        if ($val->fails()) {
            return response()->json($val->errors(), 400);
        }           
        
        if (isset($request->image)){
        $filename    = $data['image']->getClientOriginalName();

        //Сохраняем оригинальную картинку
        $data['image']->move(Storage::path('/public/image/msg/').'origin/',$filename);

        //Создаем миниатюру изображения и сохраняем ее
        $thumbnail = Image::make(Storage::path('/public/image/msg/').'origin/'.$filename);
        $thumbnail->fit(100, 100);
        $thumbnail->save(Storage::path('/public/image/msg/').'thumbnail/'.$filename);

        //Сохраняем новость в БД
        $data['image'] = $filename;
        }     
        
        Msg::create($data);
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Msg  $msg
     * @return \Illuminate\Http\Response
     */
    public function show(Msg $msg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Msg  $msg
     * @return \Illuminate\Http\Response
     */
    public function edit(Msg $msg)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Msg  $msg
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Msg $msg)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Msg  $msg
     * @return \Illuminate\Http\Response
     */
    public function destroy(Msg $msg)
    {
        //
    }
}
