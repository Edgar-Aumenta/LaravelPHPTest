<?php

namespace App\Http\Controllers\Version;

use App\Http\Controllers\ApiController;
use App\UpdateVersion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdateVersionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['publicIndex', 'getCurrentVersion']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $updateVersions = UpdateVersion::all();

        return $this->showAll($updateVersions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
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

        $updateVersion = UpdateVersion::create($request->all());

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
     * @param \Illuminate\Http\Request $request
     * @param UpdateVersion $updateVersion
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, UpdateVersion $updateVersion)
    {
        $rules = [
            'version_code' => 'required|unique:new_versions,version_code,' . $updateVersion->id,
            'version_name' => 'required',
            'version_url' => 'required',
            'current_version' => 'required',
            'release_date' => 'required',
            'estimate_size' => 'required',
            'user_id' => 'required'
        ];

        $this->validate($request, $rules);
        $this->compareChangesAndAssign($request, $updateVersion);

        if(!$updateVersion->isDirty()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $updateVersion->save();

        return $this->showOne($updateVersion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UpdateVersion $updateVersion
     * @return Response
     * @throws \Exception
     */
    public function destroy(UpdateVersion $updateVersion)
    {
        $updateVersion->delete();

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
        if ($request->has('user_id')) $updateVersion->user_id = $request->user_id;
    }

    /**
     * Get versions public
     *
     * @return Response
     */
    public function publicIndex(){
        $updateVersions = UpdateVersion::all();
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
    public function getCurrentVersion(){
        $currentUpdateVersion = UpdateVersion::all()->where('current_version', true)->first();
        return $this->showOne($currentUpdateVersion);
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

        return $updateVersion;
    }
}
