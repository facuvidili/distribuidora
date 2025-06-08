<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard', [
            'ventasCount' => Venta::count(),
            'clientesCount' => Cliente::where('activo', true)->count(),
            'proveedoresCount' => Proveedor::where('activo', true)->count(),
            'ultimasVentas' => Venta::latest()->limit(5)->get(),
            'balanceGeneral' => Venta::sum('total'),
            'user' => Auth::user()
        ]);
    }
}
