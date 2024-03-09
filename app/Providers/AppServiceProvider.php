<?php

namespace App\Providers;

use App\Http\Repositories\AboutUs\AboutUsInterface;
use App\Http\Repositories\AboutUs\AboutUsRepository;
use App\Http\Repositories\Admin\AdminInterface;
use App\Http\Repositories\Admin\AdminRepository;
use App\Http\Repositories\AdminAuth\AdminAuthInterface;
use App\Http\Repositories\AdminAuth\AdminAuthRepository;
use App\Http\Repositories\Agent\AgentInterface;
use App\Http\Repositories\Agent\AgentRepository;
use App\Http\Repositories\Amenities\AmenitiesInterface;
use App\Http\Repositories\Amenities\AmenitiesRepository;
use App\Http\Repositories\Availability\AvailabilityInterface;
use App\Http\Repositories\Availability\AvailabilityRepository;
use App\Http\Repositories\Base\BaseInterface;
use App\Http\Repositories\Base\BaseRepository;
use App\Http\Repositories\Blog\BlogInterface;
use App\Http\Repositories\Blog\BlogRepository;
use App\Http\Repositories\Category\CategoryInterface;
use App\Http\Repositories\Category\CategoryRepository;
use App\Http\Repositories\FAQ\FAQInterface;
use App\Http\Repositories\FAQ\FAQRepository;
use App\Http\Repositories\Form\FormInterface;
use App\Http\Repositories\Form\FormRepository;
use App\Http\Repositories\Header\HeaderInterface;
use App\Http\Repositories\Header\HeaderRepository;
use App\Http\Repositories\FormImage\FormImageInterface;
use App\Http\Repositories\FormImage\FormImageRepository;
use App\Http\Repositories\ListForm\ListFormInterface;
use App\Http\Repositories\ListForm\ListFormRepository;
use App\Http\Repositories\Media\MediaRepository;
use App\Http\Repositories\Media\MediaInterface;
use App\Http\Repositories\Community\CommunityInterface;
use App\Http\Repositories\Community\CommunityRepository;
use App\Http\Repositories\Developer\DeveloperInterface;
use App\Http\Repositories\Developer\DeveloperRepository;
use App\Http\Repositories\Overview\OverviewInterface;
use App\Http\Repositories\Overview\OverviewRepository;
use App\Http\Repositories\Permission\PermissionInterface;
use App\Http\Repositories\Permission\PermissionRepository;
use App\Http\Repositories\Product\ProductInterface;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\Quiz\QuizInterface;
use App\Http\Repositories\Quiz\QuizRepository;
use App\Http\Repositories\RentalPeriod\RentalPeriodInterface;
use App\Http\Repositories\RentalPeriod\RentalPeriodRepository;
use App\Http\Repositories\Role\RoleInterface;
use App\Http\Repositories\Role\RoleRepository;
use App\Http\Repositories\Service\ServiceInterface;
use App\Http\Repositories\Service\ServiceRepository;
use App\Http\Repositories\Setting\SettingRepository;
use App\Http\Repositories\Setting\SettingInterface;
use App\Http\Repositories\Slider\SliderInterface;
use App\Http\Repositories\Slider\SliderRepository;
use App\Http\Repositories\Statistics\StatisticsInterface;
use App\Http\Repositories\Statistics\StatisticsRepository;
use App\Http\Repositories\Type\TypeInterface;
use App\Http\Repositories\Type\TypeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseInterface::class, BaseRepository::class);
        $this->app->bind(MediaInterface::class, MediaRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(PermissionInterface::class, PermissionRepository::class);
        $this->app->bind(SettingInterface::class, SettingRepository::class);
        $this->app->bind(AdminAuthInterface::class, AdminAuthRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(RentalPeriodInterface::class, RentalPeriodRepository::class);
        $this->app->bind(TypeInterface::class, TypeRepository::class);
        $this->app->bind(CommunityInterface::class, CommunityRepository::class);
        $this->app->bind(AmenitiesInterface::class, AmenitiesRepository::class);
        $this->app->bind(ServiceInterface::class, ServiceRepository::class);
        $this->app->bind(AgentInterface::class, AgentRepository::class);
        $this->app->bind(DeveloperInterface::class, DeveloperRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(StatisticsInterface::class, StatisticsRepository::class);
        $this->app->bind(SliderInterface::class, SliderRepository::class);
        $this->app->bind(FAQInterface::class, FAQRepository::class);
        $this->app->bind(BlogInterface::class, BlogRepository::class);
        $this->app->bind(FormInterface::class, FormRepository::class);
        $this->app->bind(QuizInterface::class, QuizRepository::class);
        $this->app->bind(AvailabilityInterface::class, AvailabilityRepository::class);
        $this->app->bind(ListFormInterface::class, ListFormRepository::class);
        $this->app->bind(OverviewInterface::class, OverviewRepository::class);
        $this->app->bind(HeaderInterface::class, HeaderRepository::class);
        $this->app->bind(AboutUsInterface::class, AboutUsRepository::class);
        $this->app->bind(FormImageInterface::class, FormImageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
