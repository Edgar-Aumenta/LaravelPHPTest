<?php

namespace App\Http\Controllers\Version;

use App\Http\Controllers\ApiController;
use App\NewVersion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class NewVersionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['publicIndex', 'showCurrentVersion']);
        $this->middleware('isAdmin:api')->except(['publicIndex', 'showCurrentVersion']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $newVersions = NewVersion::all()->sortByDesc('release_date');

        return $this->showAll($newVersions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $rules = [
            'version_code' => 'required|unique:new_versions',
            'version_name' => 'required',
            'version_url' => 'required',
            'current_version' => 'required',
            'release_date' => 'required',
            'estimate_size' => 'required',
            //'readme_url' => 'required',
            //'update_guide_url' => 'required'
        ];

        $this->validate($request, $rules);
        $newVersion = $request->all();
        $newVersion['user_id'] = $user->id; // Save user to update version

        if($request->current_version == true){
            $currentNewVersion = $this->getCurrentVersion();
            if($currentNewVersion != null){
                $currentNewVersion->current_version = false;
                $currentNewVersion->save();
            }
        }

        $savedNewVersion = NewVersion::create($newVersion);

        return $this->showOne($savedNewVersion, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param NewVersion $newVersion
     * @return Response
     */
    public function show(NewVersion $newVersion)
    {
        return $this->showOne($newVersion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param NewVersion $newVersion
     * @return Response
     * @throws ValidationException
     * @throws Throwable
     */
    public function update(Request $request, NewVersion $newVersion)
    {
        $user = $request->user();
        $rules = [
            'version_code' => 'unique:new_versions,version_code,' . $newVersion->id
        ];

        $this->validate($request, $rules);
        $this->compareChangesAndAssign($request, $newVersion);

        $newVersion->user_id = $user->id; // Save user to update version

        if(!$newVersion->isDirty()){
            return $this->messageResponse('Nothing to update', 200);
        }

        if($newVersion->current_version == true){
            $currentNewVersion = $this->getCurrentVersion();
            if($currentNewVersion != null && $currentNewVersion->id != $newVersion->id){
                $currentNewVersion->current_version = false;
                $currentNewVersion->save();
            }
        }

        $newVersion->save();

        return $this->showOne($newVersion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NewVersion $newVersion
     * @return Response
     * @throws Exception
     */
    public function destroy(NewVersion $newVersion)
    {
        $newVersion->delete();

        if($newVersion->current_version == true){
            $lastReleaseVersion = $this->getLastReleaseVersion();
            $lastReleaseVersion->current_version = false;
            $lastReleaseVersion->save();
        }
        return $this->messageResponse("Erased!", 200);
    }

    /**
     * Compare chances and assign if there are
     * @param Request $request
     * @param NewVersion $newVersion
     */
    private function compareChangesAndAssign(Request $request, NewVersion &$newVersion)
    {
        if ($request->has('version_code')) $newVersion->version_code = $request->version_code;
        if ($request->has('version_name')) $newVersion->version_name = $request->version_name;
        if ($request->has('version_url')) $newVersion->version_url = $request->version_url;
        if ($request->has('current_version')) $newVersion->current_version = $request->current_version;
        if ($request->has('release_date')) $newVersion->release_date = $request->release_date;
        if ($request->has('estimate_size')) $newVersion->estimate_size = $request->estimate_size;
        if ($request->has('readme_url')) $newVersion->readme_url = $request->readme_url;
        if ($request->has('update_guide_url')) $newVersion->update_guide_url = $request->update_guide_url;
    }

    /**
     * Get versions public
     *
     * @return Response
     */
    public function publicIndex(){
        $newVersions = NewVersion::all()->sortByDesc('release_date');
        $newVersionsReadModel = collect();

        foreach ($newVersions as $newVersion){
            $newVersionReadModel = $this->convertToReadModel($newVersion);
            $newVersionsReadModel->push($newVersionReadModel);
        }

        return $this->showAll($newVersionsReadModel);
    }

    /**
     * Get current version
     * @return Response
     * */
    public function showCurrentVersion()
    {
        $currentNewVersion = $this->getCurrentVersion();
        return $this->showOne($currentNewVersion);
    }

    private function getCurrentVersion()
    {
        $currentNewVersion = NewVersion::all()->where('current_version', true)->first();
        return $currentNewVersion;
    }

    private function getLastReleaseVersion()
    {
        $lastReleaseVersion = NewVersion::all()->sortByDesc('release_date')->first();
        return $lastReleaseVersion;
    }

    /**
     * @param NewVersion $nv
     * @return NewVersion
     */
    private function convertToReadModel(NewVersion $nv)
    {
        $newVersion = new NewVersion();
        $newVersion->id = $nv->id;
        $newVersion->version_code = $nv->version_code;
        $newVersion->version_name = $nv->version_name;
        $newVersion->version_url = $nv->version_url;
        $newVersion->current_version = $nv->current_version;
        $newVersion->release_date = $nv->release_date;
        $newVersion->estimate_size = $nv->estimate_size;
        $newVersion->readme_url = $nv->readme_url;
        $newVersion->update_guide_url = $nv->update_guide_url;

        return $newVersion;
    }
}
