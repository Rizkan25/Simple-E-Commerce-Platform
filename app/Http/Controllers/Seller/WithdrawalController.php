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
        ]);

        $user = auth()->user();

        // Check if the user has a saved bank account
        if (empty($user->bank_name) || empty($user->bank_account_number) || empty($user->bank_account_name)) {
            return back()->with('error', 'Silakan lengkapi data rekening bank Anda di halaman Profil terlebih dahulu sebelum melakukan penarikan.');
        }

        // Check if the user has enough balance
        if ($user->balance < $request->amount) {
            return back()->with('error', 'Saldo Wallet tidak mencukupi untuk melakukan penarikan.');
        }

        $bankAccountString = $user->bank_name . ' - ' . $user->bank_account_number . ' a/n ' . $user->bank_account_name;

        try {
            // Deduct from wallet immediately to prevent double spending
            $user->withdraw($request->amount, ['description' => 'Penarikan dana ke rekening: ' . $bankAccountString]);

            // Create the withdrawal record
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'bank_account' => $bankAccountString,
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
