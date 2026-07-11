<?php

namespace App\Repositories\Provider;

use App\Enums\ProviderStatus;
use App\Models\Provider;
use App\Models\ProviderAttachment;
use App\Models\ProviderSpecialization;
use App\Models\ProviderWorkCity;
use App\Models\ProviderWorkregion;
use App\Repositories\Provider\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDO;

class AuthRepository implements AuthRepositoryInterface
{
    public function createStepOne(array $data)
    {
        return Provider::create($data);  // Only basic fields at step one
    }

    public function updateStepTwo(int $providerId, array $attachments)
    {
        $provider = Provider::findOrFail($providerId);

        foreach ($attachments as $attachment) {
            ProviderAttachment::create([
                'provider_id' => $provider->id,
                'file_path' => $attachment['file_path'],
                'file_name' => $attachment['file_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // No need to update the provider with file paths
        return $provider;
    }

    public function updateStepThree(int $ProviderId, array $data)
    {
        $Provider = Provider::findOrFail($ProviderId);
        foreach ($data['specializations'] as $item) {
            ProviderSpecialization::create([
                'provider_id' => $Provider->id,
                'specialization_id' => $item,
            ]);
        }
        foreach ($data['city_id'] as $item) {
            ProviderWorkCity::create([
                'provider_id' => $Provider->id,
                'city_id' => $item,
            ]);
        }

        foreach ($data['region_id'] as $item) {
            ProviderWorkregion::create([
                'provider_id' => $Provider->id,
                'region_id' => $item,
            ]);
        }

        unset($data['user_id']);

        return $Provider;
    }

    public function findByEmail(string $email)
    {
        return Provider::where('email', $email)->first();
    }

    public function findById(int $id)
    {
        return Provider::findOrFail($id);
    }

    public function prepareAttachmentForUpdate(Request $request, Provider $provider)
    {
        $data = [];

        foreach (config('provider.files') as $attachmentType) {
            $fieldName = $attachmentType['name'];
            $isMultiple = $attachmentType['multiple'] ?? false;
            $isOptional = $attachmentType['optional'] ?? false;
            $arabicLabel = $attachmentType['label'] ?? $fieldName;
            $extensions = $attachmentType['extensions'] ?? [];
            $mimesRule = 'mimes:' . implode(',', $extensions);

            $rules = [];
            $messages = [];

            // Required or nullable depending on whether a file already exists
            $exists = $provider->attachments()->where('file_name', $fieldName)->exists();
            $required = $exists ? 'nullable' : ($isOptional ? 'nullable' : 'required');

            // Validation rules for multiple/single file
            if ($isMultiple) {
                $rules[$fieldName] = "$required|array";
                $rules["$fieldName.*"] = "$required|$mimesRule";

                if (!empty($attachmentType['min'])) {
                    $rules[$fieldName] .= '|min:' . $attachmentType['min'];
                    $messages["$fieldName.min"] = "يجب رفع على الأقل {$attachmentType['min']} من $arabicLabel.";
                }

                $messages["$fieldName.required"] = "حقل $arabicLabel مطلوب.";
                $messages["$fieldName.*.mimes"] = "$arabicLabel يجب أن يكون من الأنواع التالية: " . implode(', ', $extensions);
            } else {
                $rules[$fieldName] = "$required|$mimesRule";
                $messages["$fieldName.required"] = "حقل $arabicLabel مطلوب.";
                $messages["$fieldName.mimes"] = "$arabicLabel يجب أن يكون من الأنواع التالية: " . implode(', ', $extensions);
            }

            // Validate this field
            $request->validate($rules, $messages);

            // Store file(s) temporarily in $data
            if ($isMultiple && $request->hasFile($fieldName)) {
                $data[$fieldName] = $request->file($fieldName);
            } elseif ($request->hasFile($fieldName)) {
                $data[$fieldName] = $request->file($fieldName);
            }
        }

        return $data;
    }

    public function uploadProviderAttachments($data, Provider $provider)
    {
        foreach ($data as $key => $file) {
            if ($file === 'null') {
                unset($data[$key]);
                continue;
            }

            if (is_array($file)) {
                $stored = [];
                foreach ($file as $item) {
                    if ($item) {
                        $stored[] = $item->store('provider', 'private_files');
                    }
                }
                $data[$key] = $stored;
            } else {
                if ($file) {
                    $data[$key] = $file->store('provider', 'private_files');
                }
            }
        }

        return $data;
    }

    public function updateProviderAccount(Request $request, Provider $provider)
    {
        // update general data

        $provider->update([
            'company_name' => $request->company_name,
            'owner_id' => $request->owner_id,
            'commercial_registration' => $request->commercial_registration,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
            'status' => ProviderStatus::PENDING->value
        ]);

        // / updated m-m realtions

        ProviderSpecialization::where('provider_id', $provider->id)->delete();
        ProviderWorkregion::where('provider_id', $provider->id)->delete();
        ProviderWorkCity::where('provider_id', $provider->id)->delete();
        // return $request->specializations;
        // Then, re-insert updated ones
        foreach ($request->specializations as $item) {
            ProviderSpecialization::create([
                'provider_id' => $provider->id,
                'specialization_id' => $item,
            ]);
        }

        foreach ($request->work_city_id as $item) {
            ProviderWorkCity::create([
                'provider_id' => $provider->id,
                'city_id' => $item,
            ]);
        }

        foreach ($request->work_region_id as $item) {
            ProviderWorkregion::create([
                'provider_id' => $provider->id,
                'region_id' => $item,
            ]);
        }

        // / update attachments

        $data = $this->prepareAttachmentForUpdate($request, $provider);

        $attachments = $this->uploadProviderAttachments($data, $provider);

        foreach ($attachments as $key => $attach) {
            $exsitedAttahments = $provider->attachments()->where('file_name', $key)->get();

            foreach ($exsitedAttahments as $attachment) {
                if (Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }
                $attachment->delete();
            }

            if (is_array($attach)) {
                foreach ($attach as $singleFile) {
                    $provider->attachments()->create([
                        'file_path' => $singleFile,
                        'file_name' => $key,
                    ]);
                }
            } else {
                $provider->attachments()->create([
                    'file_path' => $attach,
                    'file_name' => $key,
                ]);
            }
        }

        return $provider;
    }
}
