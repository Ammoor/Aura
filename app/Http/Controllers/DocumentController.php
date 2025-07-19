<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Helpers\ApiResponseFormat;
use App\Http\Requests\AddDocumentRequest;
use App\Http\Resources\DocumentResource;

class DocumentController extends Controller
{
    private DocumentService $documentService;
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }
    public function uploadDocument(AddDocumentRequest $request)
    {
        $this->documentService->uploadDocument($request->validated());
        return ApiResponseFormat::successResponse(201, 'Document uploaded successfully.');
    }
    public function getDocument(Request $request)
    {
        $document = $this->documentService->getDocument($request->document_id);
        return ApiResponseFormat::successResponse(200, 'Document data returned successfully.', new DocumentResource($document));
    }
    public function getDocuments()
    {
        $documents = $this->documentService->getDocuments();
        return ApiResponseFormat::successResponse(200, 'Documents data returned successfully.', DocumentResource::collection($documents->items()), $documents->nextPageUrl());
    }
}
