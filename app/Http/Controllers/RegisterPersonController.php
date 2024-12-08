<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\User;


class RegisterPersonController extends Controller
{
    public function create()
    {
        return view('pages.people.person_register');
        
    }

    public function validateData(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            'age' => 'required|integer|min:0|max:120',
        ]);
        
        session()->put('person_data', $request->except('_token'));
        
        $personData = session()->get('person_data');

        if (!$personData) {
            return redirect()->route('registerperson.create')->withErrors('Por favor complete sus datos personales.');
        }

        return redirect()->route('registeruser.create');
    }

    public function edit($id)
    {
        $person = Person::find($id);
        return view('pages.people.person_edit',compact('person'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'firstName' => 'string|max:50',
        'lastName' => 'string|max:50',
        'birthdate' => 'date',
        'gender' => 'in:Masculino,Femenino,Otro',
        'phone' => 'string|size:10|regex:/^[0-9]+$/',
    ]);

    $person = Person::find($id);

    if (!$person) {
        return redirect()->back()->withErrors('Usuario no encontrado');
    }

    $person->firstName = $request->input('firstName');
    $person->lastName = $request->input('lastName');
    $person->birthdate = $request->input('birthdate');
    $person->gender = $request->input('gender');
    $person->phone = $request->input('phone');

    $person->save();

    return redirect()->route('tablepeople.index', ['id' => $person->id])
                     ->with('success', 'Registro actualizado correctamente')
                     ->with('person', $person);
}

    public function index()
    {
        $people = Person::all();
        return view('pages.people.person_list',compact('people'));
    }

    public function destroy($id)
    {
        $person = Person::find($id);
        Person::destroy($id);

        return redirect()->route('tablepeople.index')
                     ->with('success', 'Registro eliminado correctamente')
                     ->with('person', $person);

    }

}
