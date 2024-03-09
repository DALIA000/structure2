<?php

namespace App\Http\Repositories\Overview;

interface OverviewInterface
{
    public function getWhatsappClicks($request);
    public function getClicks($request);
    public function getBlogViewCounts($request);
    public function getBrochureDownloadCounts($request);
    public function getFormFillCount($request);
}