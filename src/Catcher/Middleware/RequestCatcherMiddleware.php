<?php namespace MoldersMedia\RequestCatcher\Catcher\Middleware;

use Illuminate\Cookie\CookieJar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MoldersMedia\RequestCatcher\Catcher\Repositories\EloquentRequestCatcherRepository;
use Symfony\Component\HttpFoundation\Cookie;

class RequestCatcherMiddleware
{
    CONST HEADER_KEY = 'X-Request-Catcher-Id';
    CONST PARENT_SESSION_KEY = 'request_catcher_parent_id';

    /**
     * @var EloquentRequestCatcherRepository
     */
    private $repository;

    /**
     * RequestCatcher constructor.
     * @param EloquentRequestCatcherRepository $repository
     */
    public function __construct(EloquentRequestCatcherRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param \Closure $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, \Closure $next)
    {
        if ($request->session()->has('request_catcher_stop')) {
            return $next($request);
        }

        $ignoreUrl = $this->ignoreRoute($request);

        if ($ignoreUrl) {
            $request->session()->flash('request_catcher_stop', true);

            return $next($request);
        }

        /** @var Response $response */
        $response = $next($request);

        $data = $this->storeRequest($response, $request);

        if (!$request->session()->has(self::PARENT_SESSION_KEY)) {
            $request->session()->flash(self::PARENT_SESSION_KEY, $data->id);
        }

        return $response;
    }

    /**
     * @param $response Response|RedirectResponse
     * @param $request  Request
     * @return \MoldersMedia\RequestCatcher\Catcher\Models\Request
     */
    private function storeRequest($response, $request)
    {
        $status     = $response->getStatusCode();
        $originalId = $request->header('X-Request-Catcher-Id');
        $parentId   = $request->session()->get(self::PARENT_SESSION_KEY);

        return $this->repository->storeRequest($status, $request, $originalId, $parentId);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function ignoreRoute($request)
    {

        try {
            $as = $request->route()->getAction()['as'];

            $allowRoute = in_array($as, config('request-catcher.log.blocked_routes', []));

            if ($allowRoute) {
                return true;
            }

            $urls = config('request-catcher.log.disable_urls', []);
            if (count($urls)) {
                if (!in_array($request->path(), $urls)) {
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}