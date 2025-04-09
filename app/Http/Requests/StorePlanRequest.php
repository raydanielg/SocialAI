<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'days' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'plan_data.credits.value' => 'required|integer|min:0',
            'plan_data.credits.overview' => 'nullable|string',
            'plan_data.brands.value' => 'required|numeric',
            'plan_data.brands.overview' => 'nullable|string',
            'plan_data.social_accounts.value' => 'required|numeric',
            'plan_data.social_accounts.overview' => 'nullable|string',
            'plan_data.posts.value' => 'required|numeric',
            'plan_data.posts.overview' => 'nullable|string',
            'plan_data.analytics.value' => 'required|boolean',
            'plan_data.analytics.overview' => 'nullable|string',
            'plan_data.stock_library.value' => 'required|boolean',
            'plan_data.stock_library.overview' => 'nullable|string',
            'plan_data.storage_size.value' => 'required|numeric',
            'plan_data.storage_size.overview' => 'nullable|string',
            'plan_data.scheduling.value' => 'required|boolean',
            'plan_data.scheduling.overview' => 'nullable|string',
            'plan_data.image_editor.value' => 'required|boolean',
            'plan_data.image_editor.overview' => 'nullable|string',
            'plan_data.stock_content' => 'nullable|boolean',
            'is_featured' => 'required|boolean',
            'is_recommended' => 'required|boolean',
            'is_trial' => 'required|boolean',
            'status' => 'required|boolean',
            'trial_days' => 'required_if:is_trial,true|integer|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'plan_data.credits.value' => 'Credits',
            'plan_data.credits.overview' => 'Credits Overview',
            'plan_data.brands.value' => 'Brands',
            'plan_data.brands.overview' => 'Brands Overview',
            'plan_data.social_accounts.value' => 'Social Accounts',
            'plan_data.social_accounts.overview' => 'Social Accounts Overview',
            'plan_data.posts.value' => 'Posts',
            'plan_data.posts.overview' => 'Posts Overview',
            'plan_data.analytics.value' => 'Analytics',
            'plan_data.analytics.overview' => 'Analytics Overview',
            'plan_data.stock_library.value' => 'Stock Library',
            'plan_data.stock_library.overview' => 'Stock Library Overview',
            'plan_data.storage_size.value' => 'Storage Size',
            'plan_data.storage_size.overview' => 'Storage Size Overview',
            'plan_data.scheduling.value' => 'Scheduling',
            'plan_data.scheduling.overview' => 'Scheduling Overview',
            'plan_data.image_editor.value' => 'Image Editor',
            'plan_data.image_editor.overview' => 'Image Editor Overview',
            'is_featured' => 'Is Featured',
            'is_recommended' => 'Is Recommended',
            'is_trial' => 'Is Trial',
            'status' => 'Status',
            'trial_days' => 'Trial Days',
            'plan_data.stock_content' => 'Stock Content',
        ];
    }
}
