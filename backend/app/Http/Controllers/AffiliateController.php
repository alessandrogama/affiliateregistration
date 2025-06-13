<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\AffiliateReferral;
use Illuminate\Support\Facades\DB;

class AffiliateController extends Controller
{
    public function index()
    {
        return Affiliate::with(['referrals.referrer'])->get();
    }

    public function show($id)
    {
        return Affiliate::with(['referrals.referrer'])->findOrFail($id);
    }

    public function store(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:affiliates',
            'nickname' => 'nullable|string',
            'email' => 'required|email|unique:affiliates',
            'base_percentage' => 'required|numeric|min:0|max:100',
            'referrers' => 'array',
            'referrers.*.referrer_identifier' => 'required|exists:affiliates,id',
            'referrers.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {
            $affiliate = Affiliate::create([
                'username' => $request->username,
                'nickname' => $request->nickname,
                'email' => $request->email,
                'base_percentage' => $request->base_percentage,
            ]);

            foreach ($request->referrers as $ref) {
                AffiliateReferral::create([
                    'affiliate_id' => $affiliate->id,
                    'referrer_identifier' => $ref['referrer_identifier'],
                    'percentage' => $ref['percentage'],
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Afiliado criado com sucesso.', 'affiliate' => $affiliate], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao criar afiliado.', 'details' => $e->getMessage()], 500);
        }
    }
}
