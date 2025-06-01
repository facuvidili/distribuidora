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
            'clientesCount' => Cliente::count(),
            'proveedoresCount' => Proveedor::count(),
            'ultimasVentas' => Venta::latest()->limit(5)->get(),
            'user' => Auth::user()
        ]);
    }
}
