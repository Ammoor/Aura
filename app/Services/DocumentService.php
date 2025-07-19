<?php

namespace App\Services;

use App\Repositories\DocumentRepository;
use App\Helpers\S3MediaHelper;

class DocumentService
{
    private DocumentRepository $documentRepository;
    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }
    public function uploadDocument(array $documentData)
    {
        $documentData['name'] = ' ';
        $documentData['local_path'] = S3MediaHelper::store($documentData['document'], 'documents');
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
