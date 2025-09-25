<?php

namespace App\Http\Controllers\Patient;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PatientExternalDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class PatientExternalDocumentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $document = PatientExternalDocument::storeDocument(
            $request->patient_id,
            $request->file('file')
        );

        session()->flash('success', 'Documents uploaded successfully!');
        return response()->json(['document_id' => $document->id]);
    }

    public function previewDocs($documentId)
    {
        try {
            $document = PatientExternalDocument::findOrFail($documentId);


            if (!$document->external_document_path || !Storage::disk('public')->exists($document->external_document_path)) {
                abort(404, 'File not found');
            }

            $filePath = $document->external_document_path;
            $fileName = $document->external_document_name;
            $mimeType = Storage::disk('public')->mimeType($filePath) ?: 'application/octet-stream';

            return Storage::disk('public')->response($filePath, $fileName, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
            ]);

        } catch (\Exception $e) {
            abort(404, 'Document not found');
        }
    }
}
