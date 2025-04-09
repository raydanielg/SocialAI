<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Models\BrandAudience;
use App\Models\BrandIdentity;
use App\Models\BrandSlogan;
use App\Models\BrandStrategy;
use App\Models\BrandVoice;
use App\Models\Category;
use App\Services\BrandAi;
use App\Traits\Uploader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BrandController extends Controller
{
    use Uploader;


    public function index()
    {
        $brands = Brand::query()->where('user_id', Auth::id())
            ->filterOn(['name'])->latest()->paginate();
        return Inertia::render('User/Brand/Index', [
            'brands' => $brands
        ]);
    }
    public function show($uuid)
    {
        $brand = Brand::query()->where('uuid', $uuid)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return Inertia::render('User/Brand/Show', [
            'brand' => $brand
        ]);
    }

    public function share($uuid)
    {
        $brand = Brand::query()->where('uuid', $uuid)
            ->select('id', 'uuid', 'name', 'identities', 'audiences', 'strategy', 'voices', 'color', 'slogan', 'logo')
            ->firstOrFail();

        return Inertia::render('User/Brand/Share', [
            'brand' => $brand,
        ]);
    }

    public function create()
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();
        $user->validatePlan('brands');

        $categories = Category::query()->where('type', 'brand')->get();
        return Inertia::render('User/Brand/Create', [
            'categories' => $categories,
        ]);
    }


    public function store(Request $request, StoreBrandRequest $storeBrandRequest)
    {
        $storeBrandRequest->validated();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (env('DEMO_MODE') && $user->id == 3) {
            return back()->with('danger', __('Permission disabled for demo mode..! Create new account to use this feature.'));
        }
        $user->validatePlan('brands');

        $categories = Category::query()
            ->whereIn('id', $request->form['categories'])
            ->get();

        $hasStockContent = $user->plan_data['stock_content'] ?? false;

        $getRandomRecord = function ($query) use ($categories) {
            $categoryIds = $categories->pluck('id')->toArray();
            return $query->whereIn('category_id', $categoryIds)
                ->inRandomOrder()
                ->firstOrFail();
        };
        $logo = url('/assets/images/brand.png');
        if ($hasStockContent) {
            $slogan = $getRandomRecord(BrandSlogan::query())?->title;
            $identityRecord = $getRandomRecord(BrandIdentity::query());
            $identities = [
                'mission' => $identityRecord->mission,
                'vision' => $identityRecord->vision,
                'values' => $identityRecord->values,
            ];
            $audiences = $getRandomRecord(BrandAudience::query())->segments;
            $voiceRecord = $getRandomRecord(BrandVoice::query());
            $voices = [
                'message' => $voiceRecord->message,
                'tones' => $voiceRecord->tones,
            ];
            $strategy = $getRandomRecord(BrandStrategy::query())?->body;
        } else {
            $brandData = [
                'name' => $request->form['name'],
                'description' => $request->form['description'],
            ];

            $brandAi = new BrandAi($categories->pluck('title')->toArray(), $request->form['description'], $brandData);

            try {
                $brandAi->checkCredits();
            } catch (Exception $e) {
                return back()->withErrors(['e' => $e->getMessage()]);
            }

            $voices = $brandAi->voices();
            $identities = $brandAi->identities();
            $audiences = $brandAi->audiences();
            $slogan = $brandAi->slogan();
            $strategy = $brandAi->strategy();
        }

        if (request('actions.isBase64')) {
            $logo = $this->saveFileFromUrl($request->form['logo'], '.png');
        }
        if ($request->hasFile('form.logo') && !env('DEMO_MODE')) {
            $logo = $this->saveFile($request, 'form.logo');
        }

        $colors = [];
        if (empty($request->form['colors'])) {
            $colors = [
                'primary' => fake()->hexColor,
                'secondary' => fake()->hexColor,
            ];
        } else {
            $colors = $request->form['colors'];
        }

        $brand = Brand::create([
            'user_id' => Auth::id(),
            'name' => $request->form['name'],
            'logo' => $logo,
            'slogan' => $slogan,
            'color' => $colors,
            'description' => $request->form['description'],
            'identities' => $identities,
            'audiences' => $audiences,
            'strategy' => $strategy,
            'voices' => $voices,
        ]);

        $brand->categories()->attach($request->form['categories']);

        sleep(2);

        return redirect()->route('user.brand.show', $brand->uuid);
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        $brand->update($request->validated());

        return back()->with('success', 'Updated successfully');
    }
}
