<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\User;
use App\Notifications\WithdrawalRequestedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Exception;

class WithdrawalController extends Controller
{
    /**
     * Display the seller's withdrawals and balance.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('seller.withdrawals.index', compact('withdrawals', 'user'));
    }

    /**
     * Store a new withdrawal request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_account' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        // Check if the user has enough balance
        if ($user->balance < $request->amount) {
            return back()->with('error', 'Saldo Wallet tidak mencukupi untuk melakukan penarikan.');
        }

        try {
            // Deduct from wallet immediately to prevent double spending
            $user->withdraw($request->amount, ['description' => 'Penarikan dana ke rekening: ' . $request->bank_account]);

            // Create the withdrawal record
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'bank_account' => $request->bank_account,
                'status' => 'PENDING',
            ]);

            // Notify admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new WithdrawalRequestedNotification($withdrawal));
            }

            return back()->with('success', 'Permintaan penarikan berhasil diajukan dan sedang menunggu persetujuan.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memproses penarikan: ' . $e->getMessage());
        }
    }
}
