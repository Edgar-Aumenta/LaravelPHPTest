<?php

namespace App\Http\Controllers\Version;

use App\Http\Controllers\ApiController;
use App\UpdateVersion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class UpdateVersionController extends ApiController
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
        $updateVersions = UpdateVersion::all()->sortByDesc('release_date');
        $updateVersionsReadModel = collect();

        foreach ($updateVersions as $updateVersion)
        {
            $updateVersionsReadModel->push($updateVersion);
        }

        return $this->showAll($updateVersionsReadModel);
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
            'version_code' => 'required|unique:update_versions',
            'version_name' => 'required',
            'version_url' => 'required',
            'current_version' => 'required',
            'release_date' => 'required',
            'estimate_size' => 'required',
            //'readme_url' => 'required',
            //'update_guide_url' => 'required'
        ];

        $this->validate($request, $rules);
        $newUpdateVersion = $request->all();
        $newUpdateVersion['user_id'] = $user->id; // Save user to update version

        if($request->current_version == true){
            $currentNewVersion = $this->getCurrentVersion();
            if($currentNewVersion != null) {
                $currentNewVersion->current_version = false;
                $currentNewVersion->save();
            }
        }

        $updateVersion = UpdateVersion::create($newUpdateVersion);

        return $this->showOne($updateVersion, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param UpdateVersion $updateVersion
     * @return Response
     */
    public function show(UpdateVersion $updateVersion)
    {
        return $this->showOne($updateVersion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UpdateVersion $updateVersion
     * @return Response
     * @throws ValidationException
     * @throws Throwable
     */
    public function update(Request $request, UpdateVersion $updateVersion)
    {
        $user = $request->user();
        $rules = [
            'version_code' => 'unique:update_versions,version_code,' . $updateVersion->id,
        ];

        $this->validate($request, $rules);

        $this->compareChangesAndAssign($request, $updateVersion);

        $updateVersion->user_id = $user->id; // Save user to update version

        if(!$updateVersion->isDirty()){
            return $this->messageResponse('Nothing to update', 200);
        }

        $currentNewVersion = $this->getCurrentVersion();
        if($currentNewVersion != null && $currentNewVersion->id != $updateVersion->id){
            if($updateVersion->current_version == true) {
                $currentNewVersion->current_version = false;
                $currentNewVersion->save();
            }
        }else {
            $updateVersion->current_version = true;
        }

        $updateVersion->save();

        return $this->showOne($updateVersion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UpdateVersion $updateVersion
     * @return Response
     * @throws Exception
     */
    public function destroy(UpdateVersion $updateVersion)
    {
        $updateVersion->delete();

        if($updateVersion->current_version == true){
            $lastReleaseVersion = $this->getLastReleaseVersion();
            $lastReleaseVersion->current_version = true;
            $lastReleaseVersion->save();
        }

        return $this->showOne($updateVersion);
    }

    /**
     * Compare chances and assign if there are
     * @param Request $request
     * @param UpdateVersion $updateVersion
     */
    private function compareChangesAndAssign(Request $request, UpdateVersion &$updateVersion)
    {
        if ($request->has('version_code')) $updateVersion->version_code = $request->version_code;
        if ($request->has('version_name')) $updateVersion->version_name = $request->version_name;
        if ($request->has('version_url')) $updateVersion->version_url = $request->version_url;
        if ($request->has('current_version')) $updateVersion->current_version = $request->current_version;
        if ($request->has('release_date')) $updateVersion->release_date = $request->release_date;
        if ($request->has('estimate_size')) $updateVersion->estimate_size = $request->estimate_size;
        if ($request->has('readme_url')) $updateVersion->readme_url = $request->readme_url;
        if ($request->has('update_guide_url')) $updateVersion->update_guide_url = $request->update_guide_url;
    }

    /**
     * Get versions public
     *
     * @return Response
     */
    public function publicIndex(){
        $updateVersions = UpdateVersion::all()->sortByDesc('release_date');
        $updateVersionsReadModel = collect();

        foreach ($updateVersions as $updateVersion)
        {
            $updateVersionReadModel = $this->convertToReadModel($updateVersion);
            $updateVersionsReadModel->push($updateVersionReadModel);
        }

        return $this->showAll($updateVersionsReadModel);
    }

    /**
     * Get current version
     * @return Response
     * */
    public function showCurrentVersion(){
        $currentUpdateVersion = UpdateVersion::all()->where('current_version', true)->first();
        return $this->showOne($currentUpdateVersion);
    }

    private function getCurrentVersion(){
        $currentNewVersion = UpdateVersion::all()->where('current_version', true)->first();
        return $currentNewVersion;
    }

    private function getLastReleaseVersion()
    {
        $lastReleaseVersion = UpdateVersion::all()->sortByDesc('release_date')->first();
        return $lastReleaseVersion;
    }

    /**
     * @param UpdateVersion $nv
     * @return UpdateVersion
     */
    private function convertToReadModel(UpdateVersion $nv)
    {
        $updateVersion = new UpdateVersion();
        $updateVersion->id = $nv->id;
        $updateVersion->version_code = $nv->version_code;
        $updateVersion->version_name = $nv->version_name;
        $updateVersion->version_url = $nv->version_url;
        $updateVersion->current_version = $nv->current_version;
        $updateVersion->release_date = $nv->release_date;
        $updateVersion->estimate_size = $nv->estimate_size;
        $updateVersion->readme_url = $nv->readme_url;
        $updateVersion->update_guide_url = $nv->update_guide_url;

        return $updateVersion;
    }
}
