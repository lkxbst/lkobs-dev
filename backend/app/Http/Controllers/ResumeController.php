<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ResumeController extends Controller
{
    public function __invoke(): Response
    {
        $profile = Profile::singleton();
        $resumePath = $profile->resume_path;

        if ($resumePath === null || $resumePath === '' || ! Storage::disk('public')->exists($resumePath)) {
            abort(404);
        }

        $content = (string) Storage::disk('public')->get($resumePath);

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="luan.kobs.pdf"',
        ]);
    }
}
