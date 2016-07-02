<?php

namespace App\Http\Controllers;

use ArrayObject;
use Illuminate\Http\Request;
use App\Http\Requests\StorePersonalDetailsRequest;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Intl\Intl;
use App\Services\PersonalDetailsStorage;

/**
* 
*/
class PersonalDetailsController extends Controller
{
	
    /**
     * Show one detail by id
     *
     * @param  int  $id
     * @param PersonalDetailsStorage $storage
     *
     * @return Response
     */
    public function showDetail(PersonalDetailsStorage $storage, $id)
    {
        return view('personal_details.view', ['personalDetails' => $storage->get($id)]);
    }


    /**
     * Show the list
     *
     * @param PersonalDetailsStorage $storage
     *
     * @return Response
     */
    public function listAll(PersonalDetailsStorage $storage)
    {
        return view('personal_details.list', ['records' => $storage->all()]);
    }


    /**
     * Displays form
     *
     * @return Response 
     */
    public function create()
    {
        return view('personal_details.create', [
            'genders' => \Config::get('constants.personal_details.genders'),
            'contactModes' => \Config::get('constants.personal_details.contact_modes'),
            'countries' => Intl::getRegionBundle()->getCountryNames(\Lang::getLocale())
        ]);
    }

    /**
     * Add New Personal Detail
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

        if ($request->wantsJson()) {
            return Response::json($personalDetails);
        }

        return redirect()->route('personal-details.list');
    }
}
