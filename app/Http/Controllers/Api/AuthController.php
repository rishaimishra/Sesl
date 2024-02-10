<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\User;
use App\Models\UserVerification;
use App\Models\SellerDetail;
use App\Notifications\ForgotPasswordSms;
use App\Notifications\MobileNumberVerification;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Validator;
use function Illuminate\Support\Facades\Hash;

use Twilio\Rest\Client;

class AuthController extends ApiController
{
    public $successStatus = 200;

    use AuthenticatesUsers;

    public function __construct()
    {

        $this->middleware('throttle:5,1')->only('resendOTP');
        $this->middleware('throttle:5,5')->only('changeMobileNumber');
        $this->middleware('throttle:5,5')->only('mobileVerification');
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'mobile_number' => 'required|phone:AUTO|unique:users,mobile_number',
            'username' => 'required|string|alpha_num|unique:users,username'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['code'] = 0;

        /* Gererate otp from helper*/
        $code = generateOtp();

        /* User Register */
        $user = User::create($input);

        /* OTP code save */
        $user->userVerifications()->insert([
            'identity' => $user->mobile_number,
            'code' => $code,
            'user_id' => $user->id,
            'expired_at' => now()->addMinutes(15),
            'created_at' => now()
        ]);

        /* Otp Send On User's  Mobile */
        $user->notify(new MobileNumberVerification($code));

        $token = $user->createToken('AppName')->accessToken;
        if (is_null($user->cart)) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $user->cart()->save($cart);
        }
        return $this->success(
            'You are successfully registered with us. We have sent you a OPT to verify your mobile number.',
            [
                'is_mobile_verified' => (!is_null($user->mobile_verified_at)) ? true : false,
                'token' => $token
            ]
        );
    }


    public function registerSeller(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'mobile_number' => 'required|phone:AUTO|unique:users,mobile_number',
            'username' => 'required|string|alpha_num|unique:users,username'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['code'] = 1;
        $input['is_seller'] = 1;
        $input['mobile_verified_at'] = new \DateTime();

        /* User Register */
        $user = User::create($input);

        $sellerdetail = new SellerDetail();
        $sellerdetail->user_id = $user->id;
        $sellerdetail->store_name = $input['name'];
        $sellerdetail->save();


        $token = $user->createToken('AppName')->accessToken;

        return $this->success(
            'You are successfully registered with us. We have sent you a OTP to verify your mobile number.',
            [
                'is_mobile_verified' => (!is_null($user->mobile_verified_at)) ? true : false,
                'token' => $token
            ]
        );
    }


    public function login(Request $request)
    {

        /* Validate Request */
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        /* Validate max attempts */
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );
            return $this->error([
                'message' => Lang::get('auth.throttle', ['seconds' => $seconds])
            ]);
        }
        /* Add Attempts */
        $this->incrementLoginAttempts($request);

        $credentials = [];
        if ($this->isEmail($request->input('username'))) {
            $credentials = ['email' => request('username'), 'password' => request('password')];
        } elseif ($this->isMobile($request)) {
            $credentials = ['mobile_number' => request('username'), 'password' => request('password')];
        } else {
            $credentials = ['username' => request('username'), 'password' => request('password')];
        }
        /* Auth Credentials */
        if (!empty($credentials) && Auth::attempt($credentials)) {

            /* clear Attempts */
            $this->clearLoginAttempts($request);

            /* @var $user \App\Models\User */
            $user = Auth::user();
            if ($user->is_active) {
                $token = $user->createToken('AppName')->accessToken;
                if (is_null($user->cart)) {
                    $cart = new Cart();
                    $cart->user_id = $user->id;
                    $user->cart()->save($cart);
                }
                return $this->success("Success", [
                    'is_mobile_verified' => $user->hasVerifiedMobile(),
                    'token' => $token
                ]);
            } else {
                return $this->genericError('This user account not active.');
            }
        } else {
            return $this->genericError('Invalid credentials.');
        }
    }


    public function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isMobile($request)
    {

        $validator = Validator::make(['username' => $request->username], [
            'username' => 'phone:AUTO'
        ]);
        if ($validator->fails()) {

            return false;
        } else {

            return true;
        }
    }

    public function forgotPassword(Request $request)
    {

        /* Validate Request */
        $request->validate([
            'username' => 'required'
        ]);
        $credentials = [];
        if ($this->isEmail($request->input('username'))) {
            $credentials = ['email' => request('username')];
        } elseif ($this->isMobile($request)) {
            $credentials = ['mobile_number' => request('username')];
        } else {
            $credentials = ['username' => request('username')];
        }


        /* Generate otp from helper*/
        $code = generateOtp();

        /* User find */
        $user = User::where($credentials)->first();

        if ($user) {
            /* OTP code save */
            $user->userVerifications()->insert([
                'identity' => $user->mobile_number,
                'code' => $code,
                'user_id' => $user->id,
                'expired_at' => now()->addMinutes(15),
                'created_at' => now()
            ]);

            $message = "SESL You OTP is: ".$code;
            /* Otp Send to User's  Mobile */
            // $user->notify(new ForgotPasswordSms($code));
            try {
                $accountSid = getenv("TWILIO_SID");
                $authToken = getenv("TWILIO_TOKEN");
                $twilioNumber = getenv("TWILIO_FROM");

                //dd("account ssid ".$accountSid);
                //dd("auth token".$authToken);

     
                $client = new Client($accountSid, $authToken);
     
                $client->messages->create($user->mobile_number, [
                    'from' => $twilioNumber,
                    'body' => $message
                ]);
                // dd("Sms sent");
                
     
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            return $this->success("Verification code send for password reset.");
        } else {
            return $this->genericError('Invalid username');
        }
    }

    public function checkOTP(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:4',
            'username' => 'required',
        ]);

        $credentials = [];
        if ($this->isEmail($request->input('username'))) {
            $credentials = ['email' => request('username')];
        } elseif ($this->isMobile($request)) {
            $credentials = ['mobile_number' => request('username')];
        } else {
            $credentials = ['username' => request('username')];
        }


        $code = $request->input('code');

        /* User find */
        $user = User::where($credentials)->first();

        if ($user) {

            $isValidVerification = UserVerification::where([
                'identity' => $user->mobile_number,
                'code' => $request->input('code'),
                'user_id' => $user->id
            ])
                ->where('expired_at', '>', now()->subMinutes(15)->format('Y-m-d H:i:s'))
                ->exists();


            if ($isValidVerification) {

                return $this->success('valid otp.');
            } else {
                return $this->error(['code' => 4003, "message" => 'OTP may expired or invalidated.']);
            }
        } else {
            return $this->genericError('Username not found.');
        }
    }

    public function resetPassword(Request $request)
    {

        /* Validate Request */
        $request->validate([
            'username' => 'required',
            'code' => 'required|digits:4',
            'password' => 'required|min:8',
        ]);
        $credentials = [];
        if ($this->isEmail($request->input('username'))) {
            $credentials = ['email' => request('username')];
        } elseif ($this->isMobile($request)) {
            $credentials = ['mobile_number' => request('username')];
        } else {
            $credentials = ['username' => request('username')];
        }


        /* User find */
        $user = User::where($credentials)->first();

        if ($user) {
            /* OTP code find */
            $isValidVerification = UserVerification::where([
                'identity' => $user->mobile_number,
                'code' => $request->input('code'),
                'user_id' => $user->id
            ])
                ->where('expired_at', '>', now()->subMinutes(15)->format('Y-m-d H:i:s'))
                ->exists();


            if ($isValidVerification) {

                $user->update([
                    'password' => Hash::make($request->input('password'))
                ]);

                UserVerification::where(['user_id' => $user->id])->delete();

                return $this->success('Password reset successfully.');
            } else {
                return $this->error(['code' => 4003, "message" => 'OTP may expired or invalidated.']);
            }
        } else {
            return $this->genericError('Username not found.');
        }
    }

    public function updatePassword(Request $request)
    {

        /* Validate Request */
        $request->validate([
            'current' => ['required', 'string'],
            'password' => ['required', 'min:8', 'different:current'],
        ], [
            'current' => 'Current Password',
            'password' => 'New Password'
        ]);

        $user = $request->user();

        if (!Hash::check($request->current, $user->password)) {
            return $this->genericError('Current Password does not match.');
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return $this->success('Password reset successfully.');
    }


    public function resendOTP(Request $request)
    {

        $user = $request->user();

        /* Gererate otp from helper*/
        $code = generateOtp();

        $user->userVerifications()->insert([
            'identity' => $user->mobile_number,
            'code' => $code,
            'user_id' => $user->id,
            'expired_at' => now()->addMinutes(15),
            'created_at' => now()
        ]);


        /* Otp Send On User's  Mobile */
        $user->notify(new MobileNumberVerification($code));

        return $this->success('Mobile verification code sent.');
    }

    public function changeMobileNumber(Request $request)
    {
        /* Validate Request */
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = $request->user();
        $mobile_number = $request->input('mobile_number');
        /* Gererate otp from helper*/
        $code = generateOtp();

        $user->update([
            'mobile_number' => $mobile_number,
        ]);

        $user->userVerifications()->where(['user_id' => $user->id])->delete();

        $user->userVerifications()->insert([
            'identity' => $user->mobile_number,
            'code' => $code,
            'user_id' => $user->id,
            'expired_at' => now()->addMinutes(15),
            'created_at' => now()
        ]);


        /* Otp Send On User's  Mobile */
        $user->notify(new MobileNumberVerification($code));

        return $this->success('Mobile verification code sent.');
    }

    public function mobileVerification(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:4',
        ]);

        $user = $request->user();
        $code = $request->code;


        $isValidVerification = UserVerification::where([
            'identity' => $user->mobile_number,
            'code' => $code,
            'user_id' => $user->id
        ])
            ->where('expired_at', '>', now()->subMinutes(15)->format('Y-m-d H:i:s'))
            ->exists();

        if ($isValidVerification) {

            $user->update([
                'mobile_verified_at' => now()
            ]);

            UserVerification::where(['user_id' => $user->id])->delete();

            return $this->success('Mobile number verification success.');
        } else {
            return $this->error(['code' => 4003, "message" => 'OTP may expired or invalidated.']);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->success('You are successfully logged out.');
    }

    public function username()
    {
        return 'email';
    }
}
