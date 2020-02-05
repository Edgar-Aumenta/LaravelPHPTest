<?php

namespace App\Http\Controllers\Version;

use App\Http\Controllers\ApiController;
use App\NewVersion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class NewVersionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['publicIndex', 'showCurrentVersion']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $newVersions = NewVersion::all();

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
        $rules = [
            'version_code' => 'required|unique:new_versions',
            'version_name' => 'required',
            'version_url' => 'required',
            'current_version' => 'required',
            'release_date' => 'required',
            'estimate_size' => 'required',
            'user_id' => 'required'
        ];

        $this->validate($request, $rules);

        if($request->current_version == true){
            $currentNewVersion = $this->getCurrentVersion();
            $this->setCurrentVersion($currentNewVersion, false);
        }

        $newVersion = NewVersion::create($request->all());

        return $this->showOne($newVersion, 201);
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
     */
    public function update(Request $request, NewVersion $newVersion)
    {
        $rules = [
            'version_code' => 'unique:new_versions,version_code,' . $newVersion->id,
            'user_id' => 'required'
        ];

        $this->validate($request, $rules);
        $this->compareChangesAndAssign($request, $newVersion);

        if(!$newVersion->isDirty()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        if($newVersion->current_version == true){
            $currentNewVersion = $this->getCurrentVersion();
            if($currentNewVersion != null && $currentNewVersion->id != $newVersion->id){
                $this->setCurrentVersion($currentNewVersion, false);
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
            $this->setCurrentVersion($lastReleaseVersion, true);
        }

        return $this->showOne($newVersion);
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
        if ($request->has('user_id')) $newVersion->user_id = $request->user_id;
    }

    /**
     * Get versions public
     *
     * @return Response
     */
    public function publicIndex(){
        $newVersions = NewVersion::all();
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

    private function setCurrentVersion(NewVersion $newVersion, bool $isCurrent){
        if($newVersion != null) {
            $newVersion->current_version = $isCurrent;
            $newVersion->save();
        }
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

        return $newVersion;
    }
}
