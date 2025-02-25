<?php

namespace App\Actions\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Constants\OTP;
use App\Constants\Role;
use App\Jobs\SendOtpSms;
use App\Models\Property;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Traits\GenerateOTP;
use App\Libraries\Traits\SessionTrait;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Validation\ValidationException;

class OTPForLoginAction
{
    use GenerateOTP;

    private $_data;
    private $_user;

    public function handle(array $data)
    {
        $this->_data = $data;
        if (!$property = $this->getRegisteredProperty()) {
            throw ValidationException::withMessages([
                'name' => 'ތިޔަ ހޯއްދަވާ ރެކޯރޑެއް ނުފެނުނު'
            ]);
        }

        $this->requestOTP($property);
        $this->_user->setAttribute(
            'property_id',
            $property->id
        );

        return $this->_user;
    }

    private function requestOTP($property): static
    {

        $otp = $this->setOTP()->getOTP();
        $this->_user = User::firstOrCreate([
            'contact_no' => $this->_data['contact_no'],
        ], [
            'name' => $property->responsiblePersons[0]->name,
            'contact_no' => $this->_data['contact_no'],
            'role_id' => Role::USER,
            'person_id' => $property->responsiblePersons[0]->id,
        ]);

        $this->_user->otp = Hash::make($otp);
        $this->_user->otp_expires_at = Carbon::now()->addMinutes(5);
        $this->_user->save();

        // dispatch(new SendOtpSms($this->_data['mobile_no'], $otp, $this->_data['app']));

        return $this;
    }

    private function getRegisteredProperty()
    {
        return Property::with(['responsiblePersons' => function ($q) {
            $q->where('contact_no', $this->_data['contact_no']);
        }])
            ->whereHas('responsiblePersons', function ($q) {
                $q->where('contact_no', $this->_data['contact_no']);
            })
            ->where(
                fn($query) =>
                $query->where('name', $this->_data['name'])
                    ->orWhere('registration_code', $this->_data['name'])
            )
            ->first();
    }
}
