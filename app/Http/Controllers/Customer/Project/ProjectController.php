<?php

namespace App\Http\Controllers\Customer\Project;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\BuildingType;
use App\Models\City;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Models\ProjectCategory;
use App\Models\ProjectType;
use App\Models\Region;
use App\Models\Speciality;
use App\Models\TimeLineDuration;
use App\Services\Customer\PerojectService;
use App\Utils\OfferUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class ProjectController extends Controller
{
    protected $projectService;

    // public function index()
    // {
    //     $projects = auth('customer')->user()->projects;
    //     return view('customer.project.index', compact('projects'));
    // }

    public function index(Request $request)
    {
        $customer = auth('customer')->user();

        $query = $customer->projects()->with(['serviceType', 'buildingType', 'category']);

        if ($request->filled('project_filter') && $request->project_filter != 'all') {
            $query->where('status', $request->project_filter);
        }
        if ($request->filled('project_search')) {
            $search = $request->project_search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('work_description', 'like', "%$search%")
                    ->orWhereHas('serviceType', fn($q) => $q->where('name', 'like', "%$search%"))
                    ->orWhereHas('buildingType', fn($q) => $q->where('name', 'like', "%$search%"))
                    ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%$search%"));
            });
        }

        $projects = $query->orderByDesc('id')->get();

        return view('customer.project.index', compact('projects'));
    }

    public function __construct(PerojectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function showCreateForm()
    {
        $types = ProjectType::where('status', 1)->get();
        return view('customer.project.create.index', ['step' => 1, 'types' => $types]);
    }

    public function createStepOne(Request $request)
    {
        $request->validate(
            [
                'project_type' => 'required'
            ]
        );
        $data = $request->except('_token');

        if ($request->has('project_id')) {
            $project = $this->projectService->updateStepOne($data);
        } else {
            $project = $this->projectService->createStepOne($data);
        }

        if ($request->has('project_id')) {
            return redirect()->route('customer.project.edit', ['id' => $project->id, 'step' => 5]);
        }

        return redirect()->route('customer.project.edit', ['id' => $project->id, 'step' => 2]);
    }

    public function viewStep($project_id, $step)
    {
        $serviceTypes = Speciality::where('status', 1)->get();
        $buildingTypes = BuildingType::all();
        $categories = ProjectCategory::where('status', 1)->get();
        $durations = TimeLineDuration::all();
        $project = Project::find($project_id);
        $regions = Region::where('status', 1)->get();
        $types = ProjectType::where('status', 1)->get();

        $attachments = [];
        $appendedData = [];
        if ($step == 5 || $step == 4) {
            foreach (config('project.files') as $type) {
                $query = $project->attachments()->where('file_name', $type['name']);
                $attachments[$type['name']] = !empty($type['multiple']) ? $query->get() : $query->first();
            }
        }


        // return $attachments;
        if (request()->has('edit')) {
            return view('customer.project.edit.index', compact('step', 'regions', 'project', 'serviceTypes', 'types', 'buildingTypes', 'categories', 'durations', 'attachments'));
        } else {
            return view('customer.project.create.index', compact('step', 'regions', 'project', 'serviceTypes', 'types', 'buildingTypes', 'categories', 'durations', 'attachments'));
        }
    }

    public function updateStep($id, $step, Request $request)
    {
        switch ($step) {
            case 2:
                $request->validate([
                    'service_type' => 'required',
                    'address' => 'required|string|max:255',
                    'building_type' => 'required',
                    'category_id' => 'required',
                    'work_description' => 'nullable|string|max:500',
                    'city_id' => 'required',
                    'country' => 'nullable',
                    'region_id' => 'required',
                    'latitude' => 'required|numeric',
                    'longitude' => 'required|numeric',
                ], [
                    'country.required' => 'Please select an addreess on the map',
                    'latitude.required' => 'Please select an addreess on the map',
                    'longitude.required' => 'Please select an addreess on the map',
                    'address.required' => 'Please select an addreess on the map',
                ]);

                $data = $request->except('_token');
                $data['project_id'] = $id;

                $edit = 0;
                if ($request->has('edit')) {
                    $edit = 1;
                }
                $this->projectService->updateSteptwo($data, $edit);

                if($edit == 1)
                return redirect()->route('customer.project.edit', ['id' => $id, 'step' => 5]);

                return redirect()->route('customer.project.edit', ['id' => $id, 'step' => 3]);

                break;
            case 3:
                $request->validate([
                    'budget' => 'required|numeric|min:1000',
                    'duration' => 'required',
                    'start_date' => 'required|date|after_or_equal:today',
                ]);

                $data = $request->except('_token');
                $data['project_id'] = $id;

                $edit = 0;
                if ($request->has('edit')) {
                    $edit = 1;
                }
                $this->projectService->updateStepthree($data, $edit);

                if($edit == 1)
                return redirect()->route('customer.project.edit', ['id' => $id, 'step' => 5]);

                return redirect()->route('customer.project.edit', ['id' => $id, 'step' => 4]);

                break;
            case 4:
                $project = Project::findOrFail($id);
                $data = [];

                // foreach (config('project.files') as $attachmentType) {
                //     $fieldName = $attachmentType['name'];
                //     $isMultiple = $attachmentType['multiple'] ?? false;
                //     $isOptional = $attachmentType['optional'] ?? false;
                //     $arabicLabel = $attachmentType['label'] ?? $fieldName;
                //     $extensions = $attachmentType['extensions'] ?? [];

                //     $rules = [];
                //     $messages = [];

                //     // Determine if field is required (only required in step 4 and if not optional)
                //     $required = $isOptional ? 'nullable' : ($project->step == 4 ? 'required' : 'nullable');

                //     if ($isMultiple) {
                //         $rules["$fieldName"] = "$required|array";
                //         $rules["$fieldName.*"] = "$required|mimes:" . implode(',', $extensions);

                //         if (!empty($attachmentType['min'])) {
                //             $rules["$fieldName"] .= '|min:' . $attachmentType['min'];
                //             $messages["$fieldName.min"] = "يجب رفع على الأقل {$attachmentType['min']} من $arabicLabel.";
                //         }

                //         $messages["$fieldName.required"] = "حقل $arabicLabel مطلوب.";
                //         $messages["$fieldName.*.mimes"] = "$arabicLabel يجب أن يكون من الأنواع التالية: " . implode(', ', $extensions);
                //     } else {
                //         $rules["$fieldName"] = "$required|mimes:" . implode(',', $extensions);
                //         $messages["$fieldName.required"] = "حقل $arabicLabel مطلوب.";
                //         $messages["$fieldName.mimes"] = "$arabicLabel يجب أن يكون من الأنواع التالية: " . implode(', ', $extensions);
                //     }

                //     // Validate request
                //     $request->validate($rules, $messages);

                //     // Store the files in data array
                //     if ($isMultiple ? $request->hasFile($fieldName) : $request->file($fieldName)) {
                //         $files = $isMultiple ? $request->file($fieldName) : [$request->file($fieldName)];
                //         $data[$fieldName] = $isMultiple ? $files : $files[0];
                //     }
                // }

                // // Upload files to storage and overwrite previous attachments
                // foreach ($data as $key => $file) {
                //     if ($file === 'null') {
                //         unset($data[$key]);
                //         continue;
                //     }

                //     // Delete existing files for this field
                //     ProjectAttachment::where('project_id', $project->id)->where('file_name', $key)->delete();

                //     if (is_array($file)) {
                //         $storedPaths = [];
                //         foreach ($file as $item) {
                //             if ($item) {
                //                 $storedPaths[] = $item->store('project', 'private_files');
                //             }
                //         }
                //         $data[$key] = $storedPaths;
                //     } else {
                //         if ($file) {
                //             $data[$key] = $file->store('project', 'private_files');
                //         }
                //     }
                // }

                $edit = 0;
                if ($request->has('edit')) {
                    $edit = 1;
                }
                $data['project_id'] = $id;

                $this->projectService->updateStepFour($data, $edit);

                return redirect()->route('customer.project.edit', ['id' => $id, 'step' => 5]);

            case 5:
                $data = $request->except('_token');
                $data['project_id'] = $id;

                $data['reference_number'] = uniqid('PROJ-');  // Example: ref_64e03cd8f1e55
                $edit = 0;
                if ($request->has('edit')) {
                    $edit = 1;
                }
                $this->projectService->updateStepfife($data, $edit);

                
                return redirect()->route('customer.project.edit', ['id' => $id, 'step' => 6]);

                break;
            default:
                abort(404);
        }
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $attachments = [];

        if ($project->status == ProjectStatus::REQUIRE_COMPLETE->value) {
            return redirect()->route('customer.project.edit', ['id' => $id, 'step' => $project->step]);
        }
        foreach (config('project.files') as $type) {
            $attachments[$type['label']] = $project->attachments()->where('file_name', $type['name'])->get();
        }
        return view('customer.project.show.index', compact('project', 'attachments'));
    }

    public function downloadFile($id)
    {
        $file = ProjectAttachment::findOrFail($id);

        if ($file->project->customer_id != auth()->user()->id)
            abort(404);

        $filePath = $file->file_path;

        if (!Storage::disk('private_files')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('private_files')->download($filePath);
    }

    public function showCompeleted($project_id)
    {
        $customer = Auth::guard('customer')->user();

        $project = Project::find($project_id);

        // check for access

        if ($project->customer_id != $customer->id)
            abort(403);

        $canRate = false;

        $offer = $project->completedOffer();

        $details = OfferUtility::getDetails($offer);
        $ratingQuery = $offer->provider->ratingsQuery();

        // Get average rating in one query
        $averageRate = $ratingQuery->avg('contractor_rating');

        return view('customer.project.completed.index', compact('offer', 'project', 'canRate', 'details', 'averageRate'));
    }

    public function createOrUpdateAttchment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'field_name' => 'required|string',
            'file' => 'nullable|file',
            'files' => 'nullable|array',
            'files.*' => 'file',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $project = Project::findOrFail($request->project_id);
        if ($project->customer_id != auth()->id()) {
            abort(403);
        }

        $fieldName = $request->field_name;

        // Step 2: Get field config
        $fileConfig = collect(config('project.files'))->firstWhere('name', $fieldName);

        if (!$fileConfig) {
            return response()->json([
                'status' => false,
                'errors' => ['field_name' => ['Invalid field name']]
            ], 422);
        }

        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            $uploadedFiles = $request->file('files');
        } elseif ($request->hasFile('file')) {
            $uploadedFiles = [$request->file('file')];
        }

        if (empty($uploadedFiles)) {
            return response()->json([
                'status' => false,
                'errors' => ['file' => ['يرجى اختيار ملف واحد على الأقل.']]
            ], 422);
        }

        foreach ($uploadedFiles as $file) {
            $fileValidator = Validator::make(['file' => $file], [
                'file' => [
                    'required',
                    'file',
                    'max:10240',
                    'mimes:' . implode(',', $fileConfig['extensions']),
                ]
            ]);

            if ($fileValidator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $fileValidator->errors()
                ], 422);
            }
        }

        if (empty($fileConfig['multiple'])) {
            $existing = $project->attachments()->where('file_name', $fieldName)->get();
            foreach ($existing as $attachment) {
                if (Storage::disk('private_files')->exists($attachment->file_path)) {
                    Storage::disk('private_files')->delete($attachment->file_path);
                }
                $attachment->delete();
            }
            $uploadedFiles = [reset($uploadedFiles)];
        }

        foreach ($uploadedFiles as $file) {
            $path = $file->store('project', 'private_files');
            $this->projectService->createProjectAttahcmet([
                'file_path' => $path,
                'file_name' => $fieldName,
                'project_id' => $project->id,
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    public function deleteAttachment($id)
    {
        $attachment = ProjectAttachment::findOrFail($id);

        if ($attachment->project->customer_id != auth()->id()) {
            abort(403);
        }

        if (Storage::disk('private_files')->exists($attachment->file_path)) {
            Storage::disk('private_files')->delete($attachment->file_path);
        }

        $attachment->delete();

        return response()->json(['status' => true]);
    }
}
