<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'admin' => \App\Http\Middleware\Admin::class,
		'adminOrSelfProfile' => \App\Http\Middleware\AdminOrSelfProfile::class,
		'adminOrSelfApplic' => \App\Http\Middleware\AdminOrSelfApplic::class,
		'student' => \App\Http\Middleware\Student::class,
		'mentor' => \App\Http\Middleware\Mentor::class,	
		'collage_mentor' => \App\Http\Middleware\CollageMentor::class,
		'collage_mentor_or_student' => \App\Http\Middleware\CollageMentorOrStudent::class,
		'profile_view' => \App\Http\Middleware\ProfileView::class,	
		'user_internships' => \App\Http\Middleware\UserInternships::class,	
		'company_profile' => \App\Http\Middleware\CompanyProfile::class,
		'company_internships' => \App\Http\Middleware\CompanyInternships::class,
		'competition_active' => \App\Http\Middleware\CompetitionActive::class,
	];
}
