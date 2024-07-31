<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Content;
use App\Models\FavoriteContent;
use App\Models\Master;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function submit_comment(Request $request){
        $validData = $this->validate($request , [
            'content_id' => 'required',
            'body' => 'required',
        ]);
        $user_id =  auth()->user()->id;
        $user_name =  auth()->user()->name;

        $request =  $request->toArray();
        $request['confirm'] = false;
        $request['user_id'] = $user_id;
        $request['user_name'] = $user_name;
        Comment::create($request);
        return myResponse('success' , [] , 'نظر شما با موفقیت ثبت شد و بعد از تایید نمایش داده خواهد شد .');
    }

    public function submit_favorite(Request $request)
    {
        $this->validate($request , [
            'content_id' => 'required',
        ]);
        FavoriteContent::create([
            'content_id' => $request['content_id'],
            'user_id' => auth()->user()->id
        ]);
        return myResponse('success' , [] , ' با موفقیت ثبت شد و بعد از تایید نمایش داده خواهد شد .');
    }

    public function get_my_favorite()
    {
        $content_ids = FavoriteContent::whereUserId(auth()->user()->id)->pluck('content_id');
        return myResponse('success' , Content::whereIn('id' , $content_ids->toArray())->get() );

    }

    public function get_content_by_category_id_login(Request $request)
    {
        $this->validate($request , [
            'category_id' => 'required|exists:categories,id'
        ]);
        $user = auth()->user();
        if ($user->categories->contains($request['category_id']))
            return myResponse('success' ,  Content::whereCategory_id($request['category_id'])->with('files')->get());

        $free_contents = Content::where('free' , true)->with('files')->whereCategory_id($request['category_id'])->get()->toArray();
        $not_free_contents = Content::where('free' , false)->whereCategory_id($request['category_id'])->get()->toArray();
        return myResponse('success' , array_merge($free_contents , $not_free_contents));
    }

    public function get_team()
    {
        $array = [
            [
                'name' => 'مسعود ناهی' ,
                'image' => 'uploads/team/milad.jpeg',
                'link' => '#' ,
                'role' => 'پدیدآورنده' ,
            ],
            [
                'name' => 'میلاد کفاشیان فام' ,
                'image' => 'uploads/team/milad.jpeg',
                'link' => 'https://www.linkedin.com/in/milad-kaffashianfam-127a02108/' ,
                'role' => 'مدیر پروژه' ,
            ],
            [
                'name' => 'مسعود کفاشیان فام' ,
                'image' => 'uploads/team/milad.jpeg',
                'link' => '#' ,
                'role' => 'مدیر محتوا' ,
            ],
            [
                'name' => 'رضا پیری قدیم' ,
                'image' => 'uploads/team/reza_pirighadim.jpeg',
                'link' => 'https://www.linkedin.com/in/rezapiryghadim' ,
                'role' => 'مدیرفنی' ,
                ],
            [
                'name' => 'فرهاد لوایی' ,
                'image' => 'uploads/team/farhad.jpeg',
                'link' => 'https://www.linkedin.com/in/farhad-lavaei-12b95b41/' ,
                'role' => 'لید فرانت' ,
                ],
        ];

        return myResponse('success' , $array);
    }

    public function about_nahi()
    {
        $data = '<p style="font-weight: normal; text-align: right;">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>' ;
        return myResponse('success' , $data );
    }

    public function get_masters()
    {
        $masters = Master::all();
        return myResponse('success' , $masters);
    }

}
