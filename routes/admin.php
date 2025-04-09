<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as ADMIN;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {

	Route::resource('plan', ADMIN\PlanController::class);
	Route::resource('role', ADMIN\RoleController::class);
	Route::resource('admin', ADMIN\AdminController::class);
	Route::resource('order', ADMIN\OrderController::class);
	Route::resource('customer', ADMIN\CustomerController::class);
	Route::resource('gateways', ADMIN\GatewayController::class);
	Route::resource('cron-job', ADMIN\CronjobController::class);
	Route::resource('page', ADMIN\PageController::class);
	Route::resource('blog', ADMIN\BlogController::class);
	Route::resource('category', ADMIN\CategoryController::class);
	Route::resource('faq-category', ADMIN\FaqCategoryController::class);
	Route::resource('job', ADMIN\JobController::class)->except(['edit']);

	Route::resource('tag', ADMIN\TagController::class);
	Route::resource('language', ADMIN\LanguageController::class);
	Route::resource('ai-language', ADMIN\AiLanguageController::class);
	Route::resource('menu', ADMIN\MenuController::class);
	Route::patch('/menu-data/{id}', [ADMIN\MenuController::class, 'updateData'])->name('menu.data.update');

	Route::get('customize-page-settings', [ADMIN\SettingsController::class, 'index'])->name('page-settings.index');
	Route::post('customize-page-settings/{id}', [ADMIN\SettingsController::class, 'update'])->name('page-settings.update');

	Route::resource('seo', ADMIN\SeoController::class);
	Route::resource('support', ADMIN\SupportController::class);
	Route::resource('notification', ADMIN\NotifyController::class);

	Route::resource('testimonials', ADMIN\TestimonialsController::class);
	Route::resource('faq', ADMIN\FaqController::class);
	Route::resource('team', ADMIN\TeamController::class);
	Route::resource('message-transactions', ADMIN\TransactionController::class);
	Route::resource('developer-settings/update', ADMIN\UpdateController::class)->names('update');
	Route::resource('developer-settings', ADMIN\DeveloperSettingsController::class);
	Route::resource('partner', ADMIN\PartnerController::class);

	Route::get('dashboard', [ADMIN\DashboardController::class, 'index'])->name('dashboard');
	Route::post('/language/addkey', [ADMIN\LanguageController::class, 'addKey']);
	Route::post('/menu-update/{id}', [ADMIN\MenuController::class, 'storeDate'])->name('menu.content.update');
	Route::get('profile', [ADMIN\ProfileController::class, 'settings'])->name('profile.setting');
	Route::put('profile/update/{type}', [ADMIN\ProfileController::class, 'update'])->name('profile.update');
	Route::put('/option-update/{key}', [ADMIN\OptionController::class, 'update'])->name('option.update');
	Route::get('dashboard-static-data', [ADMIN\DashboardController::class, 'dashboardData'])->name('dashboard.static');
	Route::get('/wa-server-status', [ADMIN\DashboardController::class, 'waServerStatus']);
	Route::get('/sales-overview', [ADMIN\DashboardController::class, 'salesOverView']);

	Route::resource('ai-templates', ADMIN\AiTemplateController::class);
	Route::resource('integrations', ADMIN\IntegrationController::class);

	Route::resource('service-categories', ADMIN\ServiceCategoryController::class);
	Route::resource('services', ADMIN\ServiceController::class);

	Route::resource('project-categories', ADMIN\ProjectCategoryController::class);
	Route::resource('projects', ADMIN\ProjectController::class);

	Route::resource('jobs', ADMIN\JobController::class);

	// ai brand
	Route::apiResource('brand-categories', ADMIN\BrandCategoryController::class);
	Route::apiResource('brand-slogans', ADMIN\BrandSloganController::class);
	Route::resource('brand-logos', ADMIN\BrandLogoController::class);
	Route::apiResource('brand-identities', ADMIN\BrandIdentityController::class);
	Route::apiResource('brand-audiences', ADMIN\BrandAudienceController::class);
	Route::apiResource('brand-strategies', ADMIN\BrandStrategyController::class);
	Route::apiResource('brand-voices', ADMIN\BrandVoiceController::class);

	Route::resource('credit-logs', ADMIN\CreditController::class)->only(['index', 'update']);
	Route::put('update-credit-fee', [ADMIN\CreditController::class, 'updateCreditFee'])->name('update-credit-fee');
	Route::get('ai-generated-history', [ADMIN\GeneratedHistoryController::class, 'index'])->name('ai-generated-history');
	Route::resource('design', ADMIN\DesignController::class);
	Route::resource('prompts', ADMIN\PromptController::class);

	Route::resource('users', ADMIN\UserController::class)->only([
		'index',
		'show',
		'update',
		'destroy',
	]);

	// User Logs
	Route::prefix('user-logs')->as('user-logs.')->group(function () {
		Route::resource('brands', ADMIN\UserLogs\BrandController::class)->only('index', 'destroy');
		Route::resource('brand-posts', ADMIN\UserLogs\BrandPostController::class)->only('index', 'destroy');
		Route::resource('assets', ADMIN\UserLogs\AssetController::class)->only('index', 'destroy');
		Route::resource('platforms', ADMIN\UserLogs\PlatformController::class)->only('index', 'destroy');
	});

	Route::get('clear-cache', [ADMIN\SystemController::class, 'clearCache'])->name('clear-cache');

	// sidebar menu
	Route::resource('sidebar-menu', ADMIN\SidebarMenuController::class)
		->except(['show', 'destroy']);
	Route::get('sidebar-menu/{id}/{location}', [ADMIN\SidebarMenuController::class, 'show'])
		->name('sidebar-menu.show');
	Route::delete('sidebar-menu/{id}/{location}', [ADMIN\SidebarMenuController::class, 'destroy'])
		->name('sidebar-menu.destroy');
	Route::patch('sidebar-menu-arrange/{location}', [ADMIN\SidebarMenuController::class, 'arrange'])
		->name('sidebar-menu.arrange');
	Route::patch('/sidebar-menu-data/{id}', [ADMIN\SidebarMenuController::class, 'updateData'])
		->name('sidebar-menu.data.update');


	Route::resource('module-developer-settings', ADMIN\ModuleDeveloperSettingsController::class);
	Route::post('module-settings-check-update/{id}', [ADMIN\ModuleDeveloperSettingsController::class, 'updateModulesCheck'])
		->name('module-settings-check-update');
	Route::get(
		'module-developer-settings-version/{id}',
		[ADMIN\ModuleDeveloperSettingsController::class, 'versionView']
	)->name('module-settings-check-version');
	Route::post('module-settings-change-status', [ADMIN\ModuleDeveloperSettingsController::class, 'changeStatus'])
		->name('module-settings-change-status');
});
