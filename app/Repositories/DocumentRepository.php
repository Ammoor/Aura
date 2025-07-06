<?php

namespace App\Repositories;

class DocumentRepository
{
    public function uploadDocument(array $documentData)
    {
        return auth()->user()->documents()->create($documentData);
    }
    public function getDocument(int $documentId)
    {
        return auth()->user()->documents()->findOrFail($documentId);
    }
    public function getDocuments()
    {
        return auth()->user()->documents()->cursorPaginate(10);
    }
}
