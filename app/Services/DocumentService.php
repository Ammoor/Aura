<?php

namespace App\Services;

use App\Repositories\DocumentRepository;
use App\Helpers\S3MediaHelper;
use App\Helpers\LocalMediaHelper;

class DocumentService
{
    private DocumentRepository $documentRepository;
    private string $appName;
    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
        $this->appName = config('app.name');
    }
    public function uploadDocument(array $documentData)
    {
        $documentData['local_path'] = LocalMediaHelper::store($documentData['document'], 'documents');
        $documentData['name'] = ' ';
        S3MediaHelper::store($documentData['document'], $this->appName . '/' . $documentData['local_path']);
        return $this->documentRepository->uploadDocument($documentData);
    }
    public function getDocument(int $documentId)
    {
        return $this->documentRepository->getDocument($documentId);
    }
    public function getDocuments()
    {
        return $this->documentRepository->getDocuments();
    }
}
