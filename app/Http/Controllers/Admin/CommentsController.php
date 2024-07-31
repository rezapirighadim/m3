<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CommentsController extends AdminController
{
    public function list(){


        $comments = Comment::toArray();

        dd($comments);

    }

    public function all($type = 'all'){
        $comments = [];
        switch ($type){
            case 'all':
                $comments = Comment::get()->toArray();
                break;
            case 'confirmed' :
                $comments = Comment::whereConfirm(1)->get()->toArray();
                break;
            case 'not_confirmed' :
                $comments = Comment::whereConfirm(0)->get()->toArray();
                break;
            default :
                return redirect('/admin/comments');
        }

        $data['title'] = "نظرات کاربران";
        $data['path'] = "مدیریت وب سایت / نظرات کاربران";
        $data['comments'] = $comments;

        $data = array_merge($data, $this->data);

        return view('admin.comments' , $data);

    }

    public function confirm_comment($id){

        $result = comment::where('id', $id)->update([
            'confirm' => 1
        ]);

        return $result;
    }
    public function remove_comment($id){

        $result =  comment::where('id', $id)->delete();

        return $result;
    }
}
