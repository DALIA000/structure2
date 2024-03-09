<?php

namespace App\Http\Repositories\Setting;

interface SettingInterface{
    public function model($request, $slug);
    public function edit_contacts($request);
    public function edit_currency($request);
    public function edit_terms($request);
    public function edit_privacy($request);
    public function brochure ($request);
    public function about ($request);
    public function edit_brochure ($request);
    public function edit_about ($request);
    public function edit_statistics_title($request);
    public function edit_table_title($request);
}
