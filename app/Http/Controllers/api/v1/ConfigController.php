<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\ProductManager;
use App\Http\Controllers\Controller;
use App\Model\Currency;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function configuration(){
        $currency=Currency::all();
        return response()->json([
            'system_default_currency' => (int)\App\Model\BusinessSetting::where('type', 'system_default_currency')->first()->value,
            'base_urls'=>[
                'product_image_url'=>ProductManager::product_image_path('product'),
                'product_thumbnail_url'=>ProductManager::product_image_path('thumbnail'),
                'brand_image_url'=>asset('storage/app/public/brand'),
                'customer_image_url'=>asset('storage/app/public/profile'),
                'banner_image_url'=>asset('storage/app/public/banner'),
                'category_image_url'=>asset('storage/app/public/category'),
                'review_image_url'=>asset('storage/app/public'),
                'seller_image_url'=>asset('storage/app/public/seller'),
                'shop_image_url'=>asset('storage/app/public/shop'),
                'notification_image_url'=>asset('storage/app/public/notification'),
            ],
            'static_urls'=>[
                'about_us'=>route('about-us'),
                'faq'=>route('helpTopic'),
                'terms_&_conditions'=>route('terms'),
                'contact_us'=>route('contacts'),
                'brands'=>route('brands'),
                'categories'=>route('categories'),
                'customer_account'=>route('user-account'),
            ],
            'currency_list'=>$currency,
            'language'=>[
                'list'=>['bn'=>'বাংলা','en'=>'English'],
                'data'=>[
                    'bn'=>[
                        'Home' => 'বাড়ি',
                    ],
                    'en'=>[
                        'Home' => 'Home',
                        'sign_in' => 'Sign In',
                        'my_cart' => 'My Cart',
                        'shipping_method' => 'Shipping Method',
                        'Banner' => 'Banner',
                        'add_main_banner' => 'Add Main Banner',
                        'add_footer_banner' => 'Add Footer Banner',
                        'main_banner _form' => 'Main Banner Form',
                        'banner_url' => 'Banner Url',
                        'banner_type' => 'Banner Type',
                        'published' => 'Published',
                        'main_banner_image' => 'Main Banner Image',
                        'footer_banner_form' => 'Footer Banner Form',
                        'footer_banner_image' => 'Footer Banner Image',
                        'banner_table' => 'Banner Table',
                        'banner_photo' => 'Banner Photo',
                        'categories' => 'Categories',
                        'all_categories' => 'All Categories',
                        'latest_products' => 'Latest products',
                        'more_products' => 'More products',
                        'brands' => 'Brands',
                        'brand_update' => 'Brand Update',
                        'view_all' => 'View All',
                        'brand' => 'Brand',
                        'brand_form' => 'Brand Form',
                        'name' => 'Name',
                        'brand_logo' => 'Brand Logo',
                        'brand_table' => 'Brands Table',
                        'sl' => 'SL#',
                        'image' => 'Image',
                        'action' => 'Action',
                        'save' => 'Save',
                        'update' => 'Update',
                        'category' => 'Category',
                        'icon' => 'Icon',
                        'category_form' => 'Category Form',
                        'category_table' => 'Category Table',
                        'slug' => 'Slug',
                        'sub_category' => 'Sub Category',
                        'sub_category_form' => 'Sub Category Form',
                        'sub_category_table' => 'Sub Category Table',
                        'select_category_name' => 'Select Category Name',
                        'cash_on_delivery' => 'Cash on Delivery',
                        'ssl_commerz_payment' => 'SSLCOMMERZ Payment',
                        'paypal' => 'Paypal Payment',
                        'stripe' => 'Stripe Payment',
                        'paytm' => 'Paytm Payment',
                    ]
                ]
            ]
        ]);
    }
}
