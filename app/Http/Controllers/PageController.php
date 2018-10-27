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

class PageController extends Controller
{
    public function index() {
        $client = new Client();

        $response = $client->get('172.16.5.226:3000/api/query/items', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $products = json_decode($response->getBody());

        $productSubs = Item::orderBy('id', 'desc')->get();

        return view('product.index', compact('products', 'productSubs'));
    }

    public function products() {
        $client = new Client();

        $response = $client->get('172.16.5.226:3000/api/query/items', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $products = json_decode($response->getBody());

        $productSubs = Item::orderBy('id', 'desc')->get();

        return view('product.index', compact('products', 'productSubs'));
    }

    public function show($xid) {
        $client = new Client();

        $response = $client->get('172.16.5.226:3000/api/query/item/' . $xid, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        if (! $response->getStatusCode() == 200) {
            toast('상품 정보에 오류가 있습니다. 다시 시도해주시기 바랍니다.', 'error', 'top-right')
                ->autoClose(2000);
            return redirect('/');
        }

        $product = json_decode($response->getBody());
        $productSub = Item::where('xid', $xid)->first();

        return view('product.show', compact('product', 'productSub'));
    }

    public function productPaymentCheck(Request $request) {
        Log::debug($request->all());
        $client = new Client();

        $response = $client->post('172.16.5.226:3000/api/invoke/check', [
            'form_params' => [                    
                'xid' => $request->xid,
                'status' => $request->status,
            ]
        ]);
    }
}
