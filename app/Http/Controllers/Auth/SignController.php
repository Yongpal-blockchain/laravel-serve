<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Validator;
use Hash;
use App\User;
use Log;
use Auth;

class SignController extends Controller
{
    public function __constructor() {
        $this->middleware('guest');
    }

    public function getSignin() {
        return view('signin.index');
    }

    public function getSignup() {
        return view('signup.index');
    }

    public function postSignin(Request $request) {
        $rules = [
            'id' => 'required|min:5|exists:users,id', 
            'password' => 'required|min:5',
        ];
        
        $messages = [
            'id.required' => '아이디 입력은 필수입니다.',
            'id.min' => '입력하신 아이디가 너무 짧습니다.',
            'id.exists' => '입력하신 아이디는 존재하지 않습니다.',
            'password.min' => '비밀번호는 최소 5자리 입니다.',
            'password.required' => '비밀번호 입력은 필수입니다.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) 
            return redirect('signin')->withErrors($validator)->withInput();
        $user = User::where('id', $request->input('id'))->first();
        // dd($user);
        
        if(! $user)
            return redirect('signin');
            
        if (!Hash::check($request->password, $user->password)) 
            return redirect('signin')->with('no-password', '비밀번호가 일치하지 않습니다.')->withInput();
        
        if (Auth::attempt(['id' => $request->id, 'password' => $request->password])) {
            toast('로그인에 성공하였습니다.','success','top-right')
                    ->autoClose(2000);
            return redirect()->intended('/');
        }
    }

    public function postSignup(Request $request) {
        $client = new Client();
        Log::debug($request->all());
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'phone' => 'required|digits:11|unique:users',
            'password' => 'required',
            'address_postcode' => 'required',
            'address_roadAddress' => 'required',
            'address_jibunAddress' => 'required',
            'address_detail' => 'required'
        ];
    
        $messages = [
            'id.required' => '아이디를 입력해주세요.',
            'name.required' => '이름을 입력해주세요.',
            'phone.required' => '휴대폰번호를 입력 해주세요.',
            'phone.digits' => '휴대폰번호는 숫자만 가능합니다. (11자리).',
            'phone.unique' => '이미 존재하는 휴대폰 번호입니다.',
            'address_postcode.required' => '주소를 입력해주세요.',
            'address_jibunAddress.required' => '주소를 입력해주세요.',
            'address_roadAddress.required' => '주소를 입력해주세요.',
            'address_detail.required' => '상세주소를 입력해주세요.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

		if($validator->fails()) 
            return redirect('signup')->withErrors($validator)->withInput();
            
        if(User::where('id', $request->id)->first()) {
            return redirect('signup')->with('id-verify', '이미 존재하는 아이디입니다.')->withInput();
        } else { 
            $userArray = $request->only(['id', 'name', 'phone', 'password', 'address_postcode', 'address_roadAddress', 'address_jibunAddress', 'address_detail']);
            $userArray['user_id'] = $request->id;
            $userArray['password'] = Hash::make($request->password);
            $userArray['level'] = 0;

            Log::info('userArray==>');
            Log::debug($userArray);

            $response = $client->post('172.16.5.226:3000/api/users/signup', [
                'form_params' => [
                    'id' => $request->id,
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                User::insert($userArray);
                Auth::login(User::where('id', $request->id)->first());
                toast('회원가입이 완료되었습니다.','success','top-right')
                    ->autoClose(2000);
                return redirect('/');
            } else {
                return redirect('signup')->withErrors($validator)->withInput();
            }
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
