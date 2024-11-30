<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index(){
        $cards = collect([
            [
                'title' => 'Topup User Wallet',
                'url' => route('admin.wallet.topup.form')
            ],
            [
                'title' => 'Withdraw User Wallet',
                'url' => route('admin.wallet.withdraw.form')
            ]
        ]);
        return view('admin.wallet.index',compact('cards'));
    }

    public function topupForm(){
        $users = User::all();
        return view('admin.wallet.entry',compact('users'));
    }

    public function topupStore(Request $request){
        $user = User::find($request->user_id);
        $amount = (int) $request->amount;
        $currency_symbol = "PKR";
        
        // Add Wallet Balance
        
        // check if the wallet is available
        $wallet = Wallet::where('user_id',$user->id)->where('currency_symbol',$currency_symbol)->first();
        
        if($wallet){
            $wallet->update([
                'amount' => $wallet->amount + $amount
            ]);
        }
        else{
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'currency_symbol' => $currency_symbol
            ]);
        }
        
        // check if admin wallet available
        $admin_user_id = Auth::user()->id;
        $admin_user_name = Auth::user()->name;
        $admin_wallet = Wallet::where('user_id',$admin_user_id)->where('currency_symbol',$currency_symbol)->first();
        
        if($admin_wallet){
            $admin_wallet->update([
                'amount' => $admin_wallet->amount - $amount
            ]);
        }
        else{
            $admin_wallet = Wallet::create([
                'user_id' => $admin_user_id,
                'amount' => $amount * -1,
                'currency_symbol' => $currency_symbol
            ]);
        }

        // Create wallet entry
        $wallet_entry = WalletEntry::create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => 'cr',
            'description' => 'Topup by Admin (UserID: '. $admin_user_id .', Name: '. $admin_user_name .')'
        ]);

        // creeate admin wallet entry
        $admin_wallet_entry = WalletEntry::create([
            'wallet_id' => $admin_wallet->id,
            'amount' => $amount,
            'type' => 'dr',
            'description' => 'Topup for User (UserID: '. $user->id .', Name: '. $user->name .')',
            'transaction_parent_id' => $wallet_entry->id
        ]);
        if($wallet_entry && $admin_wallet_entry){
            return redirect()->back()->banner('User balance topup');
        }
        else{
            return redirect()->back()->dangerBanner('Something went wrong!');
        }

    }

    public function withdrawStore(Request $request){
        $user = User::find($request->user_id);
        $amount = (int) $request->amount;
        $currency_symbol = "PKR";
        
        // Add Wallet Balance
        
        // check if the wallet is available
        $wallet = Wallet::where('user_id',$user->id)->where('currency_symbol',$currency_symbol)->first();
        
        if($wallet){
            $wallet->update([
                'amount' => $wallet->amount - $amount
            ]);
        }
        else{
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'amount' => $amount * -1,
                'currency_symbol' => $currency_symbol
            ]);
        }
        
        // check if admin wallet available
        $admin_user_id = Auth::user()->id;
        $admin_user_name = Auth::user()->name;
        $admin_wallet = Wallet::where('user_id',$admin_user_id)->where('currency_symbol',$currency_symbol)->first();
        
        if($admin_wallet){
            $admin_wallet->update([
                'amount' => $admin_wallet->amount + $amount
            ]);
        }
        else{
            $admin_wallet = Wallet::create([
                'user_id' => $admin_user_id,
                'amount' => $amount,
                'currency_symbol' => $currency_symbol
            ]);
        }

        // Create wallet entry
        $wallet_entry = WalletEntry::create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => 'dr',
            'description' => 'Withdraw by Admin (UserID: '. $admin_user_id .', Name: '. $admin_user_name .')'
        ]);

        // creeate admin wallet entry
        $admin_wallet_entry = WalletEntry::create([
            'wallet_id' => $admin_wallet->id,
            'amount' => $amount,
            'type' => 'cr',
            'description' => 'Withdraw for User (UserID: '. $user->id .', Name: '. $user->name .')',
            'transaction_parent_id' => $wallet_entry->id
        ]);
        if($wallet_entry && $admin_wallet_entry){
            return redirect()->back()->banner('User balance withdraw');
        }
        else{
            return redirect()->back()->dangerBanner('Something went wrong!');
        }

    }

    public function withdrawForm(){
        $users = User::all(); 
        $withdraw = true;
        return view('admin.wallet.entry',compact('users','withdraw'));
    }
}
