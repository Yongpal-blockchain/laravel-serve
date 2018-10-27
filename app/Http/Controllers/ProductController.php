<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Validator;
use Hash;
use App\User;
use App\Item;
use Log;
use Auth;
use File;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function add() {
        return view('product.store');
    }

    public function store(Request $request) {
        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $rules = [
            'title' => 'required',
            'content' => 'required',
            'address' => 'required',
            'item_status' => 'required',
            'price' => 'required|integer'
        ];
    
        $messages = [
            'title.required' => '상품명을 입력해주세요.',
            'content.required' => '상품내용을 입력해주세요.',
            'address.required' => '상품 거래 장소를 입력해주세요.',
            'item_status.required' => '상품 상태를 입력해주세요.',
            'price.required' => '상품 가격을 입력해주세요.',
            'price.integer' => '상품 가격을 숫자만 입력해주세요.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) 
            return back()->withErrors($validator)->withInput();

        $xid = rand(10000, 10000000);

        $image = $request->file('file');
        $request->file->move(public_path('images/'), $xid . '.png');        

        if(Item::where('xid', $xid)->first()) {
            Log::info('xid error');
            return back();
        } else {
            $response = $client->post('172.16.5.226:3000/api/invoke/item', [
                'form_params' => [                    
                    'xid' => $xid,
                    'title' => $request->title,
                    'address' => $request->address,
                    'status' => $request->item_status,
                    'owner' => Auth::user()->user_id,
                    'price' => $request->price
                ]
            ]);

            if ($response->getBody()->getContents() == 200) {
                Item::insert([
                    'xid' => $xid,
                    'content' => $request->content,
                    'user_id' => Auth::User()->user_id
                ]);
                toast('상품이 정상적으로 업로드 되었습니다.','success','top-right')
                    ->autoClose(2000);
                return redirect('/');
            } else {
                return redirect('signup')->withErrors($validator)->withInput();
            }
        }
    }

    public function payment(Request $request) {
        $client = new Client();

        $response = $client->post('172.16.5.226:3000/api/invoke/payment', [
            'form_params' => [                    
                'xid' => $request->xid,
                'username' => Auth::user()->user_id,
                'price' => $request->price
            ]
        ]);
        
        sleep(rand(1, 3));

        // 택배 전송은 픽션 
        $responseDelivery = $client->post('172.16.5.226:3000/api/invoke/deliver', [
            'form_params' => [                    
                'xid' => $request->xid
            ]
        ]);
        toast('구매가 되었습니다. 배송을 기다려보세요.','success','top-right')
            ->autoClose(2000);
        return redirect()->route('main');
    }

    public function getCheck() {
        $client = new Client();

        $response = $client->post('172.16.5.226:3000/api/query/payment', [
            'form_params' => [                    
                'id' => Auth::User()->user_id
            ]
        ]);

        $paymentCheckProducts = json_decode($response->getBody());

        $paymentProductCall = Item::where('user_id', Auth::User()->user_id)->get();

        // return $paymentCheckProducts;

        return view('product.check', compact('paymentCheckProducts', 'paymentProductCall'));
    }

}
