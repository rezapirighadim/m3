<?php

namespace App\Http\Middleware;

use Closure;

class ConvertArabic2Persian
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private function arabicToPersian($input)
    {
        $characters = [
            '‌'  => ' ',
            'ك' => 'ک',
            'دِ' => 'د',
            'بِ' => 'ب',
            'زِ' => 'ز',
            'ذِ' => 'ذ',
            'شِ' => 'ش',
            'سِ' => 'س',
            'ى' => 'ی',
            'ي' => 'ی',
            '١' => '۱',
            '٢' => '۲',
            '٣' => '۳',
            '٤' => '۴',
            '٥' => '۵',
            '٦' => '۶',
            '٧' => '۷',
            '٨' => '۸',
            '٩' => '۹',
            '٠' => '۰',
        ];
        if (is_string($input))
            return str_replace(array_keys($characters), array_values($characters),$input);

        return $input;
    }

    public function handle($request, Closure $next)
    {
        $temp = [] ;
        if ( isset($request->request) ){

            foreach ($request->request as $key => $value){
                $temp[$key] = arabicToPersian( $this->arabicToPersian($value) );
            }
            $request->merge($temp);
        }
        return $next($request);
    }
}
