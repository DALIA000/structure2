<?php

namespace App\Http\Repositories\Overview;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\AgentClick;
use App\Models\BlogView;
use App\Models\Click;
use App\Models\Form;
use App\Models\ListForm;
use App\Models\Quiz;


class OverviewRepository extends BaseRepository implements OverviewInterface
{
    public $formModel, $quizModel, $listFormModel, $agentClickModel, $blogViewModel, $whatsappClickModel;

    public function __construct(Form $formModel, Quiz $quizModel, ListForm $listFormModel, AgentClick $agentClickModel, BlogView $blogViewModel, Click $whatsappClickModel)
    {
        $this->formModel = $formModel;
        $this->quizModel = $quizModel;
        $this->listFormModel = $listFormModel;
        $this->agentClickModel = $agentClickModel;
        $this->blogViewModel = $blogViewModel;
        $this->whatsappClickModel = $whatsappClickModel;
    }

    public function getWhatsappClicks($request)
    {
        $whatsappClicksCount = $this->whatsappClickModel::count();

        if ($whatsappClicksCount > 0) {
            $allClicks = $whatsappClicksCount;
            $todayClicks = $this->whatsappClickModel::whereDate('created_at', today())->count();

            return [
                'all_clicks' => $allClicks,
                'today_clicks' => $todayClicks,
            ];
        } else {
            return [
                'all_clicks' => 0,
                'today_clicks' => 0,
            ];
        }
    }
    public function getClicks($request)
    {
        $agentClicksCount = $this->agentClickModel::count();

        if ($agentClicksCount > 0) {
            $allClicks = $agentClicksCount;
            $todayClicks = $this->agentClickModel::whereDate('created_at', today())->count();

            return [
                'all_clicks' => $allClicks,
                'today_clicks' => $todayClicks,
            ];
        } else {
            return [
                'all_clicks' => 0,
                'today_clicks' => 0,
            ];
        }
    }

    public function getBlogViewCounts($request)
    {
        $blogViewsCount = $this->blogViewModel::count();

        if ($blogViewsCount > 0) {
            $allViews = $blogViewsCount;
            $todayViews = $this->blogViewModel::whereDate('created_at', today())->count();

            return [
                'all_views' => $allViews,
                'today_views' => $todayViews,
            ];
        } else {
            return [
                'all_views' => 0,
                'today_views' => 0,
            ];
        }
    }

    public function getBrochureDownloadCounts($request)
    {
        $brochuresCount = $this->formModel->where('type', 'brochure')->count();

        if ($brochuresCount > 0) {
            $allDownloads = $brochuresCount;
            $todayDownloads = $this->formModel->where('type', 'brochure')->whereDate('created_at', today())->count();

            return [
                'all_downloads' => $allDownloads,
                'today_downloads' => $todayDownloads,
            ];
        } else {
            return [
                'all_downloads' => 0,
                'today_downloads' => 0,
            ];
        }
    }

    public function getFormFillCount($request)
    {
        $formCount = $this->formModel::count();
        $quizCount = $this->quizModel::count();
        $listCount = $this->listFormModel::count();

        if ($formCount > 0 || $quizCount > 0 || $listCount > 0) {
            $allFills = $formCount + $quizCount + $listCount;

            $todayFormCount = $this->formModel::whereDate('created_at', today())->count();
            $todayQuizCount = $this->quizModel::whereDate('created_at', today())->count();
            $todayListCount = $this->listFormModel::whereDate('created_at', today())->count();

            $todayFills = $todayFormCount + $todayQuizCount + $todayListCount;

            return [
                'all_fills' => $allFills,
                'today_fills' => $todayFills,
            ];
        } else {
            return [
                'all_fills' => 0,
                'today_fills' => 0,
            ];
        }
    }
}

