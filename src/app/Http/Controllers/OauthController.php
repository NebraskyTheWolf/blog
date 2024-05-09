<?php

namespace App\Http\Controllers;

use Exception;
use Fluffici\SDK\Auth\Authorize;
use Fluffici\SDK\AuthSDK;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class OauthController extends Controller
{

    public array $allowed = [
        'fluffici.eu'
    ];

    /**
     * @var Guard|SessionGuard
     */
    protected $guard;

    private Authorize $authSDK;

    /**
     * Vytvoření nové instance řadiče.
     * @throws Exception
     */
    public function __construct(Factory $auth)
    {
        $this->guard = $auth->guard('web');

        $this->middleware('guest', [
            'except' => [
                'logout',
                'switchLogout',
            ],
        ]);

        $authSDK = new AuthSDK();
        $authSDK->setGrantType('user_direct');
        $authSDK->setClientId(env('AUTH_CLIENT_ID'));
        $authSDK->setClientSecret(env('AUTH_CLIENT_SECRET'));
        $authSDK->setRedirectUri(env('AUTH_REDIRECT_URI'));
        $authSDK->setState(Uuid::uuid4()->toString());
        $authSDK->setScope('shop:delegated:all');
        $this->authSDK = $authSDK->build();
    }

    public function login(Request $request): RedirectResponse
    {
        return redirect($this->authSDK->getAuthURL());
    }

    /**
     * Handles the OAuth flow for user authentication.
     *
     * @param Request $request The HTTP request object containing the OAuth parameters.
     *                      otherwise returns null if the authentication is successful.
     * @throws Exception
     */
    public function oauth(Request $request): Response|RedirectResponse
    {
        $errorResponse = $this->handleOAuthErrors($request);
        if ($errorResponse) return $errorResponse;

        $invalidAuthCodeOrState = $this->validateAuthorizationCodeState($request);
        if ($invalidAuthCodeOrState) return $invalidAuthCodeOrState;

        $user = $this->validateAndFetchUser($request);

        $this->guard->login($user, true);

        $request->session()->regenerate();

        return $request->wantsJson()
            ? $this->displayError(204, 'Malformed authentication request.')
            : response()->view('layouts.logged', [
                'name' => $user->name
            ]);
    }

    /**
     * Handles OAuth errors.
     *
     * @param mixed $request The request object that contains the OAuth error information.
     * @return ?RedirectResponse Returns a Response object if an OAuth error occurred,
     *                      otherwise returns null if no error occurred.
     */
    private function handleOAuthErrors(mixed $request): ?RedirectResponse
    {
        $error = $request->query('error') ?? null;
        $errorMessage = $request->query('error_message') ?? null;
        return !empty($error) ? $this->displayError(403, $errorMessage) : null;
    }

    /**
     * Validates the authorization code state.
     *
     * @param Request $request The request object containing the authorization code and state.
     * @return ?RedirectResponse Returns a Response object if the authorization code or state is missing,
     *                      or if the server state does not match the session state.
     *                      Returns null if the authorization code state is valid.
     */
    private function validateAuthorizationCodeState(Request $request): ?RedirectResponse
    {
        $code = $request->query('code');
        $state = $request->query('state');
        if (empty($code) || empty($state)) return $this->displayError(403, 'The authorization code is missing.');
        $currentState = $request->session()->get('state', $state);

        return ($state !== $currentState) ? $this->displayError(401, 'The server state does not match the session state.') : null;
    }

    /**
     * Validates a user request, fetches the user, and returns the user model.
     *
     * @param Request $request The request object containing the code parameter.
     *
     * @return User The user model found from the fetched user ID.
     * @throws Exception When the provided user ID is not an integer.
     */
    private function validateAndFetchUser(Request $request): User
    {
        $code = $request->query('code');
        $authorize = $this->authSDK->authorize($code);
        // Useless
        //if (!is_int($authorize->getResult())) $this->displayError(403, 'UserId should be an integer. Got ' . gettype($authorize->getResult()));
        return User::find($authorize->getResult());
    }

    public function displayError($code, $message): RedirectResponse
    {
        return redirect()->route('news', [
            'message' => $message,
            'code' => $code
        ])->with('flash.error', $message);
    }
}
