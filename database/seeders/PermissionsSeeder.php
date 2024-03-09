<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
    {
        $data = [
            // admin
            [
                'name' => 'admin',
                'title' =>[
                    "en" => "admin",
                    "ar" => "المديرون",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'admin.create',
                'title' =>[
                    "en" => "admin.create",
                    "ar" => "اضافة مدير",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'admin.edit',
                'title' =>[
                    "en" => "admin.edit",
                    "ar" => "تعديل مدير",
                ],
                'guard_name' => 'admin',
            ],
            [

                'name' => 'admin.delete',
                'title' =>[
                    "en" => "admin.delete",
                    "ar" => "حذف مدير",
                ],
                'guard_name' => 'admin',
            ],

            // role
            [
                'name' => 'role',
                'title' =>[
                    "en" => "role",
                    "ar" => "الادوار",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'role.create',
                'title' =>[
                    "en" => "role.create",
                    "ar" => "اضافة دور",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'role.edit',
                'title' =>[
                    "en" => "role.edit",
                    "ar" => "تعديل دور",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'role.delete',
                'title' =>[
                    "en" => "role.delete",
                    "ar" => "حذف دور",
                ],
                'guard_name' => 'admin',
            ],

            // category
            [
                'name' => 'category',
                'title' =>[
                    "en" => "category",
                    "ar" => "الفئات",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'category.edit',
                'title' =>[
                    "en" => "category.edit",
                    "ar" => "تعديل فئة",
                ],
                'guard_name' => 'admin',
            ],

            // type
            [
                'name' => 'type',
                'title' =>[
                    "en" => "type",
                    "ar" => "الانواع",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'type.create',
                'title' =>[
                    "en" => "type.create",
                    "ar" => "اضافة نوع",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'type.edit',
                'title' =>[
                    "en" => "type.edit",
                    "ar" => "تعديل نوع",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'type.delete',
                'title' =>[
                    "en" => "type.delete",
                    "ar" => "حذف نوع",
                ],
                'guard_name' => 'admin',
            ],


            // community
            [
                'name' => 'community',
                'title' =>[
                    "en" => "community",
                    "ar" => "المناطق",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'community.create',
                'title' =>[
                    "en" => "community.create",
                    "ar" => "اضافة منطقة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'community.edit',
                'title' =>[
                    "en" => "community.edit",
                    "ar" => "تعديل منطقة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'community.delete',
                'title' =>[
                    "en" => "community.delete",
                    "ar" => "حذف منطقة",
                ],
                'guard_name' => 'admin',
            ],
            // amenities
            [
                'name' => 'amenities',
                'title' =>[
                    "en" => "amenities",
                    "ar" => "مرفقات",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'amenities.create',
                'title' =>[
                    "en" => "amenities.create",
                    "ar" => "اضافة مرفق",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'amenities.edit',
                'title' =>[
                    "en" => "amenities.edit",
                    "ar" => "تعديل مرفق",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'amenities.delete',
                'title' =>[
                    "en" => "amenities.delete",
                    "ar" => "حذف مرفق",
                ],
                'guard_name' => 'admin',
            ],
            // service
            [
                'name' => 'service',
                'title' =>[
                    "en" => "service",
                    "ar" => "الخدمات",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'service.create',
                'title' =>[
                    "en" => "service.create",
                    "ar" => "اضافة خدمة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'service.edit',
                'title' =>[
                    "en" => "service.edit",
                    "ar" => "تعديل خدمة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'service.delete',
                'title' =>[
                    "en" => "service.delete",
                    "ar" => "حذف خدمة",
                ],
                'guard_name' => 'admin',
            ],

            // product
            [
                'name' => 'product',
                'title' =>[
                    "en" => "product",
                    "ar" => "المنتجات",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'product.create',
                'title' =>[
                    "en" => "product.create",
                    "ar" => "اضافة منتج",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'product.edit',
                'title' =>[
                    "en" => "product.edit",
                    "ar" => "تعديل منتج",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'product.delete',
                'title' =>[
                    "en" => "product.delete",
                    "ar" => "حذف منتج",
                ],
                'guard_name' => 'admin',
            ],

            // developer
            [
                'name' => 'developer',
                'title' =>[
                    "en" => "developer",
                    "ar" => "المنشئين",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'developer.create',
                'title' =>[
                    "en" => "developer.create",
                    "ar" => "اضافة منشىء",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'developer.edit',
                'title' =>[
                    "en" => "developer.edit",
                    "ar" => "تعديل منشىء",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'developer.delete',
                'title' =>[
                    "en" => "developer.delete",
                    "ar" => "حذف منشىء",
                ],
                'guard_name' => 'admin',
            ],

            // agent
            [
                'name' => 'agent',
                'title' =>[
                    "en" => "agent",
                    "ar" => "السماسرة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'agent.create',
                'title' =>[
                    "en" => "agent.create",
                    "ar" => "اضافة سمسار",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'agent.edit',
                'title' =>[
                    "en" => "agent.edit",
                    "ar" => "تعديل سمسار",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'agent.delete',
                'title' =>[
                    "en" => "agent.delete",
                    "ar" => "حذف سمسار",
                ],
                'guard_name' => 'admin',
            ],

            // blog
            [
                'name' => 'blog',
                'title' =>[
                    "en" => "blog",
                    "ar" => "المدونات",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'blog.create',
                'title' =>[
                    "en" => "blog.create",
                    "ar" => "اضافة مدونة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'blog.edit',
                'title' =>[
                    "en" => "blog.edit",
                    "ar" => "تعديل مدونة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'blog.delete',
                'title' =>[
                    "en" => "blog.delete",
                    "ar" => "حذف مدونة",
                ],
                'guard_name' => 'admin',
            ],

            // faq
            [
                'name' => 'faq',
                'title' =>[
                    "en" => "faq",
                    "ar" => "الاسئلة الاكثر شيوعا",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'faq.create',
                'title' =>[
                    "en" => "faq.create",
                    "ar" => "اضافة سؤال",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'faq.edit',
                'title' =>[
                    "en" => "faq.edit",
                    "ar" => "تعديل سؤال",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'faq.delete',
                'title' =>[
                    "en" => "faq.delete",
                    "ar" => "حذف سؤال",
                ],
                'guard_name' => 'admin',
            ],


            // availability
            [
                'name' => 'availability',
                'title' =>[
                    "en" => "availability",
                    "ar" => "الحصائص",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'availability.create',
                'title' =>[
                    "en" => "availability.create",
                    "ar" => "اضافة خاصية",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'availability.delete',
                'title' =>[
                    "en" => "availability.delete",
                    "ar" => "حذف خاصية",
                ],
                'guard_name' => 'admin',
            ],

            // quiz
            [
                'name' => 'quiz',
                'title' =>[
                    "en" => "quiz",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'quiz.read',
                'title' =>[
                    "en" => "quiz.read",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'quiz.un_read',
                'title' =>[
                    "en" => "quiz.un_read",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'quiz.delete',
                'title' =>[
                    "en" => "quiz.delete",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],

            // form
            [
                'name' => 'form',
                'title' =>[
                    "en" => "form",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'form.read',
                'title' =>[
                    "en" => "form.read",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'form.un_read',
                'title' =>[
                    "en" => "form.un_read",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'form.delete',
                'title' =>[
                    "en" => "faq.delete",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],


            // add_list
            [
                'name' => 'add_list',
                'title' =>[
                    "en" => "add_list",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'add_list.read',
                'title' =>[
                    "en" => "add_list.read",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'add_list.un_read',
                'title' =>[
                    "en" => "add_list.un_read",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'add_list.delete',
                'title' =>[
                    "en" => "add_list.delete",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            // rental
            [
                'name' => 'rental',
                'title' =>[
                    "en" => "rental",
                    "ar" => "فترة الايجار",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'rental.create',
                'title' =>[
                    "en" => "rental.create",
                    "ar" => "اضافة قترة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'rental.edit',
                'title' =>[
                    "en" => "rental.edit",
                    "ar" => "تعديل فترة",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'rental.delete',
                'title' =>[
                    "en" => "rental.delete",
                    "ar" => "حذف فترة",
                ],
                'guard_name' => 'admin',
            ],

            //home
            [
                'name' => 'home',
                'title' =>[
                    "en" => "home",
                    "ar" => "الصفحة الرئيسية",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'home.edit',
                'title' =>[
                    "en" => "home.edit",
                    "ar" => "تعديل الصفحة",
                ],
                'guard_name' => 'admin',
            ],
            // statistics
            [
                'name' => 'statistics',
                'title' =>[
                    "en" => "statistics",
                    "ar" => "الاحصاءيات",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'statistics.create',
                'title' =>[
                    "en" => "statistics.create",
                    "ar" => "اضافة احصائية",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'statistics.edit',
                'title' =>[
                    "en" => "statistics.edit",
                    "ar" => "تعديل احصائية",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'statistics.delete',
                'title' =>[
                    "en" => "statistics.delete",
                    "ar" => "حذف سمسار",
                ],
                'guard_name' => 'admin',
            ],
            // productform
            [
                'name' => 'productform',
                'title' => [
                    "en" => "productform",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'productform.edit',
                'title' => [
                    "en" => "productform.edit",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
            [
                'name' => 'productform.delete',
                'title' => [
                    "en" => "productform.delete",
                    "ar" => "",
                ],
                'guard_name' => 'admin',
            ],
        ];
        foreach ($data as $permissionData) {
            $existingPermission = Permission::where('name', $permissionData['name'])
                ->where('guard_name', $permissionData['guard_name'])
                ->first();
            if ($existingPermission) {
                $existingPermission->update([
                    'title' => $permissionData['title'],
                ]);
            } else {
                Permission::create([
                    'name' => $permissionData['name'],
                    'title' => $permissionData['title'],
                    'guard_name' => $permissionData['guard_name'],
                ]);
            }
        }
    }
}

