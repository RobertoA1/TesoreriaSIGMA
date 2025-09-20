<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Personal;
use App\Models\Administrativo;
use App\Models\Familiar;
use App\Helpers\Home\Familiar\FamiliarHeaderComponent;
use App\Helpers\Home\Familiar\FamiliarSidebarComponent;
use App\Helpers\Tables\CRUDTableComponent;
use App\Helpers\ProfilePage;
use App\Helpers\Tables\AdministrativoSidebarComponent;
use App\Helpers\Tables\AdministrativoHeaderComponent;
use App\Helpers\ProfileEditContent;
use App\Helpers\ChangePasswordPage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $tipos = [
            ['id' => 'Personal', 'descripcion' => 'Personal'],
            ['id' => 'Administrativo', 'descripcion' => 'Administrativo'],
            ['id' => 'Familiar', 'descripcion' => 'Familiar'],
        ];

        $data = [
            'return' => route('principal', ['abort' => true]),
            'id' => $user->id_usuario,
            'tipos' => $tipos,
            'default' => [
                'username'   => $user->username,
                'foto_url'   => $user->foto_url,
                'tipo'       => $user->tipo,
                'estado'     => $user->estado
            ]
        ];

        switch (strtolower($user->tipo)) {
            case 'personal':
                $personal = Personal::where('id_usuario', $user->id_usuario)->first();
                if ($personal) {
                    $data['default'] = array_merge($data['default'], [
                        'codigo_personal' => $personal->codigo_personal ?? '',
                        'telefono'   => $user->telefono ?? '',
                        'apellido_paterno' => $personal->apellido_paterno ?? '',
                        'apellido_materno' => $personal->apellido_materno ?? '',
                        'primer_nombre' => $personal->primer_nombre ?? '',
                        'otros_nombres' => $personal->otros_nombres ?? '',
                        'dni' => $personal->dni ?? '',
                        'direccion' => $personal->direccion ?? '',
                        'estado_civil' => $personal->estado_civil ?? '',
                        'seguro_social' => $personal->seguro_social ?? '',
                        'fecha_ingreso' => $personal->fecha_ingreso ?? '',
                        'departamento' => $personal->departamento ?? '',
                        'categoria' => $personal->categoria ?? '',
                        'id_departamento' => $personal->id_departamento ?? ''
                    ]);
                }
                //return view('profile.personal.edit', compact('data', 'personal'));

            case 'administrativo':
                $admin = Administrativo::where('id_usuario', $user->id_usuario)->first();
                if ($admin) {
                    $data['default'] = array_merge($data['default'], [
                        'apellido_paterno' => $admin->apellido_paterno ?? '',
                        'apellido_materno' => $admin->apellido_materno ?? '',
                        'primer_nombre' => $admin->primer_nombre ?? '',
                        'otros_nombres' => $admin->otros_nombres ?? '',
                        'dni' => $admin->dni ?? '',
                        'direccion' => $admin->direccion ?? '',
                        'email'      => $user->email,
                        'estado_civil' => $admin->estado_civil ?? '',
                        'seguro_social' => $admin->seguro_social ?? '',
                        'fecha_ingreso' => $admin->fecha_ingreso ?? '',
                        'cargo' => $admin->cargo ?? '',
                        'telefono'   => $user->telefono ?? '',
                        'sueldo' => $admin->sueldo ?? ''
                    ]);
                }
                //return view('profile.administrativo.edit', compact('data', 'admin'));

            case 'familiar':
                $familiar = Familiar::where('id_usuario', $user->id_usuario)->first();
                if ($familiar) {
                    $data['default'] = array_merge($data['default'], [
                        'dni' => $familiar->dni ?? '',
                        'apellido_paterno' => $familiar->apellido_paterno ?? '',
                        'apellido_materno' => $familiar->apellido_materno ?? '',
                        'primer_nombre' => $familiar->primer_nombre ?? '',
                        'otros_nombres' => $familiar->otros_nombres ?? '',
                        'numero_contacto' => $familiar->numero_contacto ?? '',
                        'correo_electronico' => $familiar->correo_electronico ?? ''
                    ]);

                    $header = new FamiliarHeaderComponent();
                    $header->alumnos = $familiar->alumnos->toArray();
                    
                    $alumnoSesion = session('alumno'); 
                    $header->alumnoSeleccionado = $alumnoSesion;
                    break;
                }
        }


        $content = ProfileEditContent::create($user, $user->tipo, $data);
                
        $page = ProfilePage::new()
            ->title("Editar Perfil - " . ucfirst($user->tipo))
            ->content($content);

        
        // Add sidebar based on user type
        switch (strtolower($user->tipo)) {
            case 'familiar':
                if (isset($alumnoSesion) && $alumnoSesion) {
                    $page->sidebar(new FamiliarSidebarComponent());
                }
                $page->header($header);
                break;
            case 'administrativo':
                $page->header(new AdministrativoHeaderComponent());
                $page->sidebar(new AdministrativoSidebarComponent());
                break;
            case 'personal':
                //$page->sidebar(new PersonalSidebarComponent());
                break;
        }

        return $page->render();
    }

