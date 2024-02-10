<?php


namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client; 

class UserController extends ApiController
{
    use AuthenticatesUsers;

    public function getUser()
    {
        $user = Auth::user();

        $user->avatar = asset("storage/{$user->avatar}");

        if (is_null($user->cart)) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $user->cart()->save($cart);
        }
        return $this->success(null, ['User' => $user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191',
            'avatar' => 'nullable|mimes:jpg,jpeg,png|',
        ]);

        $user = $request->user();
        $value = $request->all();

        if ($request->hasFile('avatar')) {
            if (file_exists(storage_path('app/' . $user->avatar))) {
                @unlink(storage_path('app/' . $user->avatar));
            }
            $path = \Storage::disk('public')->putFile('avatars', $request->file('avatar'));

            $value['avatar'] = $path;
        }
        $user->update($value);
        //$user->avatar =  \Storage::url($user->avatar);
        $user->avatar = asset("storage/{$user->avatar}");
        return $this->success('You are successfully Updated.', ['User' => $user]);
    }
    
    
    
        //edsa user agent verification

    public function setEdsaPasswordOTP(Request $request)
    {
        $user = $request->user();
        $digits = 4;
        $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $user->current_otp = $otp;
        $user->save();
        $this->sendOtp($user->mobile_number,$otp);
        return $this->success("Success", ["otp"=>$otp]);
    }


    public function sendOtp($mobile_numbder,$otp) {

            $sid    = "AC9eda758cc3815e5556dee39249ea5b47"; 
            $token  = "4f210e5297b9b957bc8e5171a0688cd5"; 
            $twilio_number = "+16185981277";

            try{
                $twilio = new Client($sid, $token); 
            
            $message = $twilio->messages->create($mobile_numbder, 
                                    [
                                        "messagingServiceSid" => "MGf47f8fe0c13f84488d726cdea4625dd7",      
                                        "body" => "Seven Eleven EDSA set Password OTP: ".$otp 
                                    ]); 
                
                dd("SMS Sent");
                return;
            }catch(Exception $e){
                dd("Error ".$e);
            }
            
            
            return $message->sid;

    }


    public function checkUserOtp(Request $request)
    {
        $user =  $request->user();
        $mob_otp = $request->otp;
        $current_otp = $user->current_otp;
        if($mob_otp == $current_otp)
        {
            return $this->success("Success", ['verification' => "Success" ]);
        }else{
            return $this->success("Success", ['verification' => "Failed" ]);
        }
    }


    public function setEdsaPassword(Request $request)
    {
        $user = $request->user();
        $edsa_four_digit_password = $request->password;
        $user->is_edsa_password_set = 1;
        $user->edsa_password = $edsa_four_digit_password;
        $user->save();

        return $this->success("Success", ['message' => "Password set Successfully"]);

    }


    public function verifyEdsaPassword(Request $request)
    {
        $user = $request->user();
        $edsa_set_password = $user->edsa_password;
        $password = $request->password;

        if($password == $edsa_set_password)
        {
            return $this->success("Success", ['verification' => "Success" ]);
        }else {
            return $this->success("Success", ['verification' => "Falied" ]);
        }
    }
}
