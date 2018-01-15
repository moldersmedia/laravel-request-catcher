<?php namespace MoldersMedia\RequestCatcher\Catcher\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use MoldersMedia\RequestCatcher\Catcher\Repositories\EloquentRequestCatcherRepository;
use GuzzleHttp\Client;

/**
 * Class RequestCatchController
 * @package App\Http\Controllers\Development
 */
class RequestCatcherController extends Controller
{
    /**
     * @var EloquentRequestCatcherRepository
     */
    private $repository;
    /**
     * @var Client
     */
    private $guzzle;

    /**
     * RequestCatchController constructor.
     * @param EloquentRequestCatcherRepository $repository
     * @param Client $client
     */
    public function __construct(EloquentRequestCatcherRepository $repository, Client $client)
    {
        $this->repository = $repository;
        $this->guzzle     = $client;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $requests = $this->repository->paginate(config('request-catcher.interface.per_page'));

        return view('request-catcher::index', compact('requests'));
    }

    public function show($requestId)
    {
        $request = $this->repository->getFullDetailedRequest($requestId);

        $requests = $request->paths;

        return view('request-catcher::show', compact('requests', 'request'));
    }

    /**
     * @param $requestId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend($requestId)
    {
        $request = $this->repository->getRequestById($requestId);

        try {
            $headers = array_merge([
                'X-Request-Catcher-Id' => $request->id,
                'Content-Type'         => 'application/x-www-form-urlencoded'
            ], $request->headers);

            $this->guzzle->post($request->url, [
                'headers'     => $headers,
                'form_params' => $request->input
            ]);

            $this->repository->markAsSuccessful($request);
        } catch (\Exception $e) {

            return redirect()
                ->route('request-catcher.requests.index')
                ->header('X-Request-Catcher-Parent-Id', $request->id)
                ->with('message', $e->getMessage())
                ->with('alert', 'danger');
        }

        return redirect()->route('request-catcher.requests.index')
            ->header('X-Request-Catcher-Parent-Id', $request->id)
            ->with('message', 'Request finished!')
            ->with('alert', 'success');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAll()
    {
        $this->repository->deleteAll();

        return redirect()->route('request-catcher.requests.index')
            ->with('message', 'Requests deleted!')
            ->with('alert', 'success');
    }
}