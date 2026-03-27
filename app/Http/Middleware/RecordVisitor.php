<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RecordVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Debug log (bisa dihapus nanti kalau sudah jalan)
        Log::info('RecordVisitor dijalankan - Landing Page Mode', [
            'url' => $request->url(),
            'ip'  => $request->ip(),
            'path' => $request->path(),
        ]);

        // Hanya SKIP kalau masuk halaman admin (biar dashboard admin tidak ikut dihitung)
        if ($request->is('admin/*')) {
            Log::info('RecordVisitor SKIP karena admin route');
            return $next($request);
        }

        // Record setiap kunjungan (guest / landing page)
        Visitor::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        Log::info('✅ RecordVisitor BERHASIL menyimpan data');

        return $next($request);
    }
}
