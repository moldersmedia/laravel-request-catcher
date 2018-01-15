<?php namespace MoldersMedia\RequestCatcher\Catcher\Repositories;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MoldersMedia\RequestCatcher\Catcher\Models\Request;
use Illuminate\Http\Request as HttpRequest;

/**
 * Class EloquentRequestCatcherRepository
 * @package MoldersMedia\RequestCatcher\Catcher\Repositories
 */
class EloquentRequestCatcherRepository
{
    /**
     * @param $statusCode
     * @param HttpRequest $request
     * @param null $original
     * @param $parentId
     * @return Request
     */
    public function storeRequest($statusCode, HttpRequest $request, $original = null, $parentId = null)
    {
        $data = [
            'status_code' => $statusCode,
            'headers'     => $request->headers->all(),
            'input'       => $request->all(),
            'locale'      => $request->getLocale(),
            'is_secure'   => $request->isSecure(),
            'url'         => $request->url(),
            'method'      => $request->method(),
            'original_id' => $original,
            'parent_id'   => $parentId
        ];

        /** @var Request $request */
        $request = (new Request())->forceFill($data);
        $request->save();

        return $request;
    }

    /**
     * @param $int
     * @return LengthAwarePaginator
     */
    public function paginate($int)
    {
        return (new Request())->newInstance()
            ->withCount('paths as total_paths')
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC')
            ->paginate($int);
    }

    /**
     * @param $requestId
     * @return Request
     * @throws ModelNotFoundException
     */
    public function getRequestById($requestId)
    {
        return (new Request())->findOrFail($requestId);
    }

    /**
     * @param $header
     * @return Request
     */
    public function increment($header)
    {
        $request = (new Request())->find($header);

        if ($header) {
            $request->tries = $request->tries += 1;
            $request->save();
        }

        return $request;
    }

    /**
     * @param Request $request
     * @return Request
     */
    public function markAsSuccessful($request)
    {
        $request->successful_at = Carbon::now();

        $request->save();

        return $request;
    }

    /**
     * @return mixed
     */
    public function deleteAll()
    {
        return (new Request())->truncate();
    }

    /**
     * @param $requestId
     * @return Request
     */
    public function getFullDetailedRequest($requestId)
    {
        return $this->getRequestById($requestId)->load('paths', 'original_request');
    }
}