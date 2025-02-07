<?php

namespace App\Controllers;

use App\Models\FileModel;
use Config\S3;

class FileController extends BaseController
{
    protected $fileModel;
    protected $s3;

    public function __construct()
    {
        $this->fileModel = new FileModel();
        $this->s3 = new S3();
    }

    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;
        
        $data['files'] = $this->fileModel->getAllFiles($perPage, ($page - 1) * $perPage);
        $data['pager'] = $this->fileModel->pager;
        
        return view('files/index', $data);
    }

    public function uploadForm()
    {
        return view('files/upload');
    }

    public function upload()
    {
        if (strtolower($this->request->getMethod()) === 'post') {

            $file = $this->request->getFile('file');
            
            if (!$file || !$file->isValid()) {
                session()->setFlashdata('error', 'No valid file uploaded');
                return redirect()->back();
            }
            
            // Validate file type
            $allowedTypes = ['text/plain', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                           'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                           'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
            
            // Get MIME type safely
            try {
                $mimeType = $file->getMimeType();
                if (!in_array($mimeType, $allowedTypes)) {
                    session()->setFlashdata('error', 'Invalid file type. Only txt, doc, pdf, xls, or pptx files are allowed.');
                    return redirect()->back();
                }
            } catch (\Exception $e) {
                log_message('error', 'MIME Type Detection Error: ' . $e->getMessage());
                session()->setFlashdata('error', 'Unable to determine file type');
                return redirect()->back();
            }

            // Validate file size (10MB max)
            if ($file->getSize() > 10485760) { // 10MB in bytes
                session()->setFlashdata('error', 'File size exceeds maximum limit of 10MB.');
                return redirect()->back();
            }

            if ($file->isValid()) {
                try {
                    $originalName = $file->getClientName();
                    $newName = $file->getRandomName();
                    $s3Key = 'uploads/' . $newName;
                    
                    // Get file stream and upload directly to S3
                    $fileStream = fopen($file->getTempName(), 'rb');
                    try {
                        $s3Url = $this->s3->uploadToS3($fileStream, $s3Key, $file->getMimeType());
                        fclose($fileStream);
                        
                        if ($s3Url) {
                            $fileData = [
                                'filename' => $newName,
                                's3_url' => $s3Url,
                                'user_id' => session()->get('user_id'),
                                'original_name' => $originalName,
                                'file_size' => $file->getSize(),
                                'mime_type' => $file->getMimeType()
                            ];

                            if ($this->fileModel->insert($fileData)) {
                                session()->setFlashdata('success', 'File uploaded successfully');
                                return redirect()->to('/dashboard');
                            } else {
                                // Log validation errors if any
                                $errors = $this->fileModel->errors();
                                log_message('error', 'File Upload Database Error: ' . json_encode($errors));
                                session()->setFlashdata('error', 'Failed to save file information');
                                return redirect()->back();
                            }
                        }
                    } catch (\RuntimeException $e) {
                        fclose($fileStream);
                        session()->setFlashdata('error', $e->getMessage());
                        return redirect()->back();
                    }
                    
                } catch (\Exception $e) {
                    log_message('error', 'File Upload Error: ' . $e->getMessage());
                    session()->setFlashdata('error', 'An error occurred while uploading the file: ' . $e->getMessage());
                    return redirect()->back();
                }
            }

            session()->setFlashdata('error', 'Invalid file');
            return redirect()->back();
        }

        return view('files/upload');
    }

    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->to('/dashboard');
        }

        $file = $this->fileModel->find($id);
        
        if ($file) {
            // Delete from S3
            $s3Key = 'uploads/' . $file['filename'];
            try {
                $this->s3->getS3Client()->deleteObject([
                    'Bucket' => env('aws.s3_bucket'),
                    'Key'    => $s3Key
                ]);
                
                // Delete from database
                $this->fileModel->delete($id);
                
                return redirect()->to('/dashboard')
                    ->with('success', 'File deleted successfully');
            } catch (\Exception $e) {
                log_message('error', 'S3 Delete Error: ' . $e->getMessage());
                return redirect()->to('/dashboard')
                    ->with('error', 'Failed to delete file');
            }
        }

        return redirect()->to('/dashboard')
            ->with('error', 'File not found');
    }
}