public function editEntry(Request $request)
    {
        $user = auth()->user();
        $baseValidation = [
            'username' => 'required|string|max:50|unique:users,username,' . $user->id_usuario . ',id_usuario',
            'foto'     => 'nullable|image|max:2048',
        ];

        // Add specific validation rules based on user type
        $specificValidation = [];
        switch (strtolower($user->tipo)) {
            case 'personal':
                $specificValidation = [
                    'codigo_personal' => 'nullable|string|max:20',
                    'apellido_paterno' => 'required|string|max:50',
                    'apellido_materno' => 'required|string|max:50',
                    'primer_nombre' => 'required|string|max:50',
                    'otros_nombres' => 'nullable|string|max:100',
                    'dni' => 'required|string|max:20',
                    'direccion' => 'nullable|string|max:200',
                    'estado_civil' => 'nullable|string|max:20',
                    'seguro_social' => 'nullable|string|max:50',
                    'fecha_ingreso' => 'nullable|date',
                    'departamento' => 'nullable|string|max:100',
                    'categoria' => 'nullable|string|max:50',
                    'id_departamento' => 'nullable|integer'
                ];
                break;

            case 'administrativo':
                $specificValidation = [
                    'apellido_paterno' => 'required|string|max:50',
                    'apellido_materno' => 'required|string|max:50',
                    'primer_nombre' => 'required|string|max:50',
                    'otros_nombres' => 'nullable|string|max:100',
                    'dni' => 'required|string|max:20',
                    'direccion' => 'nullable|string|max:200',
                    'estado_civil' => 'nullable|string|max:20',
                    'seguro_social' => 'nullable|string|max:50',
                    'fecha_ingreso' => 'nullable|date',
                    'cargo' => 'nullable|string|max:100',
                    'sueldo' => 'nullable|numeric|min:0'
                ];
                break;

            case 'familiar':
                $specificValidation = [
                    'dni' => 'required|string|max:20',
                    'apellido_paterno' => 'required|string|max:50',
                    'apellido_materno' => 'required|string|max:50',
                    'primer_nombre' => 'required|string|max:50',
                    'otros_nombres' => 'nullable|string|max:100',
                    'numero_contacto' => 'nullable|string|max:20',
                    'correo_electronico' => 'nullable|email|max:100'
                ];
                break;
        }

        $data = $request->validate(array_merge($baseValidation, $specificValidation));

        

        if ($request->hasFile('foto')) {
            if ($user->foto && $user->foto != 'default.jpg') {
                \Storage::disk('public')->delete('users/' . $user->foto);
            }

            $filename = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->storeAs('users', $filename, 'public');
            $data['foto'] = $filename;
            
        }

        $userData = array_intersect_key($data, array_flip(['username', 'email', 'telefono', 'foto']));
        $user->update($userData);

        $specificData = array_diff_key($data, $userData);
        if (!empty($specificData)) {
            switch (strtolower($user->tipo)) {
                case 'personal':
                    $personal = Personal::where('id_usuario', $user->id_usuario)->first();
                    if ($personal) {
                        $personal->update($specificData);
                    } else {
                        $specificData['id_usuario'] = $user->id_usuario;
                        Personal::create($specificData);
                    }
                    break;

                case 'administrativo':
                    $admin = Administrativo::where('id_usuario', $user->id_usuario)->first();
                    if ($admin) {
                        $admin->update($specificData);
                    } else {
                        $specificData['id_usuario'] = $user->id_usuario;
                        Administrativo::create($specificData);
                    }
                    break;

                case 'familiar':
                    $familiar = Familiar::where('id_usuario', $user->id_usuario)->first();
                    if ($familiar) {
                        $familiar->update($specificData);
                    } else {
                        $specificData['id_usuario'] = $user->id_usuario;
                        Familiar::create($specificData);
                    }
                    break;
            }
        }

        return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado correctamente.');
    }


    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('La contraseña actual no es correcta.');
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.mixed_case' => 'La contraseña debe contener mayúsculas y minúsculas.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
            'password.uncompromised' => 'Esta contraseña ha sido comprometida en filtraciones de datos. Por favor, elige otra.',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Log the password change for security
        \Log::info('Password changed for user: ' . $user->username . ' (ID: ' . $user->id_usuario . ')');

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function showPasswordForm()
    {
        $user = Auth::user();
        
        $changePasswordContent = ChangePasswordPage::create(
            $user,
            route('perfil.edit'), // URL de retorno
            session('errors'),
            session('success')
        );

        // Creamos el "esqueleto" de la página igual que en edit()
        $page = ProfilePage::new()
            ->title("Cambiar Contraseña")
            ->content($changePasswordContent);
        $familiar = Familiar::where('id_usuario', $user->id_usuario)->first();
        $alumnoSesion = session('alumno');
        switch (strtolower($user->tipo)) {
            case 'familiar':
                $header = new FamiliarHeaderComponent();
                $header->alumnos = $familiar->alumnos->toArray() ?? [];
                $header->alumnoSeleccionado = $alumnoSesion;

                if ($alumnoSesion) {
                    $page->sidebar(new FamiliarSidebarComponent());
                }
                $page->header($header);
                break;

            case 'administrativo':
                $page->header(new AdministrativoHeaderComponent());
                $page->sidebar(new AdministrativoSidebarComponent());
                break;

            case 'personal':
                // si luego creas un sidebar/header para personal
                break;
        }

        return $page->render();
    }
}
