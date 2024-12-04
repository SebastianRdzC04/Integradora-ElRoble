<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use ReCaptcha\ReCaptcha;

class RegisterUserController extends Controller
{
    public function create($phoneoremail)
    {
        return view('pages.sesion.user_register', compact('phoneoremail'));
    }


    // aqui se procesa la edad y el birthdate para que no se repite codigo 
    protected function validateAndProcessBirthdate($data)
    {
        $day = $data['day'];
        $month = $data['month'];
        $year = $data['year'];
    
        if (!checkdate($month, $day, $year)) {
            return redirect()->back()->withErrors(['birthdate' => 'La fecha de nacimiento ingresada no es válida.'])
                                   ->with('error', 'Hubo un problema con la fecha de nacimiento');
        }
    
        $birthdate = Carbon::createFromDate($year, $month, $day);
        $data['birthdate'] = $birthdate;
        $age = $birthdate->age;
    
        if ($age < 18) {
            return redirect()->back()->withErrors(['birthdate' => 'Debes tener al menos 18 años para registrarte'])
                                   ->with('error', 'Eres menor de 18');
        }
    
        return $data;  
    }

    public function store(Request $request)
    {
        $validateperson = $request->validate([
            'day' => 'required|integer|min:1|max:31',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            'email' => 'required|string|max:70',
            'recaptcha_token' => 'required',
        ]);

        $recaptcha = new ReCaptcha(config('services.recaptcha.secret_key'));

        $response = $recaptcha->verify($request->input('recaptcha_token'), $request->ip());

        if (!$response->isSuccess()) {
            return back()->withErrors(['recaptcha' => 'La verificación de reCAPTCHA falló.']);
        }

        $validateperson = $this->validateAndProcessBirthdate($validateperson);

    if ($validateperson instanceof RedirectResponse) {
        return $validateperson;
    }

        $validateduser = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validateperson, $validateduser) {
            $person = Person::create($validateperson);

            $user = User::create([
                'person_id' => $person->id,
                'email' => $validateduser['email'],
                'password' => Hash::make($validateduser['password']),
            ]);

            $role = Rol::where('name', 'user')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        
            Auth::login($user);
            
            
            $user->sendEmailVerificationNotification();
            
        });
        

        return redirect()->route('verification.notice');
    }

    public function storeUserGoogle(Request $request)
{
    //estos son los datos que socialite me regreso de google en el LoginController esta la asignacion de esa session
    $user = session('user');

    $validatedData = $request->validate([
        'day' => 'required|integer|min:1|max:31',
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:1900|max:' . date('Y'),
        'gender' => 'required|in:Masculino,Femenino,Otro',
        'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
    ]);

    
    $validatedData = $this->validateAndProcessBirthdate($validatedData);

    if ($validatedData instanceof RedirectResponse) {
        return $validatedData;
    }

    $userExist = User::where('external_id', $user->id)
                    ->where('external_auth', 'google')
                    ->first();

    if ($userExist) {
        Auth::login($userExist);
        session()->forget('user');
        return redirect()->intended(RouteServiceProvider::HOME);
    } else {
        DB::transaction(function () use ($user, $validatedData) {
            $personNew = Person::create([
                'first_name' => $user->user['given_name'],
                'last_name' => $user->user['family_name'],
                'gender' => $validatedData['gender'],
                'phone' => $validatedData['phone'],
                'birthdate' => $validatedData['birthdate'],
            ]);


            $userNew = User::create([
                'email' => $user->email,
                'avatar' => $user->avatar,
                'external_id' => $user->id,
                'external_auth' => 'google',
                'person_id' => $personNew->id,
                'email_verified_at' => Carbon::now(),
            ]);

            // oara asignar el rol
            $role = Rol::where('name', 'user')->first();
            if ($role) {
                $userNew->roles()->attach($role->id);
            }

            Auth::login($userNew);
            session()->forget('user');

        });

    }
    session()->forget('user');
    return redirect()->intended(RouteServiceProvider::HOME);
}

    

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        // Aquí puedes buscar al usuario en tu base de datos o crear uno nuevo
        $existingUser = User::where('facebook_id', $user->getId())->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'facebook_id' => $user->getId(),
                'avatar' => $user->getAvatar(),
            ]);
            Auth::login($newUser, true);
        }

        return redirect()->route('home');  // Redirige a la página principal o donde desees
    }

}
