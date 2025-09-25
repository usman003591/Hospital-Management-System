<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientExternalDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'external_document_name',
        'external_document_extension',
        'external_document_file_size',
        'external_document_path',
        'external_document_complete_path',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Handles storing a document from an uploaded file.
     *
     * @param int $patientId
     * @param \Illuminate\Http\UploadedFile $file
     * @return static
     */
    public static function storeDocument(int $patientId, UploadedFile $file): self
    {
        $filePath = $file->store('external_documents', 'public');

        return self::create([
            'patient_id' => $patientId,
            'external_document_name' => $file->getClientOriginalName(),
            'external_document_extension' => $file->getClientOriginalExtension(),
            'external_document_file_size' => $file->getSize(),
            'external_document_path' => $filePath,
            'external_document_complete_path' => Storage::disk('public')->path($filePath),
            'created_by' => Auth::id(),
        ]);
    }
}
