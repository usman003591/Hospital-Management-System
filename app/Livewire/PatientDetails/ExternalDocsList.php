<?php

namespace App\Livewire\PatientDetails;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientExternalDocument;
use Illuminate\Support\Facades\Storage;

class ExternalDocsList extends Component
{

    use WithPagination;
    public $patient;
    // public $documents;
    public $documentToDelete = null;
    public $showDeleteConfirmation = false;

    public function mount($patientId)
    {
        $this->patient = Patient::findOrFail($patientId);
    }


    public function confirmDelete($documentId)
    {
        $this->documentToDelete = PatientExternalDocument::findOrFail($documentId);
        $this->showDeleteConfirmation = true;
    }

    public function deleteDocument($documentId = null)
    {
        // try {
        $document = $documentId ? PatientExternalDocument::findOrFail($documentId) : $this->documentToDelete;


        if ($document->patient_id !== $this->patient->id) {
            session()->flash('error', 'Unauthorized Access.');
            return redirect()->to('/patients/' . $this->patient->id . '/documents-list');
        }

        if (!$document) {
            session()->flash('error', 'Document not found.');
            return redirect()->to('/patients/' . $this->patient->id . '/documents-list');
        }

        // Set deleted_by before soft delete
        $document->deleted_by = Auth::id();
        $document->save();

        // Delete the file from storage if it exists
        if ($document->external_document_path && Storage::disk('public')->exists($document->external_document_path)) {
            Storage::disk('public')->delete($document->external_document_path);
        }

        // Soft delete the database record
        $document->delete();
        $this->documentToDelete = null;
        $this->showDeleteConfirmation = false;

        // $this->dispatch('flash-msg', type: 'success', message: 'Document deleted.');
        session()->flash('success', 'Document deleted successfully.');
        return redirect()->to('/patients/' . $this->patient->id . '/documents-list');

    }

    public function previewDocument($documentId)
    {
        try {
            $doc = PatientExternalDocument::findOrFail($documentId);

            $this->dispatch('open-document-preview', [
                'url' => route('patient_external_documents.preview', ['documentId' => $documentId])
            ]);

        } catch (\Exception $e) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Failed to preview the document.'
            ]);
        }
    }
    public function render()
    {
        $documents = PatientExternalDocument::where('patient_id', $this->patient->id)
            ->latest()
            ->paginate(10);

        return view('livewire.patient-details.external-docs-list', [
            'documents' => $documents
        ]);
    }
}
