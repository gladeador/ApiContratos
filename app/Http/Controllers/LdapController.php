<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use App\Models\User;

class LdapController extends Controller
{
    public function index()
    {
        return view('ldap.connect');
    }

    public function connect(Request $request)
    {
        try {
            // Intentar conexión LDAP
            $ad = Adldap::connect();

            // Mostrar mensaje de éxito con SweetAlert
            return redirect()->route('ldap.index')->with('success', 'Conexión exitosa!');
        } catch (\Exception $e) {
            // Mostrar mensaje de error con SweetAlert
            return redirect()->route('ldap.index')->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

    public function transferView()
    {
        return view('ldap.transfer');
    }

    public function transferUsers(Request $request)
    {
        // Obtener datos de la OU
        $ou = $request->input('ou');

        // Obtener usuarios de la OU desde LDAP
        $ldapUsers = Adldap::search()->where('objectclass', '=', 'user')->in($ou)->get();

        // Transferir usuarios a la base de datos
        foreach ($ldapUsers as $ldapUser) {
            User::create([
                'name' => $ldapUser->getCommonName(),
                'username' => $ldapUser->getAccountName(),
                'password' => bcrypt($ldapUser->getPassword()),
            ]);
        }

        // Mostrar mensaje de éxito con SweetAlert
        return redirect()->route('ldap.transfer.view')->with('success', 'Usuarios transferidos exitosamente!');
    }
}
