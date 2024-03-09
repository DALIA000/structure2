<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Overview\OverviewInterface;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function __construct(private OverviewInterface $overviewI, private ResponseService $responseService)
    {
        $this->overviewI = $overviewI;
    }

    public function overview(Request $request)
    {
        $whatsappClicks = $this->overviewI->getWhatsappClicks($request);
        $clicks = $this->overviewI->getClicks($request);
        $views = $this->overviewI->getBlogViewCounts($request);
        $downloads = $this->overviewI->getBrochureDownloadCounts($request);
        $fills = $this->overviewI->getFormFillCount($request);

        return $this->responseService->json('Success!', [
            'whatsappClicks' => $whatsappClicks,
            'clicks' => $clicks,
            'views' => $views,
            'downloads' => $downloads,
            'fills' => $fills,
        ], 200);
    }
}
