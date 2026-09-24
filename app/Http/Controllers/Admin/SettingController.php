<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'site_name' => config('app.name', 'LokalMart'),
            'site_description' => 'Marketplace lokal untuk jual beli barang dengan mudah dan aman melalui COD.',
            'contact_email' => 'halo@lokalmart.id',
            'contact_phone' => '+62 812-3456-7890',
            'maintenance_mode' => false,
            'max_images_per_product' => 5,
            'max_file_size' => 2048,
            'auto_approve_products' => false,
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(\Illuminate\Http\Request $request): RedirectResponse
    {
        // In a real app, you'd save to database or config file
        return back()->with('success', 'Pengaturan berhasil diperbarui');
    }
}