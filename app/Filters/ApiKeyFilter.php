<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $validApiKey = 'AEROSERVE-API-12345'; 
        
        $clientApiKey = $request->getHeaderLine('X-API-KEY');
        
        if (empty($clientApiKey)) {
            $clientApiKey = $request->getGet('key'); 
        }

        if (empty($clientApiKey) || $clientApiKey !== $validApiKey) {
            return service('response')->setJSON([
                'status'  => false,
                'message' => 'Akses Ditolak: API Key tidak valid atau tidak ditemukan.'
            ])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}