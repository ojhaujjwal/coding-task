<?php

namespace App\Http\Controllers;

use ArrayObject;
use Illuminate\Http\Request;
use App\Http\Requests\StorePersonalDetailsRequest;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Intl\Intl;
use App\Services\PersonalDetailsStorage;
use Pagerfanta\View\TwitterBootstrap3View;

class PersonalDetailsController extends Controller
{
    private function view($view = null, $data = [])
    {
        return view($view, $data, [
            'genders' => \Config::get('constants.personal_details.genders'),
            'contactModes' => \Config::get('constants.personal_details.contact_modes'),
            'countries' => Intl::getRegionBundle()->getCountryNames(\Lang::getLocale()),
        ]);
    }

    /**
     * Show one detail by id.
     *
     * @param  int  $id
     * @param PersonalDetailsStorage $storage
     *
     * @return Response
     */
    public function showDetail(PersonalDetailsStorage $storage, $id)
    {
        $record = $storage->get($id);
        \Log::info('Showing personal details record: ' . $record['id']);
        return $this->view('personal_details.view', ['personalDetails' => $record]);
    }

    /**
     * Show the paginated list.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAll(Request $request)
    {
        /** @var \Pagerfanta\Pagerfanta $pagerfanta */
        $pagerfanta = \App::make('PersonalDetails\Pagerfanta');
        $pagerfanta->setCurrentPage($request->get('page', 1));
        $pagerfantaBarView = new TwitterBootstrap3View();
        $pagerfantaBarHtml = $pagerfantaBarView->render($pagerfanta, function ($page) {
            return route('personal-details.list', ['page' => $page]);
        });
        \Log::info('Showing personal details list of records page ' . $pagerfanta->getCurrentPage());

        return $this->view('personal_details.list', [
            'records' => $pagerfanta->getCurrentPageResults(),
            'pagerfantaBarHtml' => $pagerfantaBarHtml,
        ]);
    }

    /**
     * Displays form.
     *
     * @return Response
     */
    public function create()
    {
        \Log::info('Showing personal details record form');
        return $this->view('personal_details.create');
    }

    /**
     * Add New Personal Detail.
     *
     * @param StorePersonalDetailsRequest $request
     * @param PersonalDetailsStorage $storage
     *
     * @return Response
     */
    public function store(StorePersonalDetailsRequest $request, PersonalDetailsStorage $storage)
    {
        $personalDetails = new ArrayObject($request->all());
        $storage->store($personalDetails);

        \Log::info('Saved personal details record:' . $personalDetails['id']);

        if ($request->wantsJson()) {
            return Response::json($personalDetails);
        }

        return redirect()->route('personal-details.list');
    }
}
