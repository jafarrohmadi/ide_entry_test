<?php

class School extends Model
{
    protected $table = 'school';
    protected $fillable = ['school_code', 'school_name', 'inaugurated_date'];
}

class SchoolController extends Controller
{
    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function getInauguratedSchool(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        $page = isset($request->page) ? $request->page : 1;

        $school = Cache::tags(['school'])->rememberForever("school-" . me()->id . $limit . $page, function () use ($limit) {
            return School::paginate($limit);
        });

        return $this->returnSuccess(new SchoolCollection($school));
    }

    public function returnSuccess($data)
    {
        $response = [
            'status' => true,
            'message' => 'Success',
            'data' => $data,
        ];

        return response($response, 200);
    }
}

class SchoolCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return AnonymousResourceCollection
     */
    public function toArray($request)
    {
        return SchoolResource::collection($this->collection);
    }
}


class SchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_code' => $this->school_code,
            'school_name' => $this->school_name,
            'inaugurated_date' => $this->inaugurated_date,
        ];
    }
}

Route::ge('getInauguratedSchool', [SchoolController::class, 'getInauguratedSchool'])->name('getInauguratedSchool');