<?php

namespace App\Http\Controllers\Admin;

use App\AppInstall;
use App\BookContent;
use App\MobileUser;
use App\Publisher;
use App\Tariff;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $data;
    protected $role ;
    protected $seller_id ;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->role == 'admin' || \Auth::user()->role == 'seller' ) {
                $this->role =  \Auth::user()->role;
                $this->seller_id = $this->role == 'admin' ? 0 : \Auth::user()->id;
            }else{
                exit('forbidden access');
            }
            return $next($request);
        });

        $this->data['newMessages'] = array();
    }

    public function index() {
        $data['title'] = "داشبورد";
        $data['path'] = "داشبورد";

        return View('admin.index', $data);
    }

    private function getLastMonths($month)
    {
        for ($i = 0 ; $i < $month ; $i++) {
            list($y,$m,$d) = (explode('-',Carbon::now()->subMonths($i)->toDateString()));
            $labels[] = get_month_name(gregorian_to_jalali( $y,$m,$d ,'/'));
        }
        return array_reverse($labels);
    }

    private function CheckCount($count, $month)
    {
        for ($i = 0 ; $i < $month ; $i++) {
            $new[$i] = empty($count[$i]) ? 0 : $count[$i];
        }
        return array_reverse($new);
    }

    private function get_book_data()
    {
        $books = [];
        $bookContentCount = 0;
        $free_book = 0;

        if (auth()->user()->role == 'seller') {
            $publishers = Publisher::whereSeller_id(auth()->user()->id)->get()->pluck('id')->toArray();
            foreach ($publishers as $publisher) {
                $books[] = Publisher::whereId($publisher)->first()->book()->get()->toArray();
            }


            try {
                if (count($books))
                    $books = array_merge(... $books);
            } catch (\Exception $e) {
                // TODO : complete when bug reporter done
            }

            foreach ($books as $book){
                if (!$book['price'])
                    $free_book++;
            }

            $books_ids = array_column($books, 'id');

            $bookContentCount = BookContent::whereIn('book_id' , $books_ids)
                ->where('content', '!=', '')
                ->whereNotNull('content')
                ->get()
                ->count();



        }

        $data['free_book'] = $free_book;
        $data['book_limit'] = auth()->user()->book_limit;
        $data['book_count'] = count($books);
        $data['book_content_count'] = $bookContentCount;

        return $data;
    }

    private function app_users(){
        $app_install = AppInstall::whereSeller_hash(auth()->user()->hash)->get()->toArray();
        $app_hash = AppInstall::whereSeller_hash(auth()->user()->hash)->pluck('hash')->toArray();
        $mobile_users_count = MobileUser::whereIn('api_hash' , $app_hash)->get()->count();


        $data['app_install'] = count($app_install);
        $data['user_count'] = $mobile_users_count;

        return $data;


    }

    public function buy_modules(){
        $data['title'] = "داشبورد";
        $data['path'] = "داشبورد";
        $data['tariffs'] = Tariff::all();

        $limit = auth()->user()->book_limit;
        $limit = $limit ? $limit : 0;

        $count = BookContent::whereUser_id(auth()->user()->id)->pluck('book_id')->toArray();
        $count = count(array_unique($count));
        $data['seller_limit'] = $limit - $count ;

        $data = array_merge($data, $this->data);

        return View('admin.buy_modules', $data);
    }


}
