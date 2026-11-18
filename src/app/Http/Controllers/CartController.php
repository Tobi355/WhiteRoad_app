<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->resolveCart();

        return view('cart.index', compact('cart'));
    }

    public function add(Servicio $servicio)
    {
        $cart = $this->resolveCart();

        if (isset($cart[$servicio->id])) {
            $cart[$servicio->id]['quantity']++;
        } else {
            $cart[$servicio->id] = [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'precio' => $servicio->precio,
                'imagen' => $servicio->imagen,
                'quantity' => 1,
            ];
        }

        $this->persistCart($cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Servicio agregado al carrito.');
    }

    public function update(Request $request, int $id)
    {
        $cart = $this->resolveCart();

        if (! isset($cart[$id])) {
            return back()->with('error', 'El servicio no está en el carrito.');
        }

        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            unset($cart[$id]);
            $this->persistCart($cart);

            return back()->with('success', 'Servicio eliminado del carrito.');
        }

        $cart[$id]['quantity'] = $quantity;
        $this->persistCart($cart);

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function remove(int $id)
    {
        $cart = $this->resolveCart();
        unset($cart[$id]);
        $this->persistCart($cart);

        return back()->with('success', 'Servicio eliminado.');
    }

    public function clear()
    {
        session()->forget('cart');
        $this->persistCart([]);

        return back()->with('success', 'Carrito vaciado.');
    }

    private function resolveCart(): array
    {
        $cart = session()->get('cart', []);

        if (empty($cart) && Auth::check()) {
            $cart = Auth::user()->cart ?? [];
            session()->put('cart', $cart);
        }

        return is_array($cart) ? $cart : [];
    }

    private function persistCart(array $cart): void
    {
        session()->put('cart', $cart);

        if (Auth::check()) {
            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                $user->cart = $cart;
                $user->save();
            }
        }
    }
}
