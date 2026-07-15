<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Afficher les promotions actives
     */
    public function index(Request $request)
    {
        $categories = Promotion::getCategories();
        $selectedCategory = $request->query('category', 'all');

        $query = Promotion::where('is_active', true)
            ->where('status', 'active')
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now());

        if ($selectedCategory !== 'all' && array_key_exists($selectedCategory, $categories)) {
            $query->where('category', $selectedCategory);
        }

        $promotions = $query->get();

        return view('promotions.index', compact('promotions', 'categories', 'selectedCategory'));
    }

    /**
     * Valider un code promo
     */
    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'amount' => 'nullable|numeric|min:0',
        ]);

        $code = $request->input('code');
        $amount = $request->input('amount', 0);

        $promotion = Promotion::where('code', strtoupper($code))->first();

        if (!$promotion) {
            $message = '❌ Code promo invalide';
            if ($request->expectsJson()) {
                return response()->json(['valid' => false, 'message' => $message], 404);
            }
            return redirect()->back()->with('error', $message);
        }

        if (!$promotion->canBeUsed($amount)) {
            $message = '❌ Ce code n\'est pas valable';
            if ($request->expectsJson()) {
                return response()->json(['valid' => false, 'message' => $message], 400);
            }
            return redirect()->back()->with('error', $message);
        }

        $discount = $promotion->calculateDiscount($amount);
        $message = "✅ Code appliqué ! Réduction : " . number_format($discount, 2) . " $";

        if ($request->expectsJson()) {
            return response()->json([
                'valid' => true,
                'promotion_id' => $promotion->id,
                'discount' => $discount,
                'description' => $promotion->description,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Admin: créer une promotion
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:promotions',
            'description' => 'required|string',
            'type' => 'required|in:percentage,fixed_amount,free_service',
            'category' => 'required|in:general,black_friday,weekend,student',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'minimum_amount' => 'nullable|numeric|min:0',
        ]);

        Promotion::create([
            'code' => strtoupper($request->input('code')),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'category' => $request->input('category'),
            'value' => $request->input('value'),
            'usage_limit' => $request->input('usage_limit'),
            'valid_from' => $request->input('valid_from'),
            'valid_until' => $request->input('valid_until'),
            'minimum_amount' => $request->input('minimum_amount'),
            'is_active' => true,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', '✅ Promotion créée !');
    }

    /**
     * Admin: liste des promotions
     */
    public function adminIndex()
    {
        $promotions = Promotion::latest()->paginate(20);
        return view('promotions.admin-index', compact('promotions'));
    }

    /**
     * Admin: formulaire de modification d'une promotion
     */
    public function edit(Promotion $promotion)
    {
        return view('promotions.edit', compact('promotion'));
    }

    /**
     * Admin: modifier une promotion
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'code' => 'required|string|unique:promotions,code,' . $promotion->id,
            'description' => 'required|string',
            'type' => 'required|in:percentage,fixed_amount,free_service',
            'category' => 'required|in:general,black_friday,weekend,student',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,draft',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'minimum_amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $promotionData = [
            'code' => strtoupper($request->input('code')),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'category' => $request->input('category'),
            'value' => $request->input('value'),
            'status' => $request->input('status'),
            'valid_from' => $request->input('valid_from'),
            'valid_until' => $request->input('valid_until'),
        ];

        if ($request->has('usage_limit')) {
            $promotionData['usage_limit'] = $request->input('usage_limit');
        }

        if ($request->has('minimum_amount')) {
            $promotionData['minimum_amount'] = $request->input('minimum_amount');
        }

        if ($request->has('is_active')) {
            $promotionData['is_active'] = $request->boolean('is_active');
        }

        $promotion->update($promotionData);

        return redirect()->route('admin.promotions.index')->with('success', 'Modification effectuée avec succès.');
    }

    /**
     * Admin: supprimer une promotion
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->back()->with('success', '✅ Promotion supprimée !');
    }

    public function create()
    {
        return view('promotions.create');
    }
}